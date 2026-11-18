<?php


require_once __DIR__ . '/init.php';


$projetos = readAll(database(), "Projetos");


// Paginação: 4 projetos por página
$porPagina = 4;
$totalPaginas = max(1, ceil(count($projetos) / $porPagina));


$paginaAtual = (int) ($_GET['pagina'] ?? 1);
if ($paginaAtual < 1) {
    $paginaAtual = 1;
}
if ($paginaAtual > $totalPaginas) {
    $paginaAtual = $totalPaginas;
}


$projetosDaPagina = array_slice($projetos, ($paginaAtual - 1) * $porPagina, $porPagina);


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Projetos</title>
    <link rel="stylesheet" href="/css/projetos.css">
</head>
<body>
    <?php require_once __DIR__ . '/nav.php' ?>


    <main class="pag">


        <div class="topo">
            <a class="botao-novo" href="#">+ Novo Projeto</a>
        </div>


        <h1 class="titulo-projetos">Projetos da comunidade:</h1>


        <?php foreach($projetosDaPagina as $p): ?>


            <?php
                // Busca o nome do autor (se existir)
                $autor = null;
                if (!empty($p['id_usuario'])) {
                    $autor = read(database(), "Usuarios", "id_usuario = ?", [$p['id_usuario']]);
                }
            ?>


            <div class="projeto">


                <?php if (!empty($p['imagem_projeto'])): ?>
                    <img class="projeto-imagem" src="<?= $p['imagem_projeto'] ?>" alt="">
                <?php else: ?>
                    <div class="projeto-imagem sem-imagem"></div>
                <?php endif; ?>


                <div class="projeto-texto">
                    <h2><?= $p['nome_projeto'] ?></h2>
                    <p><?= $p['descricao_projeto'] ?></p>
                </div>


                <?php if ($autor): ?>
                    <p class="projeto-autor"><b>Por:</b> <?= $autor['nome_usuario'] ?></p>
                <?php endif; ?>


            </div>


        <?php endforeach; ?>


        <div class="paginacao">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <a class="pagina <?= $i == $paginaAtual ? 'pagina-ativa' : '' ?>" href="projetos.php?pagina=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>


    </main>


    <?php require_once __DIR__ . '/footer.php' ?>
</body>
</html>