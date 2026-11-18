<?php

session_start();

require_once __DIR__ . "/init.php";

// TEMPORÁRIO: sem login ainda, usa o usuário 1 (Ana). Quando o login existir, tire o "?? 1".
$idUsuario = (int) ($_SESSION['id_usuario'] ?? 1);

$usuario = read($pdo, 'usuario', 'idUsuario = ?', [$idUsuario]);

if (!$usuario) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>findIt. - Perfil do Usuário</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.jpg" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <div class="container">

        <div class="quadro">
            <div class="topo">
                <img src="imagens/perfil.jpg">

                <div class="informacao">
                    <div class="nome">
                        <p><?= htmlspecialchars($usuario['nome']) ?></p>
                    </div>
                    
                    <div class="email">
                        <p><?= htmlspecialchars($usuario['email']) ?></p>
                    </div>
                </div>
            </div>

            <div class="edita">
                <h3>Nome</h3>
                <p><?= htmlspecialchars($usuario['nome']) ?></p>
            </div>

            <div class="edita">
                <h3>E-mail</h3>
                <p><?= htmlspecialchars($usuario['email']) ?></p>
            </div>

            <div class="edita">
                <h3>Telefone</h3>
                <p><?= htmlspecialchars($usuario['telefone']) ?></p>
            </div>

            <div class="edita">
                <h3>Tema</h3>
            </div>
        </div>

        <a href="editaPerfil.php">edita</a>
    </div>
</body>

</html>