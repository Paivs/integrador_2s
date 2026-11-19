<?php

require_once __DIR__ . "/init.php"; 

$nomeUsuario = trim($_POST['nomeUsuario'] ?? '');
$email    = trim($_POST['email'] ?? '');
$assunto  = $_POST['assunto'] ?? '';
$mensagem = trim($_POST['mensagem'] ?? '');
 
$erros = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nomeUsuario = trim($_POST['nomeUsuario'] ?? '');
    $assunto  = $_POST['assunto'] ?? '';
    $mensagem = trim($_POST['mensagem'] ?? '');
 
    $erros = [];

    if ($nomeUsuario === '') {
    $erros[] = 'Informe o seu nome.';
    }
 
    if ($assunto !== '' && !in_array($assunto, ['suporte', 'sugestao', 'reclamacao'])) {
    $erros[] = 'Assunto inválido.';
    }
 
    if ($mensagem === '') {
    $erros[] = 'Escreva uma mensagem.';
    }
}

    if (count($erros) === 0){

        try{
            $consulta = $pdo->prepare(
                'INSERT INTO mensagem (nomeUsuario, assunto, mensagem) VALUES (:nomeUsuario, :assunto, :mensagem)');
                $consulta->execute(['nomeUsuario' => $nomeUsuario, 'assunto' => $assunto, 'mensagem' => $mensagem]);
                header(("Location: formContato.php"));
                exit;
        }catch(PDOException $erro){
            error_log($erro->getMessage());
            exit;
        }
}
 
//if (count($erros) === 0) {
  //  try {
 
    //    $sql = 'INSERT INTO contato (nomeUsuario, assunto, mensagem)
      //          VALUES (?, ?, ?, ?, ?)';
 
     //   $stmt = $pdo->prepare($sql);
     //   $stmt->execute([$nomeUsuario, $email, $assunto, $mensagem]);
  //  } catch (PDOException $e) {
   //     $erros[] = $e->getMessage();
   // }
//}

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
            <h2>Obrigado pelo contato, <?= htmlspecialchars($nomeUsuario) ?>.</h2>
        <?php endif; ?>
 
        <p><a href="FormContato.php">Voltar ao formulário</a></p>
    </main>
</body>
</html>