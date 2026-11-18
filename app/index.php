<?php
    
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/css/index.css">
    <title>GameHub</title>
</head>
    <body>
        <?php require_once __DIR__ . "/cabecalho.php" ?>

    
        <div class="tudo">
        <div class="banner">
        <img src="./img/cs2_banner.png" alt="Counter-Strike 2">
        </div>
        <div class="texto-sobreposto">
            <h1><i><b>MASTERS LEAGUE</b></i></h1>
        </div>
        <div class="texto-sobreposto2">
            <h2><i><b>INSCRIÇÕES ABERTAS!</b></i></h2>
        </div>
        <div class="texto-sobreposto3">
            <h4><i><b>Mais de R$20.000 em prêmios para equipes!</b></i></h4>
        </div>
        <div class="saiba">
            <a href=""><i>SAIBA MAIS...</i></a>
        </div>
        <div class="preto">
            
            <div class="explorar">
                <h1><i><b>EXPLORE OUTRAS <span class="exploração">COMPETIÇÕES</span> </class></b></i></h1>
            </div>
            <div class="outros">
            <h1><i><b>DE <span class="jogos">OUTROS</span> GRANDES JOGOS</b></i></h1>
            </div>
            </div>

            <section class="seccao-video-fundo">
            <div class="video-overlay"></div>

            <video autoplay loop muted playsinline>
                <source src="./img/cyberforge_background_vignette_forte.mp4" type="video/mp4">
            </video>
            
            </section>
            <div class="fundoTorneios">
            <div class="torneios">
                <a href="torneios.php"><b><i>VER TORNEIOS</i></b></a>
            </div>
            </div>
        <?php require_once __DIR__ . "/rodape.php"?>
    </body>
</html>

