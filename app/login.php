<?php
    require_once __DIR__ . '/init.php';

    $mensagem = "Login inválido, tente novamente.";
    $usuarios = [];
    readAll(database(), "usuarios", "where=", $usuarios);
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/styleLogin.css">
        <title>Login</title>
    </head>
    <body>
        <center>
            <div class="titulo">
                <img src="./img/Energy Monitor.png">
                <br>
            </div>
            <img src="./img/texto.png" width="500">
            <div class="formulario-login">
                <h2>Insira seu e-mail e senha</h2>
                <form action="processa-login.php" method="POST">
                    <input type="email" name="email" id="email" placeholder="Email">
                    <br>
                    <br>
                    <input type="text" name="senha" id="senha" placeholder="Senha">
                    <br>
                    <br>
                    <button type="submit">Entrar</button>
                </form>
                <?php if(isset($_GET['erro'])){
                    print $mensagem;
                }else{}  
                ?>
            </div>
        </center>
    </body>
</html>