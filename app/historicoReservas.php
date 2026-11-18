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

    $reservas = readAll(database(), "Reservas", "1 ORDER BY data_reserva DESC");

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Reservas</title>
    <link rel="stylesheet" href="css/navAdm.css">
    <link rel="stylesheet" href="css/historicoReservas.css">
</head>
<body>
    <header>

        <nav class="sidebar">
            <div class="sidebar-content">

                <div class="logo">
                    <a href="index.php"><img src="img/cabecalho/logo.png" alt=""></a>
                </div>

                <a href="./dashboard.php" class="item">
                    <img src="./img/icons/pen_branco.png" alt="" class="icone">
                    <span>Dashboard</span>
                </a>

                <a href="./adicionarFerramenta.php" class="item">
                    <img src="./img/icons/plus_branco.png" alt="" class="icone">
                    <span>Ferramenta</span>
                </a>

                <a href="./adicionarBancada.php" class="item">
                    <img src="./img/icons/plus_branco.png" alt="" class="icone">
                    <span>Bancada</span>
                </a>

                <a href="./historicoReservas.php" class="item ativo">
                    <img src="./img/icons/folder_roxo.png" alt="" class="icone">
                    <span>Reservas</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="conteudo">

        <h1 class="titulo-pagina">Histórico de Reservas</h1>

        <?php foreach($reservas as $p): ?>
            <?php
                // Busca a bancada e o autor desta reserva
                $bancada = read(database(), "Bancadas", "id_bancada = ?", [$p['id_bancada']]);
                $autor = read(database(), "Usuarios", "id_usuario = ?", [$p['id_usuario']]);
            ?>

            <div class="reserva">

                <img class="reserva-imagem" src="<?= $bancada['imagens_bancada'] ?>" alt="">

                <div class="reserva-bancada">
                    <p class="reserva-titulo"><b>Reserva de:</b> <?= $bancada['nome_bancada'] ?></p>
                    <p class="reserva-autor">Autor da reserva: <?= $autor['nome_usuario'] ?></p>
                </div>

                <div class="reserva-data">
                    <p class="reserva-titulo"><b>Data:</b> <?= date('d/m/Y H:i', strtotime($p['data_reserva'])) ?></p>
                    <p class="reserva-tempo"><b>Tempo:</b> <?= $p['horas_reservadas'] ?> hora(s)</p>
                </div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($reservas)): ?>
            <p class="sem-reservas">Nenhuma reserva encontrada.</p>
        <?php endif; ?>

    </main>
</body>
</html>