<?php

require_once __DIR__ . "/init.php";

$pesquisa  = trim($_GET['pesquisa'] ?? '');
$categoria = $_GET['categoria'] ?? '';
$status = $_GET['status'] ?? '';

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

if ($status !== '') {
    $condicoes[] = 'status_objeto = ?';
    $params[]    = $status;
}

$where   = $condicoes ? implode(' AND ', $condicoes) : null;
$objetos = readAll($pdo, 'objetos', $where, $params);



?>

<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel Objetos</title>


    <link rel="stylesheet" href="./css/style-painelObjetos.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.png" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./CadastrarItem.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>

        <div class="fundo">

            <div class="busca">
                <form action="" method="get">
                    <div>
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
                            <option value="outros">Outros</option>
                        </select>

                        <label for="status">Status do Objeto</label>
                        <select name="status" id="status">
                            <option value="">Todos</option>
                            <option value="perdido">Perdido</option>
                            <option value="encontrado">Encontrado</option>
                            <option value="abandonado">Abandonado</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="telaObjetos">
                <?php if (!$objetos): ?>
                    <p>Não encontramos nenhum objeto</p>
                <?php endif; ?>

                <?php foreach ($objetos as $o): ?>
                    <div class="objeto">
                        <div class="emoji">
                            <p><?= htmlspecialchars($o['imagemObjeto']) ?></p>
                        </div>
                        <div class="conteudo">
                            <p>Nome: <?= htmlspecialchars($o['nome']) ?></p>
                            <p>Descrição: <?= htmlspecialchars($o['descricao']) ?></p>
                            <p>Status: <?= htmlspecialchars($o['status_objeto']) ?></p>
                            <p>Categoria: <?= htmlspecialchars($o['categoria']) ?></p>
                            <?php if ($o['status_objeto'] == 'Perdido'): ?>
                                <div class="botao">
                                    <a href="./encontrei.php?idObjeto=<?= $o['idObjeto'] ?>" class="botaoEncontrei">Encontrei!!</a>

                                    <?php
                                    $texto = "Objeto perdido: {$o['nome']} - {$o['descricao']}. Viu por aí? Acesse o Findit!";
                                    $link  = 'https://wa.me/?text=' . urlencode($texto);
                                    ?>

                                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener" class="botaoCompartilhar">Compartilhar</a>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>
    </main>
</body>