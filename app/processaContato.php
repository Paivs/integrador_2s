<?php

require_once __DIR__ . "/init.php"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: FormContato.php');
    exit;
}
 
$nome = trim($_POST['nome'] ?? '');
$telefone = ($_POST['telefone'] ?? '');
$email    = trim($_POST['email'] ?? '');
$assunto  = $_POST['assunto'] ?? '';
$mensagem = trim($_POST['mensagem'] ?? '');

$erros = [];
 
if (strlen($telefone) < 11 || strlen($telefone) > 11) {
    $erros[] = 'Telefone inválido. Informe o DDD e o número.';
}
 
if ($nome === '') {
    $erros[] = 'Informe o seu nome.';
    }
 
    if ($assunto !== '' && !in_array($assunto, ['suporte', 'sugestao', 'reclamacao'])) {
    $erros[] = 'Assunto inválido.';
    }
 
    if ($mensagem === '') {
    $erros[] = 'Escreva uma mensagem.';
}

if (count($erros) === 0) {
    try {
 
        $sql = $pdo->prepare(
            'INSERT INTO mensagem (nome, telefone, email, assunto, mensagem) VALUES (:nome, :telefone, :email, :assunto, :mensagem)');
        $sql->execute(['nome' => $nome, 'telefone' => $telefone, 'email' => $email, 'assunto' => $assunto , 'mensagem' =>$mensagem]);
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
    <link rel="stylesheet" href="/css/contato.css">
    <title>Contato</title>
</head>
<body>
    <main>
        <?php if (count($erros) > 0): ?>
            <h1 class="mensagem">Ops!</h1>
            <h2 class="mensagem">Corrija os itens abaixo:</h2>
            <?php foreach ($erros as $erro): ?>
                <p><?= htmlspecialchars($erro) ?></p>
            <?php endforeach; ?>
        <?php else: ?>
            <h1 class="mensagem">Mensagem recebida!</h1>
            <h2 class="mensagem">Obrigado pelo contato, <?= htmlspecialchars($nome) ?>.</h2>
        <?php endif; ?>
 
        <p><a class="linkRetorno" href="FormContato.php">Voltar ao formulário</a></p>
    </main>
</body>
</html>