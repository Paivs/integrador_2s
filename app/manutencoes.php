<?php

require_once __DIR__ . '/init.php';
protegerPagina();

$paginaAtual = 'manutencoes';
$mensagem = '';
$mensagemErro = false;

if (($_GET['mensagem'] ?? '') === 'cadastrada') {
    $mensagem = 'Solicitação enviada para a oficina.';
} elseif (($_GET['mensagem'] ?? '') === 'atualizada') {
    $mensagem = 'Status atualizado com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'excluida') {
    $mensagem = 'Manutenção excluída com sucesso.';
} elseif (($_GET['mensagem'] ?? '') === 'erro') {
    $mensagem = 'Não foi possível atualizar o status.';
    $mensagemErro = true;
}

$sql = 'SELECT manutencoes.*,
               veiculos.marca,
               veiculos.modelo,
               veiculos.placa,
               clientes.nome AS proprietario,
               funcionarios.nome AS funcionario
        FROM manutencoes
        INNER JOIN veiculos ON veiculos.id = manutencoes.veiculo_id
        INNER JOIN clientes ON clientes.id = veiculos.cliente_id
        LEFT JOIN funcionarios ON funcionarios.id = manutencoes.funcionario_id';
$parametros = [];

if (usuarioEhCliente()) {
    $sql .= ' WHERE veiculos.cliente_id = ?';
    $parametros[] = $_SESSION['cliente_id'];
}

$sql .= ' ORDER BY manutencoes.data_agendamento DESC';
$comando = $pdo->prepare($sql);
$comando->execute($parametros);
$manutencoes = $comando->fetchAll();

$solicitadas = 0;
$agendadas = 0;
$andamento = 0;
$concluidas = 0;

foreach ($manutencoes as $manutencao) {
    if ($manutencao['status'] === 'Solicitado') {
        $solicitadas++;
    } elseif ($manutencao['status'] === 'Agendado') {
        $agendadas++;
    } elseif ($manutencao['status'] === 'Em andamento') {
        $andamento++;
    } elseif ($manutencao['status'] === 'Concluido') {
        $concluidas++;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manutenções | CarCare</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/manutencoes.css">
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
            <h1><?php echo usuarioEhFuncionario() ? 'Solicitações dos clientes' : 'Minhas manutenções'; ?></h1>
            <p>
              <?php echo usuarioEhFuncionario()
                  ? 'Analise os pedidos e altere o status de cada serviço.'
                  : 'Acompanhe as atualizações feitas pela oficina.'; ?>
            </p>
          </div>

          <?php if (usuarioEhCliente()): ?>
            <a class="botao primario" href="agendar-manutencao.php">Solicitar manutenção</a>
          <?php endif; ?>
        </header>

        <div class="indicadores resumo">
          <article><span>Solicitadas</span><strong><?php echo $solicitadas; ?></strong></article>
          <article><span>Agendadas</span><strong><?php echo $agendadas; ?></strong></article>
          <article><span>Em andamento</span><strong><?php echo $andamento; ?></strong></article>
          <article><span>Concluídas</span><strong><?php echo $concluidas; ?></strong></article>
        </div>

        <?php if (count($manutencoes) === 0): ?>
          <div class="painel central">
            <div class="miniatura"><img src="imagens/icone-manutencao.png" alt=""></div>
            <h2>Nenhuma manutenção registrada</h2>
            <p><?php echo usuarioEhCliente() ? 'Envie sua primeira solicitação.' : 'Nenhum cliente enviou uma solicitação.'; ?></p>
          </div>
        <?php else: ?>
          <div class="tabela-container">
            <table>
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Veículo</th>
                  <?php if (usuarioEhFuncionario()): ?><th>Cliente</th><?php endif; ?>
                  <th>Serviço</th>
                  <th>Status</th>
                  <th><?php echo usuarioEhFuncionario() ? 'Ações' : 'Responsável'; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($manutencoes as $manutencao): ?>
                  <tr>
                    <td><?php echo date('d/m/Y', strtotime($manutencao['data_agendamento'])); ?></td>
                    <td>
                      <strong><?php echo textoSeguro(trim($manutencao['marca'] . ' ' . $manutencao['modelo'])); ?></strong>
                      <small><?php echo textoSeguro($manutencao['placa']); ?></small>
                    </td>

                    <?php if (usuarioEhFuncionario()): ?>
                      <td><?php echo textoSeguro($manutencao['proprietario']); ?></td>
                    <?php endif; ?>

                    <td>
                      <strong><?php echo textoSeguro($manutencao['descricao']); ?></strong>
                      <?php if ($manutencao['observacoes']): ?>
                        <small><?php echo textoSeguro($manutencao['observacoes']); ?></small>
                      <?php endif; ?>
                    </td>
                    <td>
                      <span class="status <?php echo classeStatus($manutencao['status']); ?>">
                        <?php echo textoSeguro(nomeStatus($manutencao['status'])); ?>
                      </span>
                    </td>
                    <td>
                      <?php if (usuarioEhFuncionario()): ?>
                        <div class="acoes-tabela">
                          <form action="atualizar-manutencao.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $manutencao['id']; ?>">
                            <select name="status" aria-label="Novo status">
                              <option value="Solicitado" <?php echo $manutencao['status'] === 'Solicitado' ? 'selected' : ''; ?>>Solicitado</option>
                              <option value="Agendado" <?php echo $manutencao['status'] === 'Agendado' ? 'selected' : ''; ?>>Agendado</option>
                              <option value="Em andamento" <?php echo $manutencao['status'] === 'Em andamento' ? 'selected' : ''; ?>>Em andamento</option>
                              <option value="Concluido" <?php echo $manutencao['status'] === 'Concluido' ? 'selected' : ''; ?>>Concluído</option>
                              <option value="Cancelado" <?php echo $manutencao['status'] === 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                            </select>
                            <button type="submit">Salvar</button>
                          </form>

                          <form action="excluir-manutencao.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $manutencao['id']; ?>">
                            <button type="submit">Excluir</button>
                          </form>
                        </div>
                      <?php else: ?>
                        <?php echo textoSeguro($manutencao['funcionario'] ?: 'Aguardando atendimento'); ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </section>
    </main>
  </div>
</body>
</html>
