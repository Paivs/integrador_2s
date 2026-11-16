<?php

require_once __DIR__ . "/init.php";

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.png" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./CadastrarItem.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <br>
    <br>
    <br>
    <div class="container">

        <img src="imagens/perfil.png">

        <div class="lista-textos">
            <h2>Nome de Usuário</h2>
            <h3>Telefone</h3>
            <h3>Email</h3>
            <h3>Tema</h3>
            <h3>Endereço</h3>
            <h3>Forma de Pagamento</h3>
        </div>
    </div>
</body>

</html>