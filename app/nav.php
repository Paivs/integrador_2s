<?php

if (isset($_SESSION['user'])) {
  $user = $_SESSION['user'];
} else {
  $user = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./css/nav.css">
</head>

<body>
  <header class="header">
    <div class="header-conteudo">
      <a href="./index.php" alt="" class="logo"><img src="./img/cabecalho/logo.png" alt=""></a>
      <nav>
        <ul class="menu">
          <li><a href="./index.php">Início</a></li>

          <li class="tem-submenu">
            <a href="">Reservas ▾</a>
            <ul class="submenu">
              <li><a href="">Impressora 3D</a></li>
              <li><a href="">Corte a laser</a></li>
              <li><a href="">Usinagem CNC</a></li>
              <li><a href="">Bancada de eletrônica</a></li>
            </ul>
          </li>

          <li class="tem-submenu">
            <a href="">Vendas ▾</a>
            <ul class="submenu">
              <li><a href="">Peças impressas</a></li>
              <li><a href="">Componentes</a></li>
              <li><a href="">Kits</a></li>
            </ul>
          </li>

          <li><a href="">Quem Somos</a></li>
          <li><a href="">Projetos</a></li>
          <li><a href="./loginADM.php">Administrador</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
      <?php if ($user != "") {   ?>
        <a href="./loginUsuario.php" class="usuario"><img src="./img/cabecalho/usuario.png" alt="" width="56px">Olá <?= $user ?></a>
      <?php } else { ?>
        <a href="./loginUsuario.php" class="usuario"><img src="./img/cabecalho/usuario.png" alt="" width="56px"></a>
      <?php } ?>
    </div>
  </header>
</body>

</html>