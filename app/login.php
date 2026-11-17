<?php
require_once __DIR__ . "/init.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | findIt</title>
    <link rel="stylesheet" href="/css/login.css">
</head>

<body>
    <header class="header-top">
        <div id="logo">
            <a href="index.php" class="btn-perfil">
                <img src="/imagens/logoLight.png" alt="Logo findIt">
            </a>
        </div>
        <div class="header-badge">
            <span class="pulse-dot"></span>
            <span>+15 mil resgatados</span>
        </div>
    </header>

    <main>
        <section class="displayFlex">
            <div class="left-side">
                <div class="container-sup">
                    <div class="erro">
                        <?php
                        if (isset($_GET['erro']) && $_GET['erro'] != "") {
                            echo "<h3> Ocorreram os Seguintes erros:</h3>";
                            echo "<ul>";
                            foreach ($_GET['erro'] as $erro) {
                                echo "<li>" . htmlspecialchars($erro) . "</li>";
                            }
                            echo "</ul>";
                        }
                        ?>
                    </div>
                    <h1 id="bemvindo">Que bom ter você de volta.</h1>
                    <br>
                    <p id="msg">Entre para acompanhar seus anúncios e reencontrar o que importa.</p>
                </div>

                <div class="container-mid">
                    <div class="form">
                        <form action="processaLog.php" method="post">
                            <div id="email">
                                <label for="email">E-mail corporativo ou pessoal</label><br>
                                <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" required>
                            </div>

                            <div id="senha">
                                <label for="senha">Senha</label><br>
                                <input type="password" name="senha" id="senha" placeholder="Digite sua Senha" required>
                            </div>

                            <div id="botao">
                                <button type="submit" id="botao" name="botao">Entrar na Minha Conta</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="container-cadastro">
                    <span>Ainda não faz parte?</span>
                    <a href="cadastrarConta.php" class="meu-link">Crie sua conta grátis</a>
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