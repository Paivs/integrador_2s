<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['erro'])) {
    $erro = $_GET['erro'] ?? null;
}

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/css/criarConta.css">
    <title>Cadastrar</title>
</head>

<body class="tudo">
    <?php require_once __DIR__ . "/cabecalho.php" ?>


    <div class="formulario">
        <form class="form"  action="processarCriarConta.php" method="POST">
            <div class="campo">
    <label for="email"><span class="texto-laranja">E-mail</span></label>
    <input type="email" name="email" id="email" placeholder="E-mail"
           maxlength="100" required>
    <?php if ($erro == "EMAIL"): ?>
        <p class="erro">E-MAIL SÓ PODE CONTER NO MÁXIMO 100 CARACTERES</p>
    <?php elseif ($erro == "EMAIL_ERRADO"): ?>
        <p class="erro">E-MAIL TEM QUE CONTER O FORMATO CORRETO (EX: nome@exemplo.com)</p>
    <?php endif ?>
    </div>
            <br>
            <div class="campo">
            <label for="username"><span class="texto-laranja">Username</span></label>
            <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <?php if ($erro == "USERNAME"): ?>
                <p class="erro">USERNAME SÓ PODE CONTER NO MAXIMO 20 CARACTERIES</p>
            <?php elseif ($erro == "USERNAME_ERRADO"): ?>
                <p class="erro">USERNAME TEM QUE CONTER NO MINIMO 5 CARACTERIES</p>
            <?php elseif ($erro == "CARACTERE_INVALIDO"): ?>
                <p class="erro">USERNAME NÃO PODE CONTER CARACTERES ESPECIAIS E ESPAÇO</p>
            <?php endif ?>
            <br>
            <div class="campo">
            <label for="senha"><span class="texto-laranja">Senha</span></label>
            <input type="text" name="senha" id="senha" placeholder="Senha">
            </div>
            <?php if ($erro == "SENHA"): ?>
                <p class="erro">SENHA SÓ PODE CONTER NO MAXIMO 50 CARACTERIES</p>
            <?php elseif ($erro == "SENHA_ERRADO"): ?>
                <p class="erro">SENHA TEM QUE CONTER NO MINIMO 8 CARACTERIES</p>
            <?php endif ?>
            <a class="entrar" href="/app/entrarConta.php">Entrar na conta</a>
            <br>
            <div class="separador">OU</div>
            <button type="submit">Criar</button>
        </form>
    </div>
</body>

</html>