<?php

require_once __DIR__ . "/init.php";

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['voltar_para'] = 'meusObjetos.php';
    header('Location: login.php?erro[]=' . urlencode('Faça login para ver seus objetos cadastrados.'));
    exit;
}

$idUsuario = (int) $_SESSION['id_usuario'];
$pesquisa  = trim($_GET['pesquisa'] ?? '');
$categoria = $_GET['categoria'] ?? '';
$status    = $_GET['status'] ?? '';

$condicoes = ['nomeUsuario = ?'];
$params    = [$idUsuario];

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

$where   = implode(' AND ', $condicoes);
$objetos = readAll($pdo, 'objetos', $where, $params);

usort($objetos, fn($a, $b) => $b['idObjeto'] <=> $a['idObjeto']);

$classeStatus = [
    'Perdido'    => 'perdido',
    'Encontrado' => 'encontrado',
    'Doado'      => 'doado',
];

?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus Objetos</title>

    <link rel="stylesheet" href="./css/style-painelObjetos.css">
    <link rel="icon" type="image/png" href="./imagens/finditDesenho.png">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png" alt="FindIt"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.jpg" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>
        <div class="fundo">

            <div class="busca">
                <form action="" method="get">
                    <div class="campo campo-busca">
                        <label for="pesquisa">Meus objetos cadastrados</label>
                        <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise nos seus objetos..."
                            value="<?= htmlspecialchars($pesquisa) ?>">
                    </div>

                    <div class="campo">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" id="categoria">
                            <option value="">Todas</option>
                            <?php foreach (['Acessórios', 'Bolsas e Mochilas', 'Documentos', 'Eletrônicos', 'Roupas', 'Outros'] as $c): ?>
                                <option value="<?= htmlspecialchars($c) ?>" <?= $categoria === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="campo">
                        <label for="status">Status do Objeto</label>
                        <select name="status" id="status">
                            <option value="">Todos</option>
                            <?php foreach (['Perdido', 'Encontrado', 'Doado'] as $s): ?>
                                <option value="<?= htmlspecialchars($s) ?>" <?= $status === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="acoes-filtro">
                        <button type="submit">Filtrar</button>
                        <a href="./painelObjetos.php" class="meusObjetos">Voltar ao painel</a>
                    </div>
                </form>
            </div>

            <div class="telaObjetos">
                <?php if (!$objetos): ?>
                    <p>Você ainda não cadastrou nenhum objeto com esses filtros.</p>
                <?php endif; ?>

                <?php foreach ($objetos as $o): ?>
                    <?php
                    $classe = $classeStatus[$o['status_objeto']] ?? '';
                    $achado = false;
                    $ponto  = false;

                    
                    if ($o['status_objeto'] === 'Encontrado') {
                        $achado = read($pdo, 'achado', 'idObjeto = ?', [(int) $o['idObjeto']]);

                        if ($achado) {
                            $ponto = read($pdo, 'pontoColeta', 'idEndereco = ?', [(int) $achado['idPontoColeta']]);
                        }
                    }
                    ?>
                    <div class="objeto">
                        <div class="emoji">
                            <p><?= htmlspecialchars($o['imagemObjeto']) ?></p>
                        </div>

                        <p class="selo selo-<?= $classe ?>"><?= htmlspecialchars($o['status_objeto']) ?></p>
                        <p class="nomeObjeto"><?= htmlspecialchars($o['nome']) ?></p>

                        <div class="conteudo">
                            <p>Descrição: <?= htmlspecialchars($o['descricao']) ?></p>
                            <p>Categoria: <?= htmlspecialchars($o['categoria']) ?></p>

                            <?php if ($o['status_objeto'] === 'Perdido'): ?>
                                <div class="info-perdido">
                                    <p><strong>Status:</strong> Ainda perdido — aguardando alguém encontrar.</p>
                                </div>
                                <div class="botao">
                                    <?php
                                    $texto = "Objeto perdido: {$o['nome']} - {$o['descricao']}. Viu por aí? Acesse o Findit!";
                                    $link  = 'https://wa.me/?text=' . urlencode($texto);
                                    ?>
                                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener" class="botaoCompartilhar">Compartilhar</a>
                                </div>

                            <?php elseif ($o['status_objeto'] === 'Encontrado'): ?>
                                <?php if ($achado && !empty($achado['dataRetirada'])): ?>
                                    <div class="info-retirado">
                                        <p><strong>Retirado em:</strong> <?= date('d/m/Y', strtotime($achado['dataRetirada'])) ?></p>
                                    </div>
                                <?php elseif ($achado && $ponto): ?>
                                    <div class="local-retirada">
                                        <p><strong>Encontrado! Pode retirar em:</strong> <?= htmlspecialchars($ponto['nome']) ?></p>
                                        <p>
                                            <?= htmlspecialchars($ponto['logradouro']) ?>, <?= (int) $ponto['numero'] ?>
                                            - <?= htmlspecialchars($ponto['bairro']) ?>
                                            (<?= htmlspecialchars($ponto['cidade']) ?>/<?= htmlspecialchars($ponto['estado']) ?>)
                                        </p>
                                        <p><strong>Estado:</strong> <?= htmlspecialchars($achado['estadoObjeto']) ?></p>
                                    </div>
                                <?php else: ?>
                                    <div class="local-retirada">
                                        <p><strong>Encontrado!</strong> Ponto de coleta ainda não informado — consulte a recepção.</p>
                                    </div>
                                <?php endif; ?>

                            <?php elseif ($o['status_objeto'] === 'Doado'): ?>
                                <div class="info-doado">
                                    <p><strong>Já foi doado:</strong> o prazo de retirada encerrou e o objeto foi encaminhado para doação.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </main>

    <footer>
        <div class="rodape-coluna">
            <p>Sistema de achados e perdidos. Devolvendo pertences de forma rápida e simples.</p>
        </div>

        <div class="direitos">
            <p>&copy; 2026 Celeste System. Todos os direitos reservados.</p>
        </div>
    </footer>

    <svg style="display: none;">
        <filter id="liquid-glass">
            <feTurbulence
                type="fractalNoise"
                baseFrequency="0.006 0.006"
                numOctaves="2"
                seed="2"
                result="noise" />
            <feGaussianBlur
                in="noise"
                stdDeviation="3"
                result="smoothedNoise" />
            <feDisplacementMap
                in="SourceGraphic"
                in2="smoothedNoise"
                scale="50"
                xChannelSelector="R"
                yChannelSelector="G" />
        </filter>
    </svg>
</body>

</html>