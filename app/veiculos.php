<?php

require_once __DIR__ . '/init.php';
protegerPagina();

$paginaAtual = 'veiculos';
$busca = trim($_GET['busca'] ?? '');
$mensagem = '';
$mensagemErro = false;

if (($_GET['mensagem'] ?? '') === 'cadastrado') {
    $mensagem = 'Veículo cadastrado com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'editado') {
    $mensagem = 'Veículo atualizado com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'excluido') {
    $mensagem = 'Veículo excluído com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'diagnostico_salvo') {
    $mensagem = 'Diagnóstico técnico salvo com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'erro') {
    $mensagem = 'Não foi possível salvar o diagnóstico.';
    $mensagemErro = true;
}

// O funcionário enxerga todos. O cliente enxerga somente os próprios veículos.
$sql = 'SELECT veiculos.*, clientes.nome AS proprietario
        FROM veiculos
        INNER JOIN clientes ON clientes.id = veiculos.cliente_id';
$parametros = [];
$filtros = [];

if (usuarioEhCliente()) {
    $filtros[] = 'veiculos.cliente_id = ?';
    $parametros[] = $_SESSION['cliente_id'];
}

if ($busca !== '') {
    $filtros[] = '(veiculos.modelo LIKE ?
                    OR veiculos.marca LIKE ?
                    OR veiculos.placa LIKE ?
                    OR clientes.nome LIKE ?)';
    $termo = '%' . $busca . '%';
    array_push($parametros, $termo, $termo, $termo, $termo);
}

if (count($filtros) > 0) {
    $sql .= ' WHERE ' . implode(' AND ', $filtros);
}

$sql .= ' ORDER BY veiculos.id DESC';
$comando = $pdo->prepare($sql);
$comando->execute($parametros);
$veiculos = $comando->fetchAll();

// Conta quantos problemas cada veículo tem cadastrados
$contagemProblemas = [];
$diagnosticoVeiculoId = (int) ($_GET['diagnostico'] ?? 0);
$veiculoSelecionado = null;
$itensDiagnostico = [];
$idsComProblema = [];

try {
    $stmtContagem = $pdo->query(
        "SELECT veiculo_id, COUNT(*) AS total
         FROM veiculo_diagnosticos
         WHERE situacao = 'Com problema'
         GROUP BY veiculo_id"
    );
    $contagemProblemas = $stmtContagem->fetchAll(PDO::FETCH_KEY_PAIR);

    if ($diagnosticoVeiculoId > 0) {
        foreach ($veiculos as $v) {
            if ((int) $v['id'] === $diagnosticoVeiculoId) {
                $veiculoSelecionado = $v;
                break;
            }
        }

        if ($veiculoSelecionado) {
            if (usuarioEhFuncionario()) {
                // Funcionário vê todos os códigos para decidir o que precisa arrumar
                $stmtCodigos = $pdo->query('SELECT * FROM codigos_falha ORDER BY CAST(codigo AS UNSIGNED)');
                $itensDiagnostico = $stmtCodigos->fetchAll();

                $stmtMarcados = $pdo->prepare(
                    "SELECT codigo_falha_id
                     FROM veiculo_diagnosticos
                     WHERE veiculo_id = ? AND situacao = 'Com problema'"
                );
                $stmtMarcados->execute([$diagnosticoVeiculoId]);
                $idsComProblema = array_map('intval', $stmtMarcados->fetchAll(PDO::FETCH_COLUMN));
            } else {
                // Cliente vê SOMENTE os itens que o funcionário marcou que precisam de reparo
                $stmtClienteDiag = $pdo->prepare(
                    "SELECT cf.codigo, cf.componente, cf.descricao_falha, vd.situacao
                     FROM veiculo_diagnosticos vd
                     INNER JOIN codigos_falha cf ON cf.id = vd.codigo_falha_id
                     WHERE vd.veiculo_id = ? AND vd.situacao = 'Com problema'
                     ORDER BY CAST(cf.codigo AS UNSIGNED)"
                );
                $stmtClienteDiag->execute([$diagnosticoVeiculoId]);
                $itensDiagnostico = $stmtClienteDiag->fetchAll();

                // Se não houver nenhum problema marcado, não exibe a tabela para o cliente
                if (count($itensDiagnostico) === 0) {
                    $veiculoSelecionado = null;
                }
            }
        }
    }
  } catch (Throwable $e) {
      $contagemProblemas = [];
      $veiculoSelecionado = null;
      $mensagem = 'Erro ao abrir diagnóstico: ' . $e->getMessage();
      $mensagemErro = true;
  }

