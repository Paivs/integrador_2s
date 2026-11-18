<?php 

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "GET" || isset($_GET['id'])){
    $id = $_GET['id'];
}
$consulta = $pdo->prepare(" SELECT usuarios.username_conta, equipes.nome AS nome_equipe, equipes.img AS img_equipe, equipes.jogo_equipe FROM usuarios INNER JOIN equipes ON usuarios.id_equipe = equipes.id WHERE usuarios.id = :id");

$consulta->execute(['id' => $id]);

$usuario = $consulta->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php"?>
    <h1><?= $usuario['username_conta'] ?></h1>

    <h2>Equipe:</h2>

    <?php if (isset($usuario['nome_equipe'])): ?>
        <img src="img/equipes/<?= $usuario['img_equipe'] ?>">
        <h3><?= $usuario['nome_equipe'] ?></h3>
        <p><?= $usuario['jogo_equipe'] ?></p>
    <?php else: ?>
        <p>ESTE USUARIO NÃO POSSUI EQUIPE</p>
    <?php endif; ?>
</body>