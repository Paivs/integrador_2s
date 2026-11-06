<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['erro'])){
    $erro = $_GET['erro'] ?? null;
}

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar conta</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php" ?>

    <form action="processarEntrarConta.php" method="POST">
        <label for="email">E-mail</label>
        <input type="text" name="email" id="email" placeholder="E-mail">
        <br>
        <label for="senha">Senha</label>
        <input type="text" name="senha" id="senha" placeholder="Senha">
        <?php if($erro == "SENHA"):?>
            <p>SENHA OU EMAIL INCORRETOS</p>
        <?php elseif($erro == "EMAIL"):?>
            <p>SENHA OU EMAIL INCORRETOS</p>
        <?php endif ?>  
        <br>
        <button type="submit">Entrar</button>  
    </form>
</body>
</html>