$queryBusca = $busca !== '' ? '&busca=' . urlencode($busca) : '';
$urlFechar = $busca !== '' ? 'veiculos.php?busca=' . urlencode($busca) : 'veiculos.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veículos | CarCare</title>
  <link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>
  <div class="app">
    <?php include __DIR__ . '/parciais/nav.php'; ?>

    <main class="conteudo">
      <section class="pagina">
        <?php if ($mensagem !== ''): ?>
          <div class="alerta <?php echo $mensagemErro ? 'erro' : 'sucesso'; ?>"><?php echo textoSeguro($mensagem); ?></div>
        <?php endif; ?>

        <header class="cabecalho">
          <div>
            <h1>Proprietários e veículos</h1>
            <p><?php echo usuarioEhFuncionario() ? 'Consulte os veículos dos clientes e registre diagnósticos.' : 'Cadastre e acompanhe seus veículos.'; ?></p>
          </div>

          <?php if (usuarioEhCliente()): ?>
            <a class="botao primario" href="cadastro-veiculo.php">Cadastrar veículo</a>
          <?php endif; ?>
        </header>

        <form class="filtros" action="veiculos.php" method="get">
          <label class="busca">
            <img src="imagens/icone-busca.png" alt="">
            <input name="busca" type="search" value="<?php echo textoSeguro($busca); ?>" placeholder="Buscar por proprietário, placa ou veículo">
          </label>
          <span><?php echo count($veiculos); ?> veículo(s)</span>
        </form>

        <?php if (count($veiculos) === 0): ?>
          <div class="vazio">
            <img class="ilustracao" src="imagens/estado-sem-veiculo.png" alt="Ilustração de carro">
            <h2>Nenhum veículo encontrado</h2>
            <p><?php echo usuarioEhCliente() ? 'Cadastre um veículo para começar.' : 'Nenhum cliente possui veículo cadastrado.'; ?></p>
          </div>
        <?php else: ?>
          <div class="tabela-container">
            <table>
              <thead>
                <tr>
                  <th>Veículo</th>
                  <th>Placa</th>
                  <th>Proprietário</th>
                  <th>Quilometragem</th>
                  <th>Diagnóstico</th>
                  <?php if (usuarioEhCliente()): ?><th>Ações</th><?php endif; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($veiculos as $veiculo): ?>
                  <?php $qtdProblemas = (int) ($contagemProblemas[$veiculo['id']] ?? 0); ?>
                  <tr>
                    <td>
                      <strong><?php echo textoSeguro(trim($veiculo['marca'] . ' ' . $veiculo['modelo'])); ?></strong>
                      <small>Ano <?php echo intval($veiculo['ano']); ?></small>
                    </td>
                    <td><span class="placa"><?php echo textoSeguro($veiculo['placa']); ?></span></td>
                    <td><?php echo textoSeguro($veiculo['proprietario']); ?></td>
                    <td><?php echo number_format($veiculo['quilometragem'], 0, ',', '.'); ?> km</td>

                    <td>
                      <?php if (usuarioEhFuncionario()): ?>
                        <a class="link-diagnostico <?php echo $qtdProblemas > 0 ? 'com-pendencia' : ''; ?>"
                           href="veiculos.php?diagnostico=<?php echo (int) $veiculo['id'] . $queryBusca; ?>#bloco-diagnostico">
                          <?php echo $qtdProblemas > 0 ? "Avaliar ({$qtdProblemas} pendências)" : 'Avaliar'; ?>
                        </a>
                      <?php elseif ($qtdProblemas > 0): ?>
                        <a class="link-diagnostico com-pendencia"
                           href="veiculos.php?diagnostico=<?php echo (int) $veiculo['id'] . $queryBusca; ?>#bloco-diagnostico">
                          Ver problemas (<?php echo $qtdProblemas; ?>)
                        </a>
                      <?php else: ?>
                        <span class="sem-pendencia">Sem apontamentos</span>
                      <?php endif; ?>
                    </td>

                    <?php if (usuarioEhCliente()): ?>
                      <td>
                        <div class="acoes-tabela">
                          <a href="editar-veiculo.php?id=<?php echo $veiculo['id']; ?>">Editar</a>

                          <form action="excluir-veiculo.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $veiculo['id']; ?>">
                            <button type="submit">Excluir</button>
                          </form>
                        </div>
                      </td>
                    <?php endif; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>

        <?php if ($veiculoSelecionado): ?>
          <section class="bloco-diagnostico" id="bloco-diagnostico">
            <div class="diagnostico-topo">
              <div>
                <h2>
                  Diagnóstico técnico —
                  <?php echo textoSeguro(trim($veiculoSelecionado['marca'] . ' ' . $veiculoSelecionado['modelo'])); ?>
                  (<?php echo textoSeguro($veiculoSelecionado['placa']); ?>)
                </h2>
                <p>
                  <?php echo usuarioEhFuncionario()
                      ? 'Selecione apenas os componentes que precisam de reparo e clique em salvar.'
                      : 'Componentes identificados pela oficina que necessitam de reparo.'; ?>
                </p>
              </div>
              <a class="botao secundario" href="<?php echo textoSeguro($urlFechar); ?>">Fechar</a>
            </div>

            <?php if (usuarioEhFuncionario()): ?>
              <form action="salvar-diagnostico.php" method="post">
                <input type="hidden" name="veiculo_id" value="<?php echo (int) $veiculoSelecionado['id']; ?>">

                <div class="tabela-diagnostico-box">
                  <table class="tabela-diagnostico">
                    <thead>
                      <tr>
                        <th>Código</th>                          
                        <th>Componente</th>
                        <th>Descrição da falha</th>
                        <th>Situação</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($itensDiagnostico as $item): ?>
                        <?php $marcado = in_array((int) $item['id'], $idsComProblema, true); ?>
                        <tr class="<?php echo $marcado ? 'linha-com-problema' : ''; ?>">
                          <td class="centro"><?php echo textoSeguro($item['codigo']); ?></td>
                          <td><?php echo textoSeguro($item['componente']); ?></td>
                          <td><?php echo textoSeguro($item['descricao_falha']); ?></td>
                          <td class="centro">
                            <label class="opcao-diagnostico">
                              <input type="checkbox"
                                     name="problemas[]"
                                     value="<?php echo (int) $item['id']; ?>"
                                     <?php echo $marcado ? 'checked' : ''; ?>>
                              <span class="texto-situacao">
                                <?php echo $marcado ? 'Com problema' : 'Normal'; ?>
                              </span>
                            </label>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <div class="diagnostico-rodape">
                  <button type="submit" class="botao primario">Salvar diagnóstico</button>
                </div>
              </form>

              <script>
                document.querySelectorAll('.opcao-diagnostico input[type="checkbox"]').forEach(chk => {
                  chk.addEventListener('change', function () {
                    const linha = this.closest('tr');
                    const texto = this.nextElementSibling;
                    if (this.checked) {
                      linha.classList.add('linha-com-problema');
                      texto.textContent = 'Com problema';
                    } else {
                      linha.classList.remove('linha-com-problema');
                      texto.textContent = 'Normal';
                    }
                  });
                });
              </script>
            <?php else: ?>
              <div class="tabela-diagnostico-box">
                <table class="tabela-diagnostico">
                  <thead>
                    <tr>
                      <?php if (usuarioEhFuncionario()): ?>
                        <th>Código</th>
                      <?php endif; ?>
                      <th>Componente</th>
                      <th>Descrição da falha</th>
                      <th>Situação</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($itensDiagnostico as $item): ?>
                      <tr class="linha-com-problema">
                        <td><?php echo textoSeguro($item['componente']); ?></td>
                        <td><?php echo textoSeguro($item['descricao_falha']); ?></td>
                        <td class="centro"><span class="texto-problema">Com problema</span></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </section>
        <?php endif; ?>
      </section>
    </main>
  </div>
</body>
</html>