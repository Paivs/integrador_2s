<?php

session_start();

require_once __DIR__ . "/init.php";

$idUsuario = (int) ($_SESSION['id_usuario'] ?? 0);

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
    <link rel="icon" type="image/png" href="./imagens/finditDesenho.png">
</head>

<body>

    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png" alt="findIt."></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.jpg" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button type="button">+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>


        <div class="quadros">
            <div class="foto">
                <img src="imagens/perfil.jpg" alt="Foto de <?= htmlspecialchars($usuario['nome']) ?>">
            </div>

            <h1><?= htmlspecialchars($usuario['nome']) ?></h1>

            <div class="resumoDados">
                <div class="dados">
                    <p><?= htmlspecialchars($usuario['email']) ?></p>
                    <h2>E-mail cadastrado</h2>
                </div>
                <div class="dados">
                    <p><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></p>
                    <h2>Telefone</h2>
                </div>
            </div>
        </div>


        <!-- Lista de Dados da Conta -->
        <div class="div-pai">
            <div class="informacao">
                <div class="quadroInfo">
                    <h2>Nome</h2>
                    <p><?= htmlspecialchars($usuario['nome']) ?></p>
                </div>
                <a href="editaPerfil.php?campo=nome" class="btn-edit">Editar</a>
            </div>

            <div class="informacao">
                <div class="quadroInfo">
                    <h2>E-mail</h2>
                    <p><?= htmlspecialchars($usuario['email']) ?></p>
                </div>
                <a href="editaPerfil.php?campo=email" class="btn-edit">Editar</a>
            </div>

            <div class="informacao">
                <div class="quadroInfo">
                    <h2>Telefone</h2>
                    <p><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></p>
                </div>
                <a href="editaPerfil.php?campo=telefone" class="btn-edit">Editar</a>
            </div>

            <div class="informacao">
                <div class="quadroInfo">
                    <h2>Tema</h2>
                    <p><?= htmlspecialchars($usuario['tema'] ?? 'Padrão') ?></p>
                </div>
                <a href="editaPerfil.php?campo=tema">Editar</a>
            </div>
        </div>

        <div class="botoes">
            <a href="logout.php" class="sairConta">Sair da conta</a>
        </div>

    </main>

</body>

</html>