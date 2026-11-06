<?php

require_once __DIR__ . '/init.php';
protegerFuncionario();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: manutencoes.php');
    exit;
}

$id = intval($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';
$statusPermitidos = [
    'Solicitado',
    'Agendado',
    'Em andamento',
    'Concluido',
    'Cancelado'
];

if ($id <= 0 || !in_array($status, $statusPermitidos, true)) {
    header('Location: manutencoes.php?mensagem=erro');
    exit;
}

if ($status === 'Concluido') {
    $sql = 'UPDATE manutencoes
            SET status = ?, funcionario_id = ?, data_conclusao = NOW()
            WHERE id = ?';
} else {
    $sql = 'UPDATE manutencoes
            SET status = ?, funcionario_id = ?, data_conclusao = NULL
            WHERE id = ?';
}

$comando = $pdo->prepare($sql);
$comando->execute([
    $status,
    $_SESSION['funcionario_id'],
    $id
]);

header('Location: manutencoes.php?mensagem=atualizada');
exit;
