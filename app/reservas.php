<?php

require_once __DIR__ . '/init.php';

$reservasUSER = $_SESSION['reservaUsuario'];
$bancadasDisponiveis = readAll($pdo, 'Bancadas', 'status_bancada = ?', ['disponivel']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="./css/reservas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php require_once __DIR__ . '/nav.php' ?>
    <br>
    <br>
    <br>
    <br>
    <div class="titulo">
        <h1>SERVIÇOS DE BANCADAS:</h1>
    </div>

    <div class="cards">
        <?php foreach ($bancadasDisponiveis as $b): ?>
            <div class="card">
                <img src="./img/index/bancadaEX.png" alt="">
                <h1><?= $b['nome_bancada'] ?></h1>
                <br>
                <p><i class="bi bi-people-fill"></i> Capacidade: <?= $b['quantidade_bancada'] ?> bancadas</p>
                <br>
                <p><i class="bi bi-check-circle-fill"></i> <?= $b['primeira_vantagem'] ?></p>
                <br>
                <p><i class="bi bi-check-circle-fill"></i> <?= $b['segunda_vantagem'] ?></p>
                <br>
                <h1>R$<?= $b['preco_bancada']?> / hora</h1>
                <a href="./processaReserva.php?id=<?= $b['id_bancada'] ?>"><button class="botao-salvar">Reservar ></button></a>
                
            </div>
            <br>
        <?php endforeach; ?>
    </div>

</body>

</html>