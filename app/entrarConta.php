<?php

require_once __DIR__ . "/init.php";

$usuarios = readAll($pdo, "usuarios");

if ($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['erro'])) {
    $erro = $_GET['erro'] ?? null;
}

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/css/entrarConta.css">
    <title>Entrar conta</title>
</head>

<body class="tudo">
    <?php require_once __DIR__ . "/cabecalho.php" ?>

    <div class="formulario">

        <?php if (!isset($_SESSION['cadastrado'])): ?>
        <form class="form form-entrar" action="processarEntrarConta.php" method="POST">
            <h1 class="titulo"><span class="texto-laranja">Entrar</span> conta</h1>
            <div class="campo">
                <label for="email"><span class="texto-laranja">E-mail</span></label>
                <input type="text" name="email" id="email" placeholder="E-mail">
            </div>

            <div class="campo">
                <label for="senha"><span class="texto-laranja">Senha</span></label>
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <?php if ($erro == "EMAIL_SENHA"): ?>
                    <p class="erro">SENHA OU E-MAIL INCORRETOS</p>
                <?php endif ?>
            </div>

            <button type="submit">Entrar</button>

            <div class="separador">OU</div>
            <a class="entrar" href="/app/criarConta.php">Criar conta</a>
        </form>
        <?php endif ?>

        <?php if (isset($_SESSION['cadastrado'])): ?>
        <div class="form">
            <p class="texto-laranja" style="text-align:center; font-size:24px; margin:0;">VOCÊ ESTÁ CADASTRADO COMO:</p>
            <div class="usuario"> <?= $_SESSION['cadastrado']['username'] ?></div>
            <a class="entrar" href="sair_conta.php">SAIR DA CONTA?</a>
        </div>
        <?php endif ?>

    </div>
</body>

</html>