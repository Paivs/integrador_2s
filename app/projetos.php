<?php 

require_once __DIR__ . '/init.php';

$projetos = readAll(database(), "Projetos");


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <link rel="stylesheet" href="./css/projetos.css">
</head>
<body>
    <?php require_once __DIR__ . '/nav.php' ?>
    <br>
    <main class="pag">
        <strong><h1>Projetos realizados pela nossa comunidade:</h1></strong>
        <br>
        <br>
        <?php foreach($projetos as $p): ?>
            <div class="secaoCards">
                <div class="card">
                    <h1><?= $p['nome_projeto'] ?></h1>
                    <br>
                    <p>Descrição: <?= $p['descricao_projeto'] ?></p>
                </div>
            </div>
            <br>
            <br>
        <?php endforeach; ?>
    </main>
    <?php require_once __DIR__ . '/footer.php' ?>
</body>
</html>