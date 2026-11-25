<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastrarConta.php');
    exit;
}

$nome  = trim($_POST['nome'] ?? '');
$tel   = preg_replace('/\D/', '', $_POST['tel'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$erros = [];

if ($nome === '') {
    $erros[] = 'Informe o seu nome.';
}
if (strlen($tel) < 10 || strlen($tel) > 11) {
    $erros[] = 'Telefone inválido. Informe o DDD e o número.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'O e-mail informado é inválido.';
}
if (strlen($senha) < 6) {
    $erros[] = 'A senha precisa ter pelo menos 6 caracteres.';
}

if (!$erros && read($pdo, 'usuario', 'email = ?', [$email])) {
    $erros[] = 'Esse e-mail já está cadastrado.';
}

if ($erros) {
    header('Location: cadastrarConta.php?' . http_build_query(['erro' => $erros]));
    exit;
}

try {
    $idNovo = create($pdo, 'usuario', [
        'nome'     => $nome,
        'telefone' => $tel,
        'email'    => $email,
        'senha'    => password_hash($senha, PASSWORD_DEFAULT),
    ]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: cadastrarConta.php?' . http_build_query(['erro' => ['Não foi possível criar a conta agora. Tente novamente.']]));
    exit;
}

session_regenerate_id(true);
$_SESSION['id_usuario'] = (int) $idNovo;

header('Location: painelObjetos.php');
exit;