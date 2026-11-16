<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: FormContato.php');
    exit;
}
 
$telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
$nome     = trim($_POST['Nome'] ?? '');
$email    = trim($_POST['email'] ?? '');
$assunto  = $_POST['assunto'] ?? '';
$mensagem = trim($_POST['mensagem'] ?? '');
 
$erros = [];
 
if (strlen($telefone) < 10 || strlen($telefone) > 11) {
    $erros[] = 'Telefone inválido. Informe o DDD e o número.';
}
 
if ($nome === '') {
    $erros[] = 'Informe o seu nome.';
}
 
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'Email inválido.';
}
 
if ($assunto !== '' && !in_array($assunto, ['suporte', 'sugestao', 'reclamacao'])) {
    $erros[] = 'Assunto inválido.';
}
 
if ($mensagem === '') {
    $erros[] = 'Escreva uma mensagem.';
}

if (count($erros) === 0) {
    try {
 
        $sql = 'INSERT INTO contato (telefone, nome, email, assunto, mensagem)
                VALUES (?, ?, ?, ?, ?)';
 
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$telefone, $nome, $email, $assunto, $mensagem]);
    } catch (PDOException $e) {
        $erros[] = $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contato</title>
</head>
<body>
    <main>
        <?php if (count($erros) > 0): ?>
            <h1>Ops!</h1>
            <h2>Corrija os itens abaixo:</h2>
            <?php foreach ($erros as $erro): ?>
                <p><?= htmlspecialchars($erro) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <h1>Mensagem recebida!</h1>
            <h2>Obrigado pelo contato, <?= htmlspecialchars($nome) ?>.</h2>
        <?php endif; ?>
 
        <p><a href="FormContato.php">Voltar ao formulário</a></p>
    </main>
</body>
</html>
