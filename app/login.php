<?php
    require_once __DIR__ . "/banco/crud.php";
    require_once __DIR__ . "/banco/database.php";

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email']) && isset($_POST['senha'])){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    }
    $mensagem = "Login inválido, tente novamente."
?>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Login</title>
    </head>
    <body>
        <center>

            <div class="formulario-login">
                <form action="" method="POST">
                    <input type="text" name="email" id="email" placeholder="Email">
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
<?php
    $usuario = [];
    $usuarioEmail = read(database(), "usuarios", "email=" . $email, $usuario);
    if ($usuario['senha'] !== $senha){
        header("Location: login.php?erro=login_inválido");
    }elseif($usuario['senha'] == $senha){
        header("Location: index.php");
    }
?>