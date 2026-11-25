<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id']) && $_GET['id'] != "" && $_GET['id'] != null){
    $id = $_GET['id'];
    $equipe = read($pdo, "equipes", "id = ?", [$id]);

    if(!isset($equipe) || $equipe == "" || $equipe == null){
        header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
        exit;
    }

    update($pdo, "usuarios", [
        "id_equipe" => null
    ], "id_equipe = ?", [$id]);

    delete($pdo, "torneios_equipes", "id_equipe = ?", [$id]);
    delete($pdo, "equipes", "id = ?", [$id]);
    header("Location: administracao.php");
    exit;
}

header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
exit;