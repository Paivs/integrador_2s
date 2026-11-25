<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $formato = $_POST['formato'];
    $jogadores = $_POST['jogadores'];
    $jogo = $_POST['jogo'];
    $taxa = $_POST['taxa'];

    $torneio = read($pdo, "torneios", "id ={$id}");

    if($nome == "" || strlen($nome) > 100){
        header("Location: administracao.php?erro=NOME_INVALIDO");
        exit;
    }

    if($data < date('Y-m-d')){
        header("Location: administracao.php?erro=TORNEIO_JA_PASSOU");
        exit;
    }

    $agora = new DateTime("now", new DateTimeZone("America/Sao_Paulo"));
    $novoInicio = new DateTime(
        $data . " " . $hora,
        new DateTimeZone("America/Sao_Paulo")
    );

    if($novoInicio <= $agora){
        header("Location: administracao.php?erro=HORARIO_PASSADO");
        exit;
    }

    if($formato == "" || strlen($formato) > 50){
        header("Location: administracao.php?erro=FORMATO_INVALIDO");
        exit;
    }

    if($jogadores <= 0){
        header("Location: administracao.php?erro=JOGADORES_INVALIDO");
        exit;
    }

    if(!is_numeric($taxa) || $taxa < 0){
        header("Location: administracao.php?erro=TAXA_INVALIDA");
        exit;
    }

    update($pdo, "torneios", [
        "nome_torneio" => $nome,
        "data_torneio" => $data,
        "horainit_torneio" => $hora,
        "format_torneio" => $formato,
        "qnt_jogadores" => $jogadores,
        "nmjogo_torneio" => $jogo,
        "taxa" => $taxa
    ], "id = ?", [$id]);

    header("Location: administracao.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id']) && $_GET['id'] != "" && $_GET['id'] != null){
    $pdo = database();
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
        <input type="text" name="nome" id="nome" maxlength="100" required
        value="<?= $torneio['nome_torneio'] ?>"
        >
        <br>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required
        value="<?= $torneio['data_torneio'] ?>"
        >
        <br>

        <label for="hora">Hora</label>
        <input type="time" name="hora" id="hora" required
        value="<?= $torneio['horainit_torneio'] ?>"
        >
        <br>

        <label for="formato">Formato:</label>
        <input type="text" name="formato" id="formato" maxlength="50" required
        value="<?= $torneio['format_torneio'] ?>"
        >
        <br>

        <label for="jogadores">Quantidade de jogadores:</label>
        <input type="number" name="jogadores" id="jogadores" required
        value="<?= $torneio['qnt_jogadores'] ?>"
        >
        <br>

        <select name="jogo" id="jogo" required>
            <option value="<?= $torneio['nmjogo_torneio'] ?>" hidden><?= $torneio['nmjogo_torneio'] ?></option>
            <option value="Counter-Strike 2">Counter-Strike 2</option>
            <option value="Valorant">Valorant</option>
            <option value="Rocket League">Rocket League</option> 
            <option value="EA FC">EA FC</option> 
            <option value="Fortnite">Fortnite</option> 
            <option value="Tom Clancy's Rainbow Six Siege">Tom Clancy's Rainbow Six Siege</option> 
            <option value="League of Legends">League of Legends</option> 
        </select>

        <label for="taxa">Taxa:</label>
        <input type="number" name="taxa" id="taxa" required
        value="<?= $torneio['taxa'] ?>"
        >
        <br>
        <button type="submit">Alterar</button>
</body>