<?php
require_once __DIR__ . "/init.php";

if (isset($_SESSION['id_usuario'])) {
    header('Location: painelObjetos.php');
    exit;
}

$objetos = readAll($pdo, 'objetos');

$i = 0;
$cont = 0;

foreach ($objetos as $o) {
    $i++;
    if ($o['status_objeto'] == 'Encontrado') {
        $cont++;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Conta | findIt</title>
    <link rel="stylesheet" href="/css/cadastrarConta.css">
</head>

<body>
    <header class="header-top">
        <div id="logo">
            <a href="index.php" class="btn-perfil">
                <img src="/imagens/findit.png" alt="Logo findIt" width="170px">
            </a>
        </div>
        <div class="header-badge">
            <span class="pulse-dot"></span>
            <span>+<?= $cont ?> encontrados</span>
        </div>
    </header>

    <main>
        <section class="displayFlex">
            <div class="left-side">
                <div class="container-sup">
                    <div class="erro">
                        <?php if (isset($_GET['erro']) && is_array($_GET['erro'])): ?>
                            <h3>Ocorreram os seguintes erros:</h3>
                            <ul>
                                <?php foreach (array_filter($_GET['erro'], 'is_string') as $erro): ?>
                                    <li><?= htmlspecialchars($erro) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <h1 id="bemvindo">Crie sua conta no findIt.</h1>
                    <br>
                    <p id="msg">Junte-se à comunidade e comece a cadastrar ou buscar objetos perdidos.</p>
                </div>

                <div class="container-mid">
                    <div class="form">
                        <form action="processaCad.php" method="post">
                            <div class="nome">
                                <label for="nome">Nome Completo</label><br>
                                <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>
                            </div>

                            <div class="telefone">
                                <label for="tel">Telefone</label><br>
                                <input type="tel" name="tel" id="tel" placeholder="Digite seu telefone" maxlength="11" required>
                            </div>

                            <div id="email">
                                <label for="email">E-mail corporativo ou pessoal</label><br>
                                <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" required>
                            </div>

                            <div id="senha">
                                <label for="senha">Senha</label><br>
                                <input type="password" name="senha" id="senha" placeholder="Digite sua Senha" required>
                            </div>

                            <div id="botao">
                                <button type="submit" id="botao" name="botao">Criar Minha Conta →</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="container-cadastro">
                    <span>Já possui uma conta?</span>
                    <a href="login.php" class="meu-link">Entrar</a>
                </div>
            </div>

            <div class="right-panel">
                <img src="/imagens/imgright.jpg" alt="Perdeu? A gente encontra.">
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2026 findIt. Todos os direitos reservados.</p>
    </footer>
</body>

</html>