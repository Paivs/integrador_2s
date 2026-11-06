<?php
require_once __DIR__ . "/init.php";
require_once __DIR__ . "/cabecalho.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partidas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/app/css/partidas.css">
    
</head>
<body>
    <div class="tudo">
    
    <section class="banner-partida">
        <img class="banner-partida__foto" src="./img/BANNER PARTIDA.png" alt="">
        <h1 class="banner-partida__titulo">
            <span class="destaque">Organize</span> suas<br>
            partidas<br>
            e <span class="destaque">aumente</span><br>
            seu <span class="destaque">desempenho</span>
        </h1>
    </section>
   <div class="t1">
    <h1><span class="destaque">Programação</span> de torneios</h1>
</div>

<div class="juntatudo">

    <div class="card"> 
        <p>data</p>
        <p></p>
    </div>
    
    <div class="card2"> 
        <p>SEG</p>
        <p></p>
    </div>
</div>
    
<?php require_once __DIR__ . "/rodape.php" ?>
    </div>
</body>
</html>