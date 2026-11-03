<?php

require_once __DIR__ . "/init.php";

$pesquisa  = trim($_GET['pesquisa'] ?? '');
$categoria = $_GET['categoria'] ?? '';

$condicoes = [];
$params    = [];

if ($pesquisa !== '') {
    $condicoes[] = '(nome LIKE ? OR descricao LIKE ?)';
    $params[]    = "%{$pesquisa}%";
    $params[]    = "%{$pesquisa}%";
}

if ($categoria !== '') {
    $condicoes[] = 'categoria = ?';
    $params[]    = $categoria;
}

$where   = $condicoes ? implode(' AND ', $condicoes) : null;
$objetos = readAll($pdo, 'objetos', $where, $params);

?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Integrador</title>

    <link rel="stylesheet" href="./css/style-index.css">
</head>

<body>
    <div class="busca">
        <form action="" method="get">
            <label for="pesquisa">Qual é o objeto perdido?</label>
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise aqui..."
                value="<?= htmlspecialchars($pesquisa) ?>">

            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
                <option value="">Todas</option>
                <option value="acessórios">Acessórios</option>
                <option value="bolsas e mochilas">Bolsas e Mochilas</option>
                <option value="documentos">Documentos</option>
                <option value="eletrônicos">Eletrônicos</option>
                <option value="roupas">Roupas</option>
            </select>

            <button type="submit">Buscar</button>
        </form>
    </div>

    <div class="telaObjetos">
        <?php if (!$objetos): ?>
            <p>Não encontramos nenhum objeto</p>
        <?php endif; ?>

        <?php foreach ($objetos as $o): ?>
            <?php if ($o['status_objeto'] == 'Perdido'): ?>

                <div class="objeto">
                    <p>Nome: <?= htmlspecialchars($o['nome']) ?></p>
                    <p>Descrição: <?= htmlspecialchars($o['descricao']) ?></p>
                    <p>Status: <?= htmlspecialchars($o['status_objeto']) ?></p>
                    <p>Categoria: <?= htmlspecialchars($o['categoria']) ?></p>

                    <form method="post" action="encontrei.php">
                        <input type="hidden" name="id" value="<?= $o['id'] ?>">
                        <button type="submit">Encontrei</button>
                    </form>

                    <?php
                    $texto = "Objeto perdido: {$o['nome']} - {$o['descricao']}. Viu por aí? Acesse o Findit!";
                    $link  = 'https://wa.me/?text=' . urlencode($texto);
                    ?>
                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener">Compartilhar</a>

                </div>
                <?php endif; ?>
            <?php endforeach; ?>


    </div>
</body>