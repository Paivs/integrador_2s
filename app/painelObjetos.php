<?php

require_once __DIR__ . "/init.php";

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['voltar_para'] = 'painelObjetos.php';
    header('Location: login.php?erro[]=' . urlencode('Faça login para ver os objetos guardados.'));
    exit;
}

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

usort($objetos, fn($a, $b) => $b['idObjeto'] <=> $a['idObjeto']);

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
                        <label for="pesquisa">Qual é o objeto perdido?</label>
                        <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquise aqui..."
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
                        <button type="submit">Buscar</button>
                    </div>
                </form>
            </div>

            <div class="telaObjetos">
                <?php if (!$objetos): ?>
                    <p>Não encontramos nenhum objeto</p>
                <?php endif; ?>

                <?php
                $classeStatus = [
                    'Perdido'    => 'perdido',
                    'Encontrado' => 'encontrado',
                    'Doado'      => 'doado',
                ];
                ?>

                <?php foreach ($objetos as $o): ?>
                    <?php $classe = $classeStatus[$o['status_objeto']] ?? ''; ?>
                    <div class="objeto">
                        <div class="emoji">
                            <p><?= htmlspecialchars($o['imagemObjeto']) ?></p>
                        </div>
                        <p class="selo selo-<?= $classe ?>"><?= htmlspecialchars($o['status_objeto']) ?></p>
                        <p class="nomeObjeto" ><?= htmlspecialchars($o['nome']) ?></p>
                        <div class="conteudo">
                            <p>Descrição: <?= htmlspecialchars($o['descricao']) ?></p>
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
          result="noise" 
        />
        <feGaussianBlur 
          in="noise" 
          stdDeviation="3" 
          result="smoothedNoise" 
        />
        <feDisplacementMap 
          in="SourceGraphic" 
          in2="smoothedNoise" 
          scale="50" 
          xChannelSelector="R" 
          yChannelSelector="G" 
        />
      </filter>
    </svg>

</body>