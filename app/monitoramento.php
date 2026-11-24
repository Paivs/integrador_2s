<?php
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['usuario_logado']) ||$_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Identifica o ID do usuário logado de forma compatível com a sessão
$idUsuario =$_SESSION['ID_USUARIO'] ?? $_SESSION['id_usuario'] ?? $_SESSION['usuario_id'] ?? null;
if (!$idUsuario && !empty($_SESSION['email'])) {$usuario = read($pdo, 'usuarios', 'email = ?', [$_SESSION['email']]);
    $idUsuario =$usuario['ID_USUARIO'] ?? null;
}
if (!$idUsuario && !empty($_SESSION['nome'])) {$usuario = read($pdo, 'usuarios', 'nome = ?', [$_SESSION['nome']]);
    $idUsuario =$usuario['ID_USUARIO'] ?? null;
}
$idUsuario = $idUsuario ? (int) $idUsuario : null;

$mensagem = '';$tipoMensagem = '';

// Processamento dos formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao =$_POST['acao'] ?? '';

    try {
        if ($acao === 'cadastrar_painel') {
            $quantidade = max(1, (int) ($_POST['quantidade'] ?? 1));
            $caracteristicas = trim($_POST['modelo_painel'] ?? '');
            $dataInstalacao =$_POST['data_intalacao'] ?: date('Y-m-d');
            $status = substr(trim($_POST['status_sistema'] ?? 'Ativo'), 0, 20);

            if ($caracteristicas === '') {
                throw new Exception('Informe o modelo e as características dos painéis.');
            }

            // Usa substr() nativo (compatível sem extensão mbstring)
            $descricaoCompleta = substr("{$quantidade}x {$caracteristicas}", 0, 100);

            $dadosPainel = [
                'modelo_painel'  => $descricaoCompleta,
                'data_intalacao' => $dataInstalacao,
                'status_sistema' => $status,
            ];
            if ($idUsuario !== null) {
                $dadosPainel['ID_USUARIO'] =$idUsuario;
            }

            create($pdo, 'fotovoltaicos',$dadosPainel);

            $mensagem = 'Painéis registrados com sucesso!';
            $tipoMensagem = 'sucesso';
        }

        if ($acao === 'lancar_energia') {
            $idFotovoltaico = (int) ($_POST['ID_fotovoltaicos'] ?? 0);
            $dataRegistro =$_POST['data_registro'] ?: date('Y-m-d');
            $gerada = (int) ($_POST['energia_gerada'] ?? 0);
            $consumida = (int) ($_POST['energia_consumida'] ?? 0);

            if ($idFotovoltaico <= 0) {
                throw new Exception('Selecione um sistema de painéis válido.');
            }
            if ($gerada < 0 ||$consumida < 0) {
                throw new Exception('Os valores de geração e consumo não podem ser negativos.');
            }

            create($pdo, 'registros', [
                'ID_fotovoltaicos'  => $idFotovoltaico,
                'data_registro'     => $dataRegistro,
                'energia_gerada'    => $gerada,
                'energia_consumida' => $consumida,
            ]);

            $mensagem = 'Lançamento de geração e consumo salvo com sucesso!';
            $tipoMensagem = 'sucesso';
        }
    } catch (Throwable $e) {$mensagem = 'Erro: ' . $e->getMessage();$tipoMensagem = 'erro';
    }
}

// 1. Busca os painéis cadastrados
if ($idUsuario !== null) {
    $paineis = readAll($pdo, 'fotovoltaicos', 'ID_USUARIO = ? ORDER BY ID_fotovoltaicos DESC', [$idUsuario]);
} else {
    $paineis = readAll($pdo, 'fotovoltaicos', '1=1 ORDER BY ID_fotovoltaicos DESC');
}

// 2. Busca o histórico mensal agrupado (geração x consumo)
$sqlMensal = "
    SELECT
        DATE_FORMAT(r.data_registro, '%Y-%m') AS mes,
        SUM(r.energia_gerada) AS total_gerado,
        SUM(r.energia_consumida) AS total_consumido,
        COUNT(r.ID_REGISTRO) AS qtd_lancamentos
    FROM registros r
    INNER JOIN fotovoltaicos f ON f.ID_fotovoltaicos = r.ID_fotovoltaicos
";
$paramsMensal = [];
if ($idUsuario !== null) {$sqlMensal .= " WHERE f.ID_USUARIO = ?";
    $paramsMensal[] =$idUsuario;
}
$sqlMensal .= " GROUP BY DATE_FORMAT(r.data_registro, '%Y-%m') ORDER BY mes DESC";

$stmtMensal = $pdo->prepare($sqlMensal);
$stmtMensal->execute($paramsMensal);
$historicoMensal =$stmtMensal->fetchAll();

// 3. Totais gerais para comparação
$totalGerado = 0;
$totalConsumido = 0;
$maiorValorMes = 1;

foreach ($historicoMensal as$linha) {
    $g = (int)$linha['total_gerado'];
    $c = (int)$linha['total_consumido'];
    $totalGerado +=$g;
    $totalConsumido +=$c;
    if ($g >$maiorValorMes) $maiorValorMes =$g;
    if ($c >$maiorValorMes) $maiorValorMes =$c;
}

$saldoEnergia = $totalGerado -$totalConsumido;
$percentualAtendido =$totalConsumido > 0 ? round(($totalGerado / $totalConsumido) * 100, 1) : 0;

function formatarMes(string $anoMes): string {
    $partes = explode('-',$anoMes);
    if (count($partes) !== 2) return$anoMes;
    $meses = [
        '01' => 'Jan', '02' => 'Fev', '03' => 'Mar', '04' => 'Abr',
        '05' => 'Mai', '06' => 'Jun', '07' => 'Jul', '08' => 'Ago',
        '09' => 'Set', '10' => 'Out', '11' => 'Nov', '12' => 'Dez'
    ];
    return ($meses[$partes[1]] ?? $partes[1]) . '/' .$partes[0];
}

// Dados em ordem cronológica para o gráfico
$dadosGrafico = array_reverse($historicoMensal);$labelsGrafico = [];
$geradaGrafico = [];$consumidaGrafico = [];

foreach ($dadosGrafico as$item) {
    $labelsGrafico[] = formatarMes($item['mes']);
    $geradaGrafico[] = (int)$item['total_gerado'];
    $consumidaGrafico[] = (int)$item['total_consumido'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monitoramento - SolarControl</title>
  <link rel="stylesheet" href="CSS/monitoramento.css">
</head>
<body>
  <?php include __DIR__ . '/menu.php'; ?>

  <main class="conteudo">
    <div class="container">
      <header class="cabecalho">
        <h1>Monitoramento</h1>
        <p>Acompanhe seus painéis, lance geração/consumo e compare o histórico mensal.</p>
      </header>

      <?php if ($mensagem !== ''): ?>
        <div class="alerta alerta-<?php echo htmlspecialchars($tipoMensagem); ?>">
          <?php echo htmlspecialchars($mensagem); ?>
        </div>
      <?php endif; ?>

      <!-- Comparação geral entre energia gerada e consumida -->
      <section class="grade-resumo">
        <div class="card-resumo">
          <span>Energia Gerada</span>
          <strong><?php echo number_format($totalGerado, 0, ',', '.'); ?> kWh</strong>
          <small>Total acumulado</small>
        </div>

        <div class="card-resumo">
          <span>Energia Consumida</span>
          <strong><?php echo number_format($totalConsumido, 0, ',', '.'); ?> kWh</strong>
          <small>Total acumulado</small>
        </div>

        <div class="card-resumo">
          <span>Saldo (Gerada - Consumida)</span>
          <strong class="<?php echo $saldoEnergia >= 0 ? 'positivo' : 'negativo'; ?>">
            <?php echo ($saldoEnergia >= 0 ? '+' : '') . number_format($saldoEnergia, 0, ',', '.'); ?> kWh
          </strong>
          <small>
            <?php echo $saldoEnergia >= 0 ? 'Superávit energético' : 'Déficit energético'; ?>
            (<?php echo $percentualAtendido; ?>% do consumo)
          </small>
        </div>

        <div class="card-resumo">
          <span>Sistemas Registrados</span>
          <strong><?php echo count($paineis); ?></strong>
          <small>Conjuntos de painéis</small>
        </div>
      </section>

      <!-- Formulários: Registro de Painéis e Lançamento de Energia -->
      <section class="grade-formularios">
        <div class="painel-box">
          <h2>Registrar Painéis</h2>
          <form method="POST" class="formulario">
            <input type="hidden" name="acao" value="cadastrar_painel">

            <div class="campo-duplo">
              <div class="campo">
                <label for="quantidade">Quantidade</label>
                <input type="number" id="quantidade" name="quantidade" min="1" value="1" required>
              </div>
              <div class="campo">
                <label for="data_intalacao">Data de Instalação</label>
                <input type="date" id="data_intalacao" name="data_intalacao" value="<?php echo date('Y-m-d'); ?>" required>
              </div>
            </div>

            <div class="campo">
              <label for="modelo_painel">Modelo e Características</label>
              <input type="text" id="modelo_painel" name="modelo_painel" placeholder="Ex: Canadian Solar 550W Monocristalino" maxlength="90" required>
            </div>

            <div class="campo">
              <label for="status_sistema">Status do Sistema</label>
              <select id="status_sistema" name="status_sistema">
                <option value="Ativo">Ativo</option>
                <option value="Manutenção">Manutenção</option>
                <option value="Inativo">Inativo</option>
              </select>
            </div>

            <button type="submit" class="btn-primario">Salvar Painéis</button>
          </form>
        </div>

        <div class="painel-box">
          <h2>Lançar Geração e Consumo</h2>
          <form method="POST" class="formulario">
            <input type="hidden" name="acao" value="lancar_energia">

            <div class="campo">
              <label for="ID_fotovoltaicos">Sistema de Painéis</label>
              <select id="ID_fotovoltaicos" name="ID_fotovoltaicos" required>
                <?php if (empty($paineis)): ?>
                  <option value="">Cadastre um painel primeiro</option>
                <?php else: ?>
                  <?php foreach ($paineis as$p): ?>
                    <option value="<?php echo (int) $p['ID_fotovoltaicos']; ?>">
                      #<?php echo (int) $p['ID_fotovoltaicos']; ?> - <?php echo htmlspecialchars($p['modelo_painel']); ?>
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="campo">
              <label for="data_registro">Data do Registro</label>
              <input type="date" id="data_registro" name="data_registro" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="campo-duplo">
              <div class="campo">
                <label for="energia_gerada">Energia Gerada (kWh)</label>
                <input type="number" id="energia_gerada" name="energia_gerada" min="0" required>
              </div>
              <div class="campo">
                <label for="energia_consumida">Energia Consumida (kWh)</label>
                <input type="number" id="energia_consumida" name="energia_consumida" min="0" required>
              </div>
            </div>

            <button type="submit" class="btn-primario" <?php echo empty($paineis) ? 'disabled' : ''; ?>>
              Registrar Lançamento
            </button>
          </form>
        </div>
      </section>

      <!-- Histórico Mensal -->
      <section class="painel-box">
        <h2>Histórico Mensal (Gerada vs. Consumida)</h2>

        <?php if (empty($historicoMensal)): ?>
          <p class="vazio">Nenhum lançamento de geração e consumo registrado ainda.</p>
        <?php else: ?>
          <div class="tabela-wrapper">
            <table class="tabela">
              <thead>
                <tr>
                  <th>Mês</th>
                  <th>Gerada (kWh)</th>
                  <th>Consumida (kWh)</th>
                  <th>Saldo (kWh)</th>
                  <th>Comparação Visual</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($historicoMensal as$item): ?>
                  <?php
                    $ger = (int) $item['total_gerado'];$con = (int) $item['total_consumido'];$sal = $ger -$con;
                    $largGer = round(($ger / $maiorValorMes) * 100);$largCon = round(($con / $maiorValorMes) * 100);
                  ?>
                  <tr>
                    <td><strong><?php echo htmlspecialchars(formatarMes($item['mes'])); ?></strong></td>
                    <td><?php echo number_format($ger, 0, ',', '.'); ?> kWh</td>
                    <td><?php echo number_format($con, 0, ',', '.'); ?> kWh</td>
                    <td class="<?php echo $sal >= 0 ? 'positivo' : 'negativo'; ?>">
                      <?php echo ($sal >= 0 ? '+' : '') . number_format($sal, 0, ',', '.'); ?> kWh
                    </td>
                    <td>
                      <div class="comparacao-barras">
                        <div class="barra-linha">
                          <span class="legenda">Ger.</span>
                          <div class="trilha"><div class="barra barra-gerada" style="width: <?php echo $largGer; ?>%;"></div></div>
                        </div>
                        <div class="barra-linha">
                          <span class="legenda">Con.</span>
                          <div class="trilha"><div class="barra barra-consumida" style="width: <?php echo $largCon; ?>%;"></div></div>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>

      <!-- Lista de Painéis Registrados -->
      <section class="painel-box">
        <h2>Painéis Registrados</h2>

        <?php if (empty($paineis)): ?>
          <p class="vazio">Nenhum painel registrado até o momento.</p>
        <?php else: ?>
          <div class="tabela-wrapper">
            <table class="tabela">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Quantidade e Características</th>
                  <th>Instalação</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($paineis as$p): ?>
                  <tr>
                    <td>#<?php echo (int) $p['ID_fotovoltaicos']; ?></td>
                    <td><?php echo htmlspecialchars($p['modelo_painel']); ?></td>
                    <td><?php echo $p['data_intalacao'] ? date('d/m/Y', strtotime($p['data_intalacao'])) : '-'; ?></td>
                    <td><span class="badge"><?php echo htmlspecialchars($p['status_sistema']); ?></span></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>

      <!-- Gráfico de Comparação Mensal -->
      <section class="painel-box">
        <h2>Gráfico: Energia Gerada vs. Consumida</h2>
        <?php if (empty($dadosGrafico)): ?>
          <p class="vazio">Faça pelo menos um lançamento acima para visualizar o gráfico.</p>
        <?php else: ?>
          <div class="grafico-container">
            <canvas id="graficoEnergia"></canvas>
          </div>
        <?php endif; ?>
      </section>
    </div>
  </main>

  <?php if (!empty($dadosGrafico)): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx = document.getElementById('graficoEnergia');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($labelsGrafico); ?>,
          datasets: [
            {
              label: 'Energia Gerada (kWh)',
              data: <?php echo json_encode($geradaGrafico); ?>,
              backgroundColor: '#284b36',
              borderRadius: 6
            },
            {
              label: 'Energia Consumida (kWh)',
              data: <?php echo json_encode($consumidaGrafico); ?>,
              backgroundColor: '#d9822b',
              borderRadius: 6
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'kWh'
              }
            }
          }
        }
      });
    </script>
  <?php endif; ?>
</body>
</html>
