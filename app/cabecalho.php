<?php 

if(!isset($_SESSION['cadastrado'])){
    $sessao = null;
}else{
    $sessao = $_SESSION['cadastrado']['perfil'];
}

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cabecalho.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</head>
<body>


    <div class="cabecalho">
    <nav>
            <div class="links"><li><a href="./index.php"><img src="./img/logo.png" alt=""></a></li>
            <li><a href="./torneios.php">TORNEIOS</a></li>
            <li><a href="./partidas.php">Partidas</a></li>
            <li><a href="./equipes.php">Equipes</a></li>
            <?php if($sessao == "root"): ?>
            <li><a href="./ranking.php">Rankings</a></li>
            <li><a class="espaco_adm" href="./administracao.php">Administrador</a></li>
            <?php else:?>
            <li><a class="espaco" href="./ranking.php">Rankings</a></li>
            <?php endif ?>
            </div>

            <div class=""><li><a href="./entrarConta.php"><img class="foto_login" src="./img/login.png" alt=""></a></li></div>
    </nav>
    </div>

</body>
</html>