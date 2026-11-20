<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$usuario = read($pdo, 'usuario', 'email = ?', [$email]);

if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    header('Location: login.php?erro[]=' . urlencode('E-mail ou senha incorretos.'));
    exit;
}

session_regenerate_id(true);
$_SESSION['id_usuario'] = (int) $usuario['idUsuario'];

$destino = $_SESSION['voltar_para'] ?? 'index.php';
unset($_SESSION['voltar_para']);

header('Location: ' . $destino);
exit;