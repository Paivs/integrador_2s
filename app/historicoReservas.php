<?php

    require_once __DIR__ . "/init.php";

    if (isset($_SESSION['id'])) {
            $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
            if($userAtual['perfil'] != "admin" || !isset($userAtual)){
                header("Location: index.php");
                exit;
            }
        }else{
            header("Location: index.php");
            exit;
        };

    $reservas = readAll(database(), "Reservas", "1 ORDER BY data_reserva DESC")
    

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Reservas</title>
    <link rel="stylesheet" href="css/navAdm.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body style="left: 50px;">
    <header>
        <nav class="sidebar">
            <div class="sidebar-content">
                    
                <div class="logo">
                    <a href="index.php"><img src="img/cabecalho/logo.png" alt=""></a>
                </div>
                    
               <a href="./dashboard.php" class="item">
                    <img src="./img/icons/pen.webp" alt="" class="icone">
                    <span>Dashboard</span>
                </a>
                    
                <a href="./adicionarFerramenta.php" class="item">
                    <img src="./img/icons/plus.webp" alt="" class="icone">
                    <span>Adicionar Ferramenta</span>
                </a>
                    
                <a href="./adicionarBancada.php" class="item">
                    <img src="./img/icons/plus.webp" alt="" class="icone">
                    <span>Adicionar Bancada</span>
                </a>
                    
                <a href="./historicoReservas.php" class="item ativo">
                    <img src="./img/icons/pen_whiteback.webp" alt="" class="icone">
                    <span>Histórico de Reservas</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="conteudo">
        <h1>Histórico de reservas</h1>
        <br>
        <br>
        <?php foreach($reservas as $p): ?>
            <div>
                <div>
                    <p>Data:<?= $p['data_reserva'] ?></p>
                    <br>
                    <p>Tempo: <?= $p['horas_reservadas'] ?> hora(s)</p>
                    <br>
                    <p>
                        Reserva de: <?php $bancadaAtual = read(database(), "Bancadas", "id_bancada = ?", [$p['id_bancada']]); 
                        echo $bancadaAtual['nome_bancada']; ?>
                    </p>
                    <br>
                    <p>
                        Autor da reserva: <?php $userAtual = read(database(), "Usuarios", "id_usuario = ?", [$p['id_usuario']]); 
                        echo $userAtual['nome_usuario']; ?>
                    </p>
                    <p>-----------------------------------------------------------------------------------------</p>
                </div>
            </div>
            <br>
            <br>
        <?php endforeach; ?>

        <h1>FAZER CSS DESSA PAGINA</h1>
    </main>   
</body>
</html>