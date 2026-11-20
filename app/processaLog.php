<?php

require_once __DIR__ . "/init.php";

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$usuario = read($pdo, 'usuario', 'email = ?', [$email]);

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    header('Location: login.php?erro[]=' . urlencode('E-mail ou senha incorretos.'));
    exit;
}

$_SESSION['id_usuario'] = $usuario['idUsuario'];

// Volta para a página que a pessoa queria acessar (se houver)
$destino = $_SESSION['voltar_para'] ?? 'index.php';
unset($_SESSION['voltar_para']);

header('Location: ' . $destino);
exit;