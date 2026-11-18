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

<body class="pagina-perfil">

    <!-- Header idêntico ao padrão do seu sistema -->
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

    <!-- Conteúdo Principal -->
    <main class="container">

        <!-- Cartão de Destaque (Hero Card) -->
        <section class="profile-card">
            <div class="avatar-circle">
                <img src="imagens/perfil.jpg" alt="Foto de <?= htmlspecialchars($usuario['nome']) ?>" class="avatar-img">
            </div>

            <h1 class="profile-name"><?= htmlspecialchars($usuario['nome']) ?></h1>
            <p class="profile-subtitle">Conta &amp; Configurações</p>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-value"><?= htmlspecialchars($usuario['email']) ?></span>
                    <span class="stat-label">E-mail cadastrado</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value"><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></span>
                    <span class="stat-label">Telefone</span>
                </div>
            </div>
        </section>

        <!-- Lista de Dados da Conta -->
        <section class="settings-list">
            <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Nome</span>
                    <span class="setting-value"><?= htmlspecialchars($usuario['nome']) ?></span>
                </div>
                <a href="editaPerfil.php?campo=nome" class="btn-edit">Editar</a>
            </div>

            <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">E-mail</span>
                    <span class="setting-value"><?= htmlspecialchars($usuario['email']) ?></span>
                </div>
                <a href="editaPerfil.php?campo=email" class="btn-edit">Editar</a>
            </div>

            <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Telefone</span>
                    <span class="setting-value"><?= htmlspecialchars($usuario['telefone'] ?? 'Não informado') ?></span>
                </div>
                <a href="editaPerfil.php?campo=telefone" class="btn-edit">Editar</a>
            </div>

            <div class="setting-row">
                <div class="setting-info">
                    <span class="setting-label">Tema</span>
                    <span class="setting-value"><?= htmlspecialchars($usuario['tema'] ?? 'Padrão') ?></span>
                </div>
                <a href="editaPerfil.php?campo=tema" class="btn-edit">Editar</a>
            </div>
        </section>

        <!-- Botão de ação principal -->
        <div class="acao-geral">
            <a href="editaPerfil.php" class="btn-editar-tudo">Editar perfil</a>
        </div>

    </main>

</body>

</html>