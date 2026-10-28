<?php

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyMatch</title>
    <link rel="stylesheet" href="./css-yasmin/style.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@100..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="cabecalho">
        <div class="img-cabecalho"><a href="homelogin.php"><img src="/img-yasmin/logo.png" alt=""></a></div>
    <nav>
    <ul>
        <li><a href="materias.php"><p>Matérias</p></a></li>
        <li><a href="social.php"><p>Social</p></a></li>
        <li><a href="progresso.php"><p>Progresso</p></a></li>
    </ul>
    </nav>
    <div class="login"><a href="login.php"><div class="loginTitulo"><p>login</p></div></a></div>
    </div>
    <div class="inicialLogin">
    <img src="/img-yasmin/login-img.png" alt="">
        <div class="formLogin">
            <div class="titulo"><p>Login</p></div>
            <form action="" method="post">
                <input type="text" name="id_usuario" hidden>

                <label for="email"></label>
                <input type="text" name="email" id="email" placeholder="E-Mail">

                <label for="senha"></label>
                <input type="password" name="senha" id="senha" placeholder="Senha">

                <p>Não possui uma conta? <a href="cadastro.php">Cadastre-se aqui</a></p>

                <button type="submit">Acessar Conta</button>
            </form>
        </div>
    </div>
    <div class="rodape">
        <div class="img-rodape"><a href="homelogin.php"><img src="/img-yasmin/logo.png" alt=""></a></div>
        <table cellpadding="3">
            <tr>
                <td><a href="materias.php"><p>Matérias</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="social.php"><p>Social</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="progresso.php"><p>Progresso</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="suporte.php"><p>Suporte</p></a></td>
            </tr>
            <tr>
                <td><a href="termos.php"><p>Termos</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="contato.php"><p>Contato</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="customizacao.php"><p>Customização</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="configuracao.php"><p>Configuração</p></a></td>
            </tr>
            </table>
            <div class="redesSociais">
                <nav>
                <ul>
                    <li><a href=""><img src="/img-yasmin/git.png" alt=""></a></li>
                    <li><a href=""><img src="/img-yasmin/insta.png" alt=""></a></li>
                </ul>
                </nav>
            </div>
            <p class="direitos">© 2026 StudyMatch - Todos os direitos reservados</p>
    </div>
</body>
</html>