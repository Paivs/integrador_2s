<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['id'])){
    $id = $_GET['id'] ?? null;
}else{
    header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
}

?>