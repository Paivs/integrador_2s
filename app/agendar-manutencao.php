<?php

require_once __DIR__ . '/init.php';
protegerCliente();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manutencoes.php#solicitar-manutencao');
    exit;
}

$veiculoId = intval($_POST['veiculo_id'] ?? 0);
$servicoId = intval($_POST['servico_id'] ?? 0);
$dataAgendamento = $_POST['data_agendamento'] ?? '';
$quilometragem = intval($_POST['quilometragem'] ?? 0);
$observacoes = trim($_POST['observacoes'] ?? '');

$consultaVeiculo = $pdo->prepare(
    'SELECT id FROM veiculos WHERE id = ? AND cliente_id = ?'
);
$consultaVeiculo->execute([$veiculoId, $_SESSION['cliente_id']]);
$veiculo = $consultaVeiculo->fetch();

$consultaServico = $pdo->prepare(
    'SELECT id, nome FROM servicos WHERE id = ? AND ativo = 1'
);
$consultaServico->execute([$servicoId]);
$servico = $consultaServico->fetch();

if (!$veiculo || !$servico || $dataAgendamento === '' || $dataAgendamento < date('Y-m-d') || $quilometragem < 0) {
    header('Location: manutencoes.php?mensagem=erroAgendar#solicitar-manutencao');
    exit;
}

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
