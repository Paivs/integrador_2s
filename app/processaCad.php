<?php

require_once __DIR__ . "/init.php";

$nome  = trim($_POST['nome'] ?? '');
$tel   = trim($_POST['tel'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($nome === '' || $tel === '' || $email === '' || $senha === '') {
    header('Location: cadastrarConta.php?erro[]=' . urlencode('Preencha todos os campos.'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: cadastrarConta.php?erro[]=' . urlencode('O e-mail informado é inválido.'));
    exit;
}

if (read($pdo, 'usuario', 'email = ?', [$email])) {
    header('Location: cadastrarConta.php?erro[]=' . urlencode('Esse e-mail já está cadastrado.'));
    exit;
}

$idNovo = create($pdo, 'usuario', [
    'nome'     => $nome,
    'telefone' => $tel,
    'email'    => $email,
    'senha'    => password_hash($senha, PASSWORD_DEFAULT),
]);

// Já deixa a pessoa logada
session_regenerate_id(true);
$_SESSION['id_usuario'] = (int) $idNovo;

header('Location: painelObjetos.php');
exit;