<?php
// Simulação do Banco de Dados de Pedidos
$pedidos = [
    1 => ['id' => 'Pedido 01', 'cliente' => 'Thiago Navarro', 'local' => 'Condomínio', 'status' => 'aberto', 'tempo' => 'Há 7 minutos', 'detalhes' => 'Vistoria no quadro geral de distribuição do bloco A.'],
    2 => ['id' => 'Pedido 01', 'cliente' => 'Thiago Navarro', 'local' => 'Casa', 'status' => 'aberto', 'tempo' => 'Há 43 minutos', 'detalhes' => 'Análise de sobrecarga nas tomadas da cozinha.'],
    3 => ['id' => 'Pedido 01', 'cliente' => 'Thiago Navarro', 'local' => 'Posto de Gasolina', 'status' => 'aberto', 'tempo' => 'Há 2 horas', 'detalhes' => 'Inspeção de áreas classificadas e laudo de aterramento.'],
    4 => ['id' => 'Pedido 02', 'cliente' => 'Thiago Oliveira', 'local' => 'Galpão Fabril', 'status' => 'andamento', 'tempo' => 'Há 9 horas', 'detalhes' => 'Adequação dos painéis conforme a norma NR-10.'],
    5 => ['id' => 'Pedido 02', 'cliente' => 'Thiago Oliveira', 'local' => 'Igreja', 'status' => 'andamento', 'tempo' => 'Há 9 horas', 'detalhes' => 'Revisão do sistema elétrico de iluminação.'],
    6 => ['id' => 'Pedido 01', 'cliente' => 'Thiago Oliveira Navarro', 'local' => 'Shopping', 'status' => 'entregue', 'tempo' => 'Há 1 dia', 'detalhes' => 'Laudo técnico completo de entrega e liberação emitido.'],
    7 => ['id' => 'Pedido 03', 'cliente' => 'Thiago Oliveira Navarro', 'local' => 'Supermercado', 'status' => 'entregue', 'tempo' => 'Há 3 dias', 'detalhes' => 'Inspeção termográfica e relatório final entregue com sucesso.']
];

// Captura a ação vinda do clique via GET
$view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_SPECIAL_CHARS);
$id_detalhe = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Acompanhamento</title>
    <link rel="stylesheet" href="stylesClientes/styleAcompanhamento.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="layout-principal">
        <aside class="barra-menu">
               <img src="imagens/logo.png" alt="Logo">
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
                <h1>Olá Thiago, aqui você verá o status de seus pedidos.</h1>
                <div class="header-buttons">
                    <!-- Ação em PHP via URL GET -->
                    <a href="acompanhamento.php?view=historico" class="botao-de-fora">Histórico</a>
                    <a href="novo_pedido.php" class="botao-de-fora">Novo Pedido</a>
                </div>
            </header>

            <section class="kanban-board">
                
                <!-- Coluna: Em Aberto -->
                <div class="kanban-column col-aberto">
                    <h2>Em Aberto</h2>
                    <div class="cards-espaço">
                        <?php foreach ($pedidos as $id => $p): ?>
                            <?php if ($p['status'] === 'aberto'): ?>
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

                <!-- Coluna: Em Andamento -->
                <div class="kanban-column col-andamento">
                    <h2>Em Andamento</h2>
                    <div class="cards-espaço">
                        <?php foreach ($pedidos as $id => $p): ?>
                            <?php if ($p['status'] === 'andamento'): ?>
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

                <!-- Coluna: Entregue -->
                <div class="kanban-column col-entregue">
                    <h2>Entregue</h2>
                    <div class="cards-espaço">
                        <?php foreach ($pedidos as $id => $p): ?>
                            <?php if ($p['status'] === 'entregue'): ?>
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

            </section>
        </main>
    </div>

    <!-- Lógica PHP: Exibe o formulário de Histórico -->
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
                                <small>Concluído <?= htmlspecialchars($p['tempo']) ?></small>
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

    <!-- Lógica PHP: Exibe os Detalhes do Pedido Selecionado -->
    <?php if ($view === 'detalhes' && isset($pedidos[$id_detalhe])): 
        $item = $pedidos[$id_detalhe];
    ?>
        <div class="modal-overlay">
            <div class="modal-box">
                <a href="acompanhamento.php" class="btn-fechar">&times;</a>
                <h2>Detalhes do <?= htmlspecialchars($item['id']) ?></h2>
                
                <div class="detalhes-conteudo">
                    <p><strong>Cliente:</strong> <?= htmlspecialchars($item['cliente']) ?></p>
                    <p><strong>Local / Tipo:</strong> <?= htmlspecialchars($item['local']) ?></p>
                    <p><strong>Status Atual:</strong> <span class="badge-status status-<?= $item['status'] ?>"><?= strtoupper($item['status']) ?></span></p>
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