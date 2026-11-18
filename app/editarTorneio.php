<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['id'])){
$id = $_GET['id'];
$torneio = read($pdo, "torneios", "id ={$id}"); 
}

if(!isset($torneio) || $torneio == "" || $torneio == null){
    header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
    exit;
}

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Editar</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php" ?>

    <form action="" method="POST">
        <input type="text" name="id" id="id"
        value="<?= $id ?>"
        hidden
        >

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome"
        value="<?= $torneio['nome_torneio'] ?>"
        >
        <br>

        <label for="email">E-mail:</label>
        <input type="date" name="data" id="data"
        value="<?= $torneio['data_torneio'] ?>"
        >
        <br>

        <button type="submit">Alterar</button>
</body>