<?php

require_once __DIR__ . '/init.php';
protegerCliente();

$paginaAtual = 'manutencoes';
$erro = '';
$veiculoId = '';
$servicoId = '';
$dataAgendamento = '';
$quilometragem = '';
$observacoes = '';

// O cliente só pode escolher um veículo que pertence a ele.
$consultaVeiculos = $pdo->prepare(
    'SELECT id, marca, modelo, placa, quilometragem
     FROM veiculos
     WHERE cliente_id = ?
     ORDER BY marca, modelo'
);
$consultaVeiculos->execute([$_SESSION['cliente_id']]);
$veiculos = $consultaVeiculos->fetchAll();

$servicos = $pdo->query(
    'SELECT * FROM servicos WHERE ativo = 1 ORDER BY nome'
)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $veiculoId = intval($_POST['veiculo_id'] ?? 0);
    $servicoId = intval($_POST['servico_id'] ?? 0);
    $dataAgendamento = $_POST['data_agendamento'] ?? '';
    $quilometragem = intval($_POST['quilometragem'] ?? 0);
    $observacoes = trim($_POST['observacoes'] ?? '');

    $consultaVeiculo = $pdo->prepare(
        'SELECT id FROM veiculos WHERE id = ? AND cliente_id = ?'
    );
    $consultaVeiculo->execute([$veiculoId, $_SESSION['cliente_id']]);
    $veiculoValido = $consultaVeiculo->fetch();

    $consultaServico = $pdo->prepare(
        'SELECT id, nome FROM servicos WHERE id = ? AND ativo = 1'
    );
    $consultaServico->execute([$servicoId]);
    $servico = $consultaServico->fetch();

    if (!$veiculoValido || !$servico || $dataAgendamento === '') {
        $erro = 'Selecione o veículo, o serviço e a data.';
    } elseif ($dataAgendamento < date('Y-m-d')) {
        $erro = 'A data não pode estar no passado.';
    } elseif ($quilometragem < 0) {
        $erro = 'A quilometragem não pode ser negativa.';
    } else {
        // O cliente não escolhe o status: toda nova solicitação começa assim.
        $comando = $pdo->prepare(
            'INSERT INTO manutencoes
            (veiculo_id, servico_id, descricao, data_agendamento,
             quilometragem, status, observacoes)
            VALUES (?, ?, ?, ?, ?, ?, ?)'
        );

        $comando->execute([
            $veiculoId,
            $servicoId,
            $servico['nome'],
            $dataAgendamento,
            $quilometragem,
            'Solicitado',
            $observacoes
        ]);

        header('Location: manutencoes.php?mensagem=cadastrada');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitar manutenção | CarCare</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/cadastro-veiculo.css">
</head>
<body>
  <div class="app" inert>
    <?php include __DIR__ . '/parciais/nav.php'; ?>
  </div>

  <div class="sobreposicao">
    <div class="caixa cadastro-veiculo">
      <div class="formulario_titulo">
        <div><h2>Solicitar manutenção</h2><p>O status inicial será definido automaticamente como Solicitado.</p></div>
        <a class="fechar" href="manutencoes.php">×</a>
      </div>

      <?php if ($erro !== ''): ?>
        <div class="alerta erro"><?php echo textoSeguro($erro); ?></div>
      <?php endif; ?>

      <?php if (count($veiculos) === 0): ?>
        <div class="alerta erro">Cadastre um veículo antes de solicitar uma manutenção.</div>
        <a class="botao primario" href="cadastro-veiculo.php">Cadastrar veículo</a>
      <?php elseif (count($servicos) === 0): ?>
        <div class="alerta erro">A oficina ainda não cadastrou serviços.</div>
      <?php else: ?>
        <form action="agendar-manutencao.php" method="post">
          <label>
            Veículo
            <select name="veiculo_id" required>
              <option value="">Selecione</option>
              <?php foreach ($veiculos as $veiculo): ?>
                <option value="<?php echo $veiculo['id']; ?>" <?php echo $veiculoId == $veiculo['id'] ? 'selected' : ''; ?>>
                  <?php echo textoSeguro(trim($veiculo['marca'] . ' ' . $veiculo['modelo'])); ?> — <?php echo textoSeguro($veiculo['placa']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>

          <label>
            Serviço
            <select name="servico_id" required>
              <option value="">Selecione</option>
              <?php foreach ($servicos as $servico): ?>
                <option value="<?php echo $servico['id']; ?>" <?php echo $servicoId == $servico['id'] ? 'selected' : ''; ?>>
                  <?php echo textoSeguro($servico['nome']); ?> — R$ <?php echo number_format($servico['valor'], 2, ',', '.'); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </label>

          <div class="colunas">
            <label>Data desejada<input name="data_agendamento" type="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo textoSeguro($dataAgendamento); ?>" required></label>
            <label>Quilometragem<input name="quilometragem" type="number" min="0" value="<?php echo textoSeguro($quilometragem); ?>" required></label>
          </div>

          <label>Observações<textarea name="observacoes" rows="3" placeholder="Explique o que está acontecendo com o veículo."><?php echo textoSeguro($observacoes); ?></textarea></label>

          <div class="acoes">
            <a class="botao secundario" href="manutencoes.php">Cancelar</a>
            <button class="botao primario" type="submit">Enviar solicitação</button>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
