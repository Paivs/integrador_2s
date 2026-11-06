<?php

require_once __DIR__ . "/init.php";

$equipes = readAll($pdo, "equipes")
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php"?>

    <table border="1">
        <tr>
            <?php foreach($equipes as $e): ?>
            <?php if($e['jogo_equipe'] == "Counter-Strike 2"):?>
                <th><?= $e['jogo_equipe'] ?></th>
                <th><?= $e['img'] ?></th>
                <th><?= $e['nome'] ?></th>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <tr>
            <?php foreach($equipes as $e): ?>
            <?php if($e['jogo_equipe'] == "Valorant"):?>
                <th><?= $e['jogo_equipe'] ?></th>
                <th><?= $e['img'] ?></th>
                <th><?= $e['nome'] ?></th>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <tr>
            <?php foreach($equipes as $e): ?>
            <?php if($e['jogo_equipe'] == "League of Legends"):?>
                <th><?= $e['jogo_equipe'] ?></th>
                <th><?= $e['img'] ?></th>
                <th><?= $e['nome'] ?></th>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
        <tr>
            <?php foreach($equipes as $e): ?>
            <?php if($e['jogo_equipe'] == "Free Fire"):?>
                <th><?= $e['jogo_equipe'] ?></th>
                <th><?= $e['img'] ?></th>
                <th><?= $e['nome'] ?></th>
            <?php endif ?>
        </tr>
        <?php endforeach ?>
    </table>
</body>
</html>