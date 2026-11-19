<?php
declare(strict_types=1);

try {
    require_once __DIR__ . '/init.php';
} catch (Throwable $e) {
    error_log($e->getMessage());
    $pdo = null;
}

function tempoRelativo(string $data): string
{
    $timestamp = strtotime($data);
    if ($timestamp === false) {
        return '';
    }

    $diff = time() - $timestamp;

    if ($diff < 60) {
        return 'Agora mesmo';
    }
    if ($diff < 3600) {
        $m = (int) floor($diff / 60);
        return "Há $m minuto" . ($m > 1 ? 's' : '');
    }
    if ($diff < 86400) {
        $h = (int) floor($diff / 3600);
        return "Há $h hora" . ($h > 1 ? 's' : '');
    }

    $d = (int) floor($diff / 86400);
    return "Há $d dia" . ($d > 1 ? 's' : '');
}

function renderKanban(array $pedidos, array $colunas): void
{
    foreach ($colunas as $status => [$titulo, $classe]): ?>
        <div class="kanban-column <?= $classe ?>">
            <h2><?= htmlspecialchars($titulo) ?></h2>
            <div class="cards-espaço">
                <?php foreach ($pedidos as $id => $p): ?>
                    <?php if ($p['status'] === $status): ?>
                        <div class="card">
                            <div class="card-header">
                                <span><?= htmlspecialchars($p['id']) ?></span>
                                <span><?= htmlspecialchars($p['tempo']) ?></span>
                            </div>
                            <div class="card-body">
                                <p><?= htmlspecialchars($p['cliente']) ?></p>
                                <br>
                                <p><?= htmlspecialchars($p['local']) ?></p>
                            </div>
                            <div class="espaçamento-card">
                                <a href="acompanhamento.php?view=detalhes&id=<?= $id ?>" class="detalhes">Ver Detalhes</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach;
}

$mapaStatus = [
    'AGUARDANDO' => 'aberto',
    'ANDAMENTO'  => 'andamento',
    'FINALIZADO' => 'entregue',
];

$pedidos = [];
try {
    $linhas = $pdo->query(
        "SELECT * FROM pedidos WHERE statusPedido <> 'CANCELADO' ORDER BY criado_em DESC, id DESC"
    )->fetchAll();

    foreach ($linhas as $row) {
        $pedidos[(int) $row['id']] = [
            'id'       => 'Pedido ' . str_pad((string) $row['id'], 2, '0', STR_PAD_LEFT),
            'cliente'  => (string) ($row['responsavel'] ?? 'Não informado'),
            'local'    => (string) ($row['ambiente'] ?? ucfirst(strtolower((string) $row['categoria']))),
            'status'   => $mapaStatus[$row['statusPedido']] ?? 'aberto',
            'tempo'    => tempoRelativo((string) $row['criado_em']),
            'detalhes' => (string) $row['descricao'],
        ];
    }
} catch (Throwable $e) {
    error_log($e->getMessage());
}

$view       = (string) ($_GET['view'] ?? '');
$id_detalhe = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$colunas = [
    'aberto'    => ['Em Aberto',    'col-aberto'],
    'andamento' => ['Em Andamento', 'col-andamento'],
    'entregue'  => ['Entregue',     'col-entregue'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Acompanhamento</title>
    <?php if ($view === ''): ?>
        <meta http-equiv="refresh" content="5">
    <?php endif; ?>
    <link rel="stylesheet" href="stylesClientes/styleAcompanhamento.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="layout-principal">
        <aside class="barra-menu">
            <a href="index.php" class="logo.png" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="registro.php" class="nav-item">
                    <i></i>
                    <span>Registro de não conformidades</span>
                </a>
                <a href="analise.php" class="nav-item">
                    <i></i>
                    <span>Análise técnica e inspeção</span>
                </a>
                <a href="checklist.php" class="nav-item">
                    <i></i>
                    <span>Checklist</span>
                </a>
                <a href="acompanhamento.php" class="nav-item active">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item">
                    <i></i>
                    <span>Indicação</span>
                </a>
            </nav>
        </aside>

        <main class="espaço">
            <header class="barra-principal">
                <h1>Olá, aqui você verá o status de seus pedidos.</h1>
                <div class="header-buttons">
                    <a href="acompanhamento.php?view=historico" class="botao-de-fora">Histórico</a>
                    <a href="novo_pedido.php" class="botao-de-fora">Novo Pedido</a>
                </div>
            </header>

            <section class="kanban-board">
                <?php renderKanban($pedidos, $colunas); ?>
            </section>
        </main>
    </div>

    <?php if ($view === 'historico'): ?>
        <div class="modal-overlay">
            <div class="modal-box">
                <a href="acompanhamento.php" class="btn-fechar">&times;</a>
                <h2>Histórico de Pedidos Entregues</h2>

                <div class="lista-historico">
                    <?php
                    $temEntregues = false;
                    foreach ($pedidos as $id => $p):
                        if ($p['status'] === 'entregue'):
                            $temEntregues = true;
                    ?>
                        <div class="item-historico">
                            <div>
                                <strong><?= htmlspecialchars($p['id']) ?> - <?= htmlspecialchars($p['local']) ?></strong>
                                <p>Cliente: <?= htmlspecialchars($p['cliente']) ?></p>
                                <small>Registrado <?= htmlspecialchars(lcfirst($p['tempo'])) ?></small>
                            </div>
                            <a href="acompanhamento.php?view=detalhes&id=<?= $id ?>" class="detalhes">Ver Detalhes</a>
                        </div>
                    <?php
                        endif;
                    endforeach;

                    if (!$temEntregues):
                    ?>
                        <p>Nenhum pedido entregue no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($view === 'detalhes' && is_int($id_detalhe) && isset($pedidos[$id_detalhe])):
        $item = $pedidos[$id_detalhe];
    ?>
        <div class="modal-overlay">
            <div class="modal-box">
                <a href="acompanhamento.php" class="btn-fechar">&times;</a>
                <h2>Detalhes do <?= htmlspecialchars($item['id']) ?></h2>

                <div class="detalhes-conteudo">
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($item['cliente']) ?></p>
                    <p><strong>Local / Tipo:</strong> <?= htmlspecialchars($item['local']) ?></p>
                    <p><strong>Status Atual:</strong>
                        <span class="badge-status status-<?= htmlspecialchars($item['status']) ?>">
                            <?= htmlspecialchars(strtoupper($item['status'])) ?>
                        </span>
                    </p>
                    <p><strong>Registro:</strong> <?= htmlspecialchars($item['tempo']) ?></p>
                    <hr class="divisor">
                    <p><strong>Descrição e Observações:</strong></p>
                    <p class="texto-descricao"><?= htmlspecialchars($item['detalhes']) ?></p>
                </div>

                <div class="modal-rodape">
                    <a href="acompanhamento.php" class="btn-voltar">Fechar</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>
