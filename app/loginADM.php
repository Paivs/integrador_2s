<?php

require_once __DIR__ . '/init.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/loginADM.css">
</head>

<body>
    <?php require_once __DIR__ . '/nav.php' ?>

    <section class="loginADM">
        <div class="conteudo">
            <h1>LOGIN DE ADMINISTRADOR:</h1>

            <form class="form-login" action="" method="post">
                <div class="campo">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="campo">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" required>
                </div>

                <button type="submit">Enviar</button>
            </form>

            <div class="moverTextos">
                <h4 class="textoLogin">Não tem admin? Faça login normalmente.</h4>
                <a class="textoLink" href="">Clique Aqui!</a>
            </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/footer.php' ?>
</body>

</html>