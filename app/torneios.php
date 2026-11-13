<?php

    require_once __DIR__ . "/init.php";
    require_once __DIR__ . "/cabecalho.php";
    
    $torneios = readAll($pdo, "torneios");
    $premiacao_total = 0;

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torneios</title>
    <link rel="stylesheet" href="/app/css/torneios.css">
</head>
<body>

    
    <section class="Banner">
        <img  class="banner-torneios" src="/app/img/banner-torneios.png" alt="">
        <div class="texto">
            <h1>SEU PRÓXIMO<br><span>TORNEIO</span><br>COMEÇA <span>AQUI</span></h1>
            <p>CRIE CAMPEONAOTOS, REÚNA EQUIPES<br>DISPUTE PARTIDAS E CONQUISTE O TOPO DO RANKING.</p>
            <a href="">CRIAR TORNEIO</a>
        </div>
    </section>

    <section class="fundo">
        <img class="img-fundo" src="/app/img/preto.jpg" alt="">

        <div class="titulo">
            <img src="/app/img/coroa.png" alt="">
            <h1>NOSSOS <span>TORNEIOS</span><BR> <span>INSCRIÇÕES</span> ABERTAS!</h1>
        </div>
    </section>
    
    <?php foreach($torneios as $t):?>
        <?php if($t['tipo'] == "gamehub"):?>
        <br>
            <tr>
                <td> <?= $t['nome_torneio'] ?></td>
                <td> FORMATO DO TORNEIO: <?= $t['format_torneio'] ?></td>
                <td> PREMIAÇÃO: <?= $t['premiacao'] ?></td>
                <?php if($t['taxa'] == 0):?>
                    <td>TAXA: NENHUMA</td>
                <?php else: ?>
                <td> TAXA: <?= $t['taxa'] ?></td>
                <?php endif ?>
                <td> INICIO: <?= $t['horainit_torneio'] ?></td>
            </tr>
        <?php endif ?>
        <?php endforeach ?>
        <br>
        <br>
        <?php foreach($torneios as $t):?>
        <?php if($t['tipo'] == "comunidade"):?>
            <tr>
                <td> <?= $t['nome_torneio'] ?></td>
                <td> FORMATO DO TORNEIO: <?= $t['format_torneio'] ?></td>
                <td> PREMIAÇÃO: <?= $t['premiacao'] ?></td>
                <?php if($t['taxa'] == 0):?>
                    <td>TAXA: NENHUMA</td>
                <?php else: ?>
                <td> TAXA: <?= $t['taxa'] ?></td>
                <?php endif ?>
                <td> INICIO: <?= $t['horainit_torneio'] ?></td>
            </tr>
            <br>
        <?php endif?>
        
    <?php endforeach?>
</body>
</html>
