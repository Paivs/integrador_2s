<?php
require_once __DIR__ . '/init.php';
$ambientes = readAll(database(), "ambientes");
$leituras = readAll(database(), "leituras");
$setores = readAll(database(), "setor");



?>