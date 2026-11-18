<?php
require_once __DIR__ . "/init.php";
require_once __DIR__ . "/cabecalho.php";

$torneios = readAll($pdo, "torneios");
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
        <img class="banner-torneios" src="/app/img/banner-torneios.png" alt="">
        <div class="texto">
            <h1>SEU PRÓXIMO<br><span>TORNEIO</span><br>COMEÇA <span>AQUI</span></h1>
            <p>CRIE CAMPEONATOS, REÚNA EQUIPES<br>DISPUTE PARTIDAS E CONQUISTE O TOPO DO RANKING.</p>
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


    <section class="lista-torneios">
        <?php foreach ($torneios as $t): ?>
            <?php if ($t['tipo'] == "gamehub"): ?>
                <?php
                $slug = strtolower(str_replace(' ', '-', $t['nome_torneio']));
                $nome = explode(' ', $t['nome_torneio'], 2);
                ?>
                <article class="card-torneio torneio-<?= $slug ?>">
                    <div class="card-info">
                        <h2 class="card-nome"><span><?= htmlspecialchars($nome[0]) ?></span> <?= htmlspecialchars($nome[1] ?? '') ?></h2>
                        <p>FORMATO DE EQUIPE: <span><?= htmlspecialchars($t['format_torneio']) ?></span></p>
                        <p>PREMIAÇÃO DE <span>R$ <?= number_format($t['premiacao'], 0, ',', '.') ?></span></p>
                        <p>INÍCIO: <span><?= substr($t['horainit_torneio'], 0, 5) ?></span></p>
                        <p>DATA: <?= date('d/m/Y', strtotime($t['data_torneio'])); ?></p>
                        <a href="#" class="inscrever">INSCREVER-SE</a>
                    </div>
                    <div class="card-img">
                        <img src="/app/img/<?= $slug ?>.jpg" alt="<?= htmlspecialchars($t['nome_torneio']) ?>">
                    </div>
                </article>
            <?php endif ?>
        <?php endforeach ?>
    </section>
    <section class="fundo">
        <div class="titulo">
            <h1>CRIADOS PELA <span>COMUNIDADE</span></h1>
        </div>
    </section>


    <section class="lista-comunidade">
        <?php foreach ($torneios as $t): ?>
            <?php if ($t['tipo'] == "comunidade"): ?>
                <?php $slug = strtolower(str_replace(' ', '-', $t['nome_torneio'])); ?>
                <article class="card-comunidade">
                    <img class="card-comunidade-img"
                        src="/app/img/<?= $slug ?>.jpg"
                        alt="<?= htmlspecialchars($t['nome_torneio']) ?>">

                    <div class="card-comunidade-info">
                        <h3><?= htmlspecialchars($t['nome_torneio']) ?></h3>
                        <p>FORMATO: <?= htmlspecialchars($t['format_torneio']) ?></p>
                        <p>PRÊMIO: R$ <?= number_format($t['premiacao'], 0, ',', '.') ?></p>
                        <p>DATA: <?= date('d/m/Y', strtotime($t['data_torneio'])); ?></p>
                        <p>INÍCIO: <?= substr($t['horainit_torneio'], 0, 5) ?></p>

                        <div class="card_comunidade_rodape">
                            <a href="#" class="clica">CLICAR AQUI</a>
                            <img class="logo-gamehub" src="./img/logo.png" alt="GameHub">
                        </div>
                    </div>
                </article>
            <?php endif ?>
        <?php endforeach ?>
    </section>
    <?php require_once __DIR__ . "/rodape.php"; ?>
</body>

</html>