<?php

require_once __DIR__ . "/init.php";

$usuarios = readAll($pdo, "usuarios");

$email = null;

if ($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['erro'])) {
    $erro = $_GET['erro'] ?? null;
    $email = $_SESSION['erro']['email'] ?? null; 
}

unset($_SESSION['erro']);

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/entrarConta.css">
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
                <input type="text" name="email" id="email" placeholder="E-mail" value="<?= $email ?>">
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
<div class="perfil">

    
    <div class="perfil-topo">
        <div class="perfil-avatar">
           
            <span>J</span>
        </div>
        <div class="perfil-identidade">
            <p class="perfil-rotulo">Você está cadastrado como</p>
            <h2 class="perfil-nome">JoaoFPS</h2>
            <p class="perfil-email">joao@email.com</p>
        </div>
    </div>

    
    <div class="perfil-stats">
        <div class="status">
            <span class="status-valor">#12</span>
            <span class="status-rotulo">Ranking</span>
        </div>
        <div class="status">
            <span class="status-valor">1.850</span>
            <span class="status-rotulo">Pontos</span>
        </div>

    </div>

    
    <div>
        <h3 class="perfil-informacoes">Informações</h3>
        <ul class="perfil-info">
            <li>
                <span class="info-1">Equipe</span>
                <span class="info-2">FURIA</span>
            </li>
            <li>
                <span class="info-1">Jogo principal</span>
                <span class="info-2">Counter-Strike 2</span>
            </li>
            <li>
                <span class="info-1">Torneios disputados</span>
                <span class="info-2">5</span>
            </li>
        </ul>
    </div>

    
    <div class="perfil-acoes">
        <a class="perfil1 sair" href="sair_conta.php">Sair da conta</a>
    </div>

</div>
<?php endif ?>
    </div>
</body>

</html>