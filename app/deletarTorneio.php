<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id']) && $_GET['id'] != "" && $_GET['id'] != null){

    $id = $_GET['id'];

    $torneio = read($pdo, "torneios", "id = ?", [$id]);

    if(!isset($torneio) || $torneio == "" || $torneio == null){
    header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
    exit;
}
    delete($pdo, "torneios_equipes", "id_torneio = ?", [$id]);
    delete($pdo, "torneios", "id = ?", [$id]);
    header("Location: administracao.php");
    exit;
}

header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
exit;