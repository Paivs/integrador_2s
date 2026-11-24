<?php
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Integrador</title>
  <link rel="stylesheet" href="CSS/monitoramento.css">
</head>

<body>
  <body>
  <?php include __DIR__ . '/menu.php'; ?>


  <main class="conteudo">
    <h1>ALERTAS</h1>
    <p>Acompanhe seus alertas.</p>
  </main>
</body>
</html>