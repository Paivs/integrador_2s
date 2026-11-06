<?php

require_once __DIR__ . '/init.php';
protegerCliente();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    $comando = $pdo->prepare(
        'DELETE FROM veiculos WHERE id = ? AND cliente_id = ?'
    );
    $comando->execute([$id, $_SESSION['cliente_id']]);
}

header('Location: veiculos.php?mensagem=excluido');
exit;
