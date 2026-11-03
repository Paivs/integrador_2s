<?php
// require_once __DIR__ . "/Findit/app/init.php";

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | findIt</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <header class="metade">
        <div id="logo">
            <img src="/logo.png" alt="Logo findIt">
        </div>
    </header>

    <main>
        <section class="displayFlex">
            <div class="left-side">
                <div class="container-sup">
                    <h1 id="bemvindo">Que bom ter você de volta.</h1>
                    <br>
                    <p id="msg">Entre para acompanhar seus anúncios e reencontrar o que importa.</p>
                </div>

                <div class="container-mid">
                    <div class="form">
                        <form action="processaLog.php" method="post">
                            <div id="email">
                                <label for="email">E-mail corporativo ou pessoal</label><br>
                                <input type="email" id="email" placeholder="seuemail@exemplo.com" required>
                            </div>

                            <div id="senha">
                                <label for="senha">Senha</label><br>
                                <input type="password" name="senha" id="senha" placeholder="Digite sua Senha" required>
                            </div>

                        </form>
                    </div>
                </div>

                <div class="container-low">
                    <div id="botao">
                        <button type="submit" id="botao" name="botao">Entrar na Minha Conta</button>
                    </div>
                    <div class="criarConta">
                        <p>Ainda não faz parte?</p>
                        <a href="cadastrarConta.php">Crie sua conta grátis</a>
                    </div>
                </div>
            </div>

            <div class="right-side">
                <h3 id="h3">PERDEU? A GENTE ENCONTRA.</h3>
                <h1 id="h1">Tudo pode voltar para você.</h1>
                <P id="p1">Uma comunidade inteira conectando pessoas aos </P>
                <p id="p2">objetos que importam.</p>
                <div class="container-obj">
                    <div class="card-left">
                        <div class="mala">
                            <h1>🧳</h1>
                        </div>
                        <p>Mala Azul</p>
                        <p>Terminal Norte | Há 12 min</p>
                    </div>
                    <div class="card-right">
                        <div class="mochila">
                            <h1>🎒</h1>
                        </div>
                        <p>Mochila Vermelha</p>
                        <p>Parque Central</p>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <footer>
            <p>&copy; 2026 findIt. Todos os direitos reservados.</p>
    </footer>
</body>

</html>