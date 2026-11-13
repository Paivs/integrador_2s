<?php
session_start();

// Define a página inicial padrão
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// 1. INICIALIZAÇÃO DO CARDÁPIO NA SESSÃO (Caso ainda não exista)
if (!isset($_SESSION['cardapio'])) {
    $_SESSION['cardapio'] = [
        1 => [
            'id' => 1,
            'nome' => 'Espresso Doce Encontro',
            'preco' => 10.90,
            'categoria' => 'cafes',
            'tag' => 'Mais Pedido',
            'descricao' => 'Blend exclusivo 100% arábica com mini trufa artesanal.',
            'imagem' => 'expresso.jpg.png'
        ],
        2 => [
            'id' => 2,
            'nome' => 'Cappuccino de Avelã',
            'preco' => 16.50,
            'categoria' => 'cafes',
            'tag' => 'Artesanal',
            'descricao' => 'Espresso, leite vaporizado, avelã e canela polvilhada.',
            'imagem' => 'avelã.jpg.png'
        ],
        3 => [
            'id' => 3,
            'nome' => 'Pink Velvet Latte',
            'preco' => 18.00,
            'categoria' => 'cafes',
            'tag' => 'Especial',
            'descricao' => 'Leite cremoso com toque suave de baunilha e chantilly rosa.',
            'imagem' => 'pink.png'
        ],
        4 => [
            'id' => 4,
            'nome' => 'Torta Rosa de Frutas Vermelhas',
            'preco' => 19.90,
            'categoria' => 'doces',
            'tag' => 'Sucesso',
            'descricao' => 'Massa sablée, creme de baunilha e seleção de frutas vermelhas.',
            'imagem' => 'FRUTAS.JPG.png'
        ],
        5 => [
            'id' => 5,
            'nome' => 'Trio de Macarons Vintage',
            'preco' => 15.00,
            'categoria' => 'doces',
            'tag' => 'Sem Glúten',
            'descricao' => 'Pistache, Framboesa e Doce de Leite.',
            'imagem' => 'trio.jpg.png'
        ],
        6 => [
            'id' => 6,
            'nome' => 'Pão de queijo Romeu & Julieta',
            'preco' => 18.50,
            'categoria' => 'salgados',
            'tag' => 'Quentinho',
            'descricao' => 'Folhado artesanal com queijo brie e peito de peru.',
            'imagem' => 'pao-quijo.png'
        ]
    ];
}

// 2. INICIALIZAÇÃO DO STATUS DO PEDIDO
if (!isset($_SESSION['status_pedido'])) {
    $_SESSION['status_pedido'] = 2;
}

// 3. PROCESSAMENTO DE AÇÕES (CADASTRAR, EDITAR, REMOVER E MUDAR STATUS)

// Ação: Mudar Status do Pedido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mudar_status') {
    $_SESSION['status_pedido'] = (int)$_POST['novo_status'];
    header("Location: index.php?page=status");
    exit;
}

// Ação: Salvar Item (Adicionar ou Alterar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'salvar_item') {
    $id = !empty($_POST['id']) ? (int)$_POST['id'] : time();
    $nome = trim($_POST['nome']);
    $preco = (float)$_POST['preco'];
    $categoria = $_POST['categoria'];
    $tag = trim($_POST['tag']);
    $descricao = trim($_POST['descricao']);
    $imagem = !empty($_POST['imagem']) ? trim($_POST['imagem']) : 'expresso.jpg.png';

    if (!empty($nome) && $preco > 0) {
        $_SESSION['cardapio'][$id] = [
            'id' => $id,
            'nome' => $nome,
            'preco' => $preco,
            'categoria' => $categoria,
            'tag' => $tag,
            'descricao' => $descricao,
            'imagem' => $imagem
        ];
    }
    $msg = isset($_POST['id']) && !empty($_POST['id']) ? 'item_atualizado' : 'item_adicionado';
    header("Location: index.php?page=admin&msg=" . $msg);
    exit;
}

// Ação: Remover Item
if (isset($_GET['action']) && $_GET['action'] === 'remover_item' && isset($_GET['id'])) {
    $id_remover = (int)$_GET['id'];
    if (isset($_SESSION['cardapio'][$id_remover])) {
        unset($_SESSION['cardapio'][$id_remover]);
    }
    header("Location: index.php?page=admin&msg=item_removido");
    exit;
}

// Ação: Restaurar Cardápio Padrão
if (isset($_GET['action']) && $_GET['action'] === 'restaurar_cardapio') {
    unset($_SESSION['cardapio']);
    header("Location: index.php?page=admin&msg=cardapio_restaurado");
    exit;
}

// Se estiver editando um item no Admin, carrega os dados dele
$item_edicao = null;
if ($page === 'admin' && isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if (isset($_SESSION['cardapio'][$edit_id])) {
        $item_edicao = $_SESSION['cardapio'][$edit_id];
    }
}

// Mapeamento das Informações de Status
$status_info = [
    1 => ['nome' => 'Pedido Recebido', 'badge' => 'Recebido', 'desc' => 'Confirmado no sistema', 'cor' => 'bg-doce-mint-base text-white'],
    2 => ['nome' => 'Em Preparo', 'badge' => 'Em Preparo', 'desc' => 'Sendo montado na cozinha', 'cor' => 'bg-doce-pink-base text-doce-pink-dark'],
    3 => ['nome' => 'Saiu para Entrega', 'badge' => 'A Caminho', 'desc' => 'Entregador a caminho', 'cor' => 'bg-doce-gold text-white'],
    4 => ['nome' => 'Momento Doce!', 'badge' => 'Entregue', 'desc' => 'Entregue com carinho', 'cor' => 'bg-doce-mint-deep text-white']
];

$current_status = $_SESSION['status_pedido'];
$cardapio_items = $_SESSION['cardapio'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchonete Doce Encontro | Café & Doceria Vintage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css">

    <style>
        .pink-awning-bg {
            height: 16px;
            width: 100%;
            background: repeating-linear-gradient(90deg, #F3C5CE, #F3C5CE 25px, #FAF0F2 25px, #FAF0F2 50px);
        }
        .mint-awning-bg {
            background: repeating-linear-gradient(90deg, #9BB9A5, #9BB9A5 20px, #72957E 20px, #72957E 40px);
        }
        .btn-aesthetic-home {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            color: #4A3B32;
            font-family: 'Playfair Display', serif;
            font-size: 12px; font-weight: 700;
            text-transform: uppercase;
            background: linear-gradient(135deg, #FFF9F2 0%, #F3C5CE 50%, #E79DAA 100%);
            border: 2px solid #D4AF37;
        }
        .btn-admin-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px;
            border-radius: 999px;
            background: linear-gradient(135deg, #72957E 0%, #4C6B56 100%);
            border: 1px solid #D4AF37;
        }
        .modal-target { display: none; }
        .modal-target:target { display: flex !important; }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'doce-pink-light': '#FAF0F2',
                        'doce-pink-base': '#F3C5CE',
                        'doce-pink-accent': '#E79DAA',
                        'doce-pink-dark': '#D87A8C',
                        'doce-mint-light': '#E8F0EC',
                        'doce-mint-base': '#9BB9A5',
                        'doce-mint-dark': '#72957E',
                        'doce-mint-deep': '#4C6B56',
                        'doce-gold': '#D4AF37',
                        'doce-cream': '#FFFAF5',
                        'doce-text': '#4A3B32'
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        garamond: ['"Cormorant Garamond"', 'serif'],
                        sans: ['Montserrat', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="antialiased selection:bg-doce-pink-accent selection:text-white min-h-screen flex flex-col justify-between bg-doce-pink-light text-doce-text">
    <div>
        <div class="pink-awning-bg h-4 w-full shadow-sm"></div>
        <header class="sticky top-0 z-50 bg-doce-mint-base text-white shadow-md border-b-4 border-doce-mint-dark">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-24">
                    <a href="index.php?page=home" class="flex items-center gap-3 group text-left focus:outline-none">
                        <div class="w-12 h-12 rounded-full bg-doce-cream border-2 border-doce-gold flex items-center justify-center text-doce-mint-dark shadow-inner group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-mug-hot text-xl text-doce-pink-dark"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs uppercase tracking-[0.3em] font-semibold text-doce-cream opacity-90">Lanchonete</span>
                            <span class="font-serif text-2xl sm:text-3xl font-bold tracking-wider text-doce-cream drop-shadow-md">
                                DOCE ENCONTRO
                            </span>
                        </div>
                    </a>
                    <nav class="hidden lg:flex items-center space-x-5 text-xs font-medium tracking-wide">
                        <a href="index.php?page=home" class="btn-aesthetic-home px-4 py-2 rounded-full text-doce-text font-bold text-xs uppercase flex items-center gap-2">
                            <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-doce-pink-dark shadow-sm">
                                <i class="fa-solid fa-house text-sm"></i>
                            </span>
                            <span class="font-serif">Início</span>
                        </a>

                        <a href="index.php?page=cardapio" class="text-doce-cream hover:text-doce-gold transition-colors py-1 font-semibold">Cardápio (<?php echo count($cardapio_items); ?>)</a>
                        <a href="index.php?page=status" class="text-doce-cream hover:text-doce-gold transition-colors py-1 flex items-center gap-1.5">
                            <i class="fa-solid fa-clock-rotate-left text-xs"></i> Status do Pedido
                        </a>
                        <a href="index.php?page=sobre" class="text-doce-cream hover:text-doce-gold transition-colors py-1">Sobre Nós</a>
                        <a href="index.php?page=contato" class="text-doce-cream hover:text-doce-gold transition-colors py-1">Contato</a>

                        <a href="#admin-pin-modal" class="btn-admin-pill text-white font-bold px-3.5 py-2 rounded-full text-[11px] uppercase tracking-wider flex items-center gap-1.5 shadow-md">
                            <i class="fa-solid fa-key text-doce-gold"></i> Painel Admin
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <div id="app-content">

            <?php if ($page === 'home'): ?>
            <!-- PÁGINA: INÍCIO -->
            <section class="py-16 lg:py-24 bg-doce-pink-light">
                <div class="max-w-7xl mx-auto px-4 text-center lg:text-left">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                        <div class="lg:col-span-7 space-y-6">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-doce-pink-base/40 border border-doce-pink-accent/50 text-doce-mint-deep text-xs font-semibold uppercase">
                                <i class="fa-solid fa-sparkles text-doce-gold"></i> O Cantinho Mais Charmoso da Cidade
                            </div>
                            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold text-doce-text leading-tight">
                                Onde o afeto encontra o <span class="text-doce-pink-dark italic font-garamond">sabor inesquecível</span>
                            </h1>
                            <p class="text-base sm:text-lg text-doce-text/80 leading-relaxed">
                                Bem-vindo à <strong>Lanchonete Doce Encontro</strong>. Delicie-se com nossos cafés artesanais frescos e salgados especiais.
                            </p>
                            <div class="pt-4">
                                <a href="index.php?page=cardapio" class="bg-doce-mint-base text-white px-8 py-4 rounded-full font-bold shadow-lg hover:bg-doce-mint-dark transition inline-flex items-center gap-2">
                                    <i class="fa-solid fa-book-open"></i> Ver Cardápio Completo (<?php echo count($cardapio_items); ?> itens)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php elseif ($page === 'cardapio'): ?>
            <!-- PÁGINA: CARDÁPIO (EXIBE TODOS OS ITENS CADASTRADOS) -->
            <section class="py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    
                    <div class="text-center max-w-3xl mx-auto mb-10">
                        <span class="text-doce-pink-dark font-semibold text-xs uppercase tracking-widest">Sabores Inesquecíveis</span>
                        <h1 class="font-serif text-4xl font-bold text-doce-text mt-1">Nosso Cardápio Artesanal</h1>
                        <p class="text-xs text-doce-text/70 mt-2">Atualmente temos <?php echo count($cardapio_items); ?> delícias disponíveis</p>
                    </div>

                    <?php if (empty($cardapio_items)): ?>
                        <div class="bg-white p-10 rounded-3xl text-center shadow-md border-2 border-dashed border-doce-mint-base/40 max-w-xl mx-auto my-8">
                            <i class="fa-solid fa-cookie-bite text-5xl text-doce-pink-dark mb-3"></i>
                            <h3 class="font-serif text-2xl font-bold text-doce-text">Nenhum item cadastrado no cardápio</h3>
                            <p class="text-xs text-doce-text/70 mt-2 mb-4">Acesse o painel do administrador para adicionar deliciosos produtos!</p>
                            <a href="index.php?page=admin" class="bg-doce-mint-base text-white px-6 py-2.5 rounded-full font-bold text-xs uppercase shadow">Ir ao Painel Admin</a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($cardapio_items as $item): ?>
                                <div class="bg-white p-6 rounded-2xl border-2 border-doce-mint-base/30 shadow-md flex flex-col justify-between hover:shadow-xl transition">
                                    <div>
                                        <div class="flex justify-between items-start mb-3 gap-3">
                                            <img src="<?php echo htmlspecialchars($item['imagem']); ?>" width="110" alt="<?php echo htmlspecialchars($item['nome']); ?>" class="rounded-xl object-cover h-24 border border-doce-mint-base/20">
                                            <div class="flex flex-col">
                                                <h3 class="font-serif text-lg font-bold text-doce-text leading-snug"><?php echo htmlspecialchars($item['nome']); ?></h3>
                                                <span class="font-serif text-lg font-bold text-doce-mint-dark mt-1">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-doce-text/70 mb-4 leading-relaxed"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-doce-pink-light">
                                        <span class="text-[10px] uppercase tracking-wider bg-doce-pink-base/30 text-doce-pink-dark px-2.5 py-1 rounded-md font-semibold">
                                            <?php echo htmlspecialchars($item['tag']); ?>
                                        </span>
                                        <a href="index.php?page=status" class="text-xs bg-doce-mint-base hover:bg-doce-mint-dark text-white px-3.5 py-1.5 rounded-full font-semibold flex items-center gap-1 transition">
                                            <i class="fa-solid fa-plus text-[10px]"></i> Pedir
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </section>

            <?php elseif ($page === 'status'): ?>
            <!-- PÁGINA: STATUS DO PEDIDO -->
            <section class="py-12">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-8">
                        <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-doce-text">
                            Status do seu <span class="italic font-garamond text-doce-pink-dark">Pedido Doce</span>
                        </h1>
                    </div>

                    <div class="bg-doce-cream rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden border-4 border-doce-mint-base">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b-2 border-dashed border-doce-mint-base/40 gap-4">
                            <div>
                                <span class="text-[11px] font-bold uppercase text-doce-mint-dark">Código da Encomenda</span>
                                <h2 class="font-serif text-2xl font-bold text-doce-text">#DE-8492</h2>
                            </div>
                            <span class="px-4 py-2 rounded-full text-xs font-bold uppercase shadow-sm <?php echo $status_info[$current_status]['cor']; ?>">
                                <?php echo $status_info[$current_status]['badge']; ?>
                            </span>
                        </div>

                        <div class="py-10 grid grid-cols-1 md:grid-cols-4 gap-6">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <?php $isActive = ($i <= $current_status); ?>
                                <div class="flex flex-col items-center text-center <?php echo $isActive ? 'opacity-100 font-bold' : 'opacity-40'; ?>">
                                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-xl mb-2 border-4 border-white shadow-lg <?php echo $i === $current_status ? 'bg-doce-pink-dark text-white ring-4 ring-doce-pink-base/50' : ($isActive ? 'bg-doce-mint-base text-white' : 'bg-gray-200 text-gray-400'); ?>">
                                        <i class="fa-solid <?php echo $i === 1 ? 'fa-check' : ($i === 2 ? 'fa-utensils' : ($i === 3 ? 'fa-motorcycle' : 'fa-heart')); ?>"></i>
                                    </div>
                                    <span class="text-[10px] uppercase text-doce-text/70">Etapa 0<?php echo $i; ?></span>
                                    <h4 class="font-serif font-bold text-sm text-doce-text"><?php echo $status_info[$i]['nome']; ?></h4>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php elseif ($page === 'admin'): ?>
            <!-- PÁGINA: PAINEL ADMIN (CADASTRAR, EDITAR, REMOVER & GERENCIAR) -->
            <section class="py-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                    <!-- MENSAGENS DO SISTEMA -->
                    <?php if (isset($_GET['msg'])): ?>
                        <div class="mb-6 p-4 rounded-xl text-xs font-bold text-white bg-doce-mint-deep shadow-md flex items-center justify-between">
                            <span>
                                <?php 
                                    if ($_GET['msg'] === 'item_adicionado') echo "✨ Novo item cadastrado com sucesso!";
                                    if ($_GET['msg'] === 'item_atualizado') echo "✏️ Item alterado com sucesso!";
                                    if ($_GET['msg'] === 'item_removido') echo "🗑️ Item removido do cardápio!";
                                    if ($_GET['msg'] === 'cardapio_restaurado') echo "🔄 Cardápio restaurado para o padrão original!";
                                ?>
                            </span>
                            <a href="index.php?page=admin" class="text-white hover:underline">OK</a>
                        </div>
                    <?php endif; ?>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-doce-mint-deep text-white p-6 rounded-3xl border-4 border-doce-mint-dark shadow-xl mb-10 gap-4">
                        <div>
                            <span class="text-doce-gold font-semibold text-xs uppercase tracking-widest flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved"></i> PAINEL ADMINISTRATIVO
                            </span>
                            <h1 class="font-serif text-3xl font-bold mt-1">Gerenciador do Cardápio</h1>
                            <p class="text-xs text-doce-mint-light/80 mt-1">Adicione, altere ou remova itens do cardápio em tempo real.</p>
                        </div>
                        <div>
                            <a href="index.php?page=admin&action=restaurar_cardapio" onclick="return confirm('Tem certeza que deseja restaurar o cardápio padrão?');" class="bg-doce-pink-base hover:bg-doce-pink-dark text-doce-text hover:text-white text-xs font-semibold px-4 py-2.5 rounded-full shadow transition inline-block">
                                <i class="fa-solid fa-rotate-left mr-1"></i> Restaurar Cardápio Padrão
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        
                        <!-- FORMULÁRIO DE CADASTRO OU EDIÇÃO DE ITEM -->
                        <div class="lg:col-span-5 bg-white p-6 sm:p-8 rounded-3xl border-2 border-doce-mint-base/40 shadow-lg h-fit">
                            <div class="flex items-center justify-between border-b pb-3 mb-6">
                                <h3 class="font-serif text-xl font-bold text-doce-text flex items-center gap-2">
                                    <i class="fa-solid <?php echo $item_edicao ? 'fa-pen-to-square text-doce-gold' : 'fa-square-plus text-doce-pink-dark'; ?>"></i> 
                                    <?php echo $item_edicao ? 'Alterar Item' : 'Cadastrar Novo Item'; ?>
                                </h3>
                                <?php if ($item_edicao): ?>
                                    <a href="index.php?page=admin" class="text-[10px] uppercase font-bold text-gray-400 hover:text-red-500">Cancelar Edição</a>
                                <?php endif; ?>
                            </div>

                            <form action="index.php?page=admin" method="POST" class="space-y-4 text-xs">
                                <input type="hidden" name="action" value="salvar_item">
                                <?php if ($item_edicao): ?>
                                    <input type="hidden" name="id" value="<?php echo $item_edicao['id']; ?>">
                                <?php endif; ?>

                                <div>
                                    <label class="block font-semibold text-doce-text mb-1">Nome do Item *</label>
                                    <input type="text" name="nome" required value="<?php echo $item_edicao ? htmlspecialchars($item_edicao['nome']) : ''; ?>" placeholder="Ex: Torta de Pistache" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-doce-mint-base outline-none">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block font-semibold text-doce-text mb-1">Preço (R$) *</label>
                                        <input type="number" step="0.01" name="preco" required value="<?php echo $item_edicao ? $item_edicao['preco'] : ''; ?>" placeholder="18.50" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-doce-mint-base outline-none">
                                    </div>
                                    <div>
                                        <label class="block font-semibold text-doce-text mb-1">Categoria *</label>
                                        <select name="categoria" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 outline-none bg-white">
                                            <option value="cafes" <?php echo ($item_edicao && $item_edicao['categoria'] === 'cafes') ? 'selected' : ''; ?>>Cafés</option>
                                            <option value="doces" <?php echo ($item_edicao && $item_edicao['categoria'] === 'doces') ? 'selected' : ''; ?>>Doces</option>
                                            <option value="salgados" <?php echo ($item_edicao && $item_edicao['categoria'] === 'salgados') ? 'selected' : ''; ?>>Salgados</option>
                                            <option value="bebidas" <?php echo ($item_edicao && $item_edicao['categoria'] === 'bebidas') ? 'selected' : ''; ?>>Bebidas</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-semibold text-doce-text mb-1">Tag / Selo Especial *</label>
                                    <input type="text" name="tag" required value="<?php echo $item_edicao ? htmlspecialchars($item_edicao['tag']) : ''; ?>" placeholder="Ex: Mais Pedido, Artesanal" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-doce-mint-base outline-none">
                                </div>

                                <div>
                                    <label class="block font-semibold text-doce-text mb-1">Nome do Ficheiro da Imagem</label>
                                    <input type="text" name="imagem" value="<?php echo $item_edicao ? htmlspecialchars($item_edicao['imagem']) : ''; ?>" placeholder="Ex: expresso.jpg.png ou foto.png" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-doce-mint-base outline-none">
                                </div>

                                <div>
                                    <label class="block font-semibold text-doce-text mb-1">Descrição Delicada *</label>
                                    <textarea name="descricao" rows="3" required placeholder="Descreva os ingredientes..." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-doce-mint-base outline-none"><?php echo $item_edicao ? htmlspecialchars($item_edicao['descricao']) : ''; ?></textarea>
                                </div>

                                <button type="submit" class="w-full bg-doce-mint-base hover:bg-doce-mint-dark text-white font-bold py-3 rounded-xl transition shadow uppercase tracking-wider text-xs flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i> <?php echo $item_edicao ? 'Atualizar Item' : 'Salvar no Cardápio'; ?>
                                </button>
                            </form>
                        </div>

                        <div class="lg:col-span-7 space-y-8">
                            
                            <!-- CONTROLE DE STATUS DO PEDIDO -->
                            <div class="bg-doce-cream p-6 rounded-3xl border-4 border-doce-mint-base shadow-md">
                                <h3 class="font-serif text-lg font-bold text-doce-text border-b pb-2 mb-4">
                                    <i class="fa-solid fa-sliders text-doce-pink-dark mr-1"></i> Controle do Status do Pedido Cliente
                                </h3>

                                <form action="index.php?page=admin" method="POST" class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs font-semibold">
                                    <input type="hidden" name="action" value="mudar_status">
                                    <button type="submit" name="novo_status" value="1" class="py-2.5 px-2 rounded-xl transition text-center border <?php echo $current_status === 1 ? 'bg-doce-mint-deep text-white font-bold border-2 border-doce-gold shadow' : 'bg-white text-doce-text border-gray-200 hover:bg-doce-mint-light'; ?>">
                                        1. Recebido
                                    </button>
                                    <button type="submit" name="novo_status" value="2" class="py-2.5 px-2 rounded-xl transition text-center border <?php echo $current_status === 2 ? 'bg-doce-mint-deep text-white font-bold border-2 border-doce-gold shadow' : 'bg-white text-doce-text border-gray-200 hover:bg-doce-mint-light'; ?>">
                                        2. Em Preparo
                                    </button>
                                    <button type="submit" name="novo_status" value="3" class="py-2.5 px-2 rounded-xl transition text-center border <?php echo $current_status === 3 ? 'bg-doce-mint-deep text-white font-bold border-2 border-doce-gold shadow' : 'bg-white text-doce-text border-gray-200 hover:bg-doce-mint-light'; ?>">
                                        3. A Caminho
                                    </button>
                                    <button type="submit" name="novo_status" value="4" class="py-2.5 px-2 rounded-xl transition text-center border <?php echo $current_status === 4 ? 'bg-doce-mint-deep text-white font-bold border-2 border-doce-gold shadow' : 'bg-white text-doce-text border-gray-200 hover:bg-doce-mint-light'; ?>">
                                        4. Entregue
                                    </button>
                                </form>
                            </div>

                            <!-- TABELA DE TODOS OS ITENS CADASTRAIS DA LISTA -->
                            <div class="bg-white p-6 rounded-3xl border-2 border-doce-mint-base/40 shadow-lg">
                                <h3 class="font-serif text-xl font-bold text-doce-text mb-4 flex items-center justify-between">
                                    <span><i class="fa-solid fa-list-check text-doce-mint-dark mr-1"></i> Lista de Todos os Itens</span>
                                    <span class="text-xs bg-doce-pink-light text-doce-pink-dark font-sans px-3 py-1 rounded-full border border-doce-pink-base font-bold"><?php echo count($cardapio_items); ?> itens no total</span>
                                </h3>

                                <?php if (empty($cardapio_items)): ?>
                                    <p class="text-xs text-gray-500 text-center py-4">Nenhum item na lista.</p>
                                <?php else: ?>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left border-collapse text-xs">
                                            <thead>
                                                <tr class="bg-doce-mint-light text-doce-mint-deep font-bold border-b border-doce-mint-base/30">
                                                    <th class="p-3">Item</th>
                                                    <th class="p-3">Categoria</th>
                                                    <th class="p-3">Preço</th>
                                                    <th class="p-3 text-center">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-100">
                                                <?php foreach ($cardapio_items as $item): ?>
                                                    <tr class="hover:bg-doce-pink-light/50 transition">
                                                        <td class="p-3 font-semibold text-doce-text flex items-center gap-2">
                                                            <img src="<?php echo htmlspecialchars($item['imagem']); ?>" class="w-8 h-8 rounded object-cover">
                                                            <span><?php echo htmlspecialchars($item['nome']); ?></span>
                                                        </td>
                                                        <td class="p-3 uppercase text-[10px] text-doce-mint-dark font-bold"><?php echo htmlspecialchars($item['categoria']); ?></td>
                                                        <td class="p-3 font-serif font-bold text-doce-text">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                                        <td class="p-3 text-center space-x-1">
                                                            <!-- BOTÃO EDITAR -->
                                                            <a href="index.php?page=admin&edit_id=<?php echo $item['id']; ?>" class="bg-doce-mint-light hover:bg-doce-mint-base text-doce-mint-deep hover:text-white px-2.5 py-1 rounded.md text-[11px] font-bold transition inline-block">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <!-- BOTÃO REMOVER -->
                                                            <a href="index.php?page=admin&action=remover_item&id=<?php echo $item['id']; ?>" onclick="return confirm('Deseja remover <?php echo htmlspecialchars($item['nome']); ?>?');" class="bg-red-50 hover:bg-red-100 text-red-500 px-2.5 py-1 rounded-md text-[11px] font-bold transition inline-block">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>

                    </div>

                </div>
            </section>

            <?php elseif ($page === 'sobre'): ?>
            <section class="py-12 text-center">
                <h1 class="font-serif text-3xl font-bold text-doce-text">Sobre a Lanchonete Doce Encontro</h1>
            </section>

            <?php elseif ($page === 'contato'): ?>
            <section class="py-12 text-center">
                <h1 class="font-serif text-3xl font-bold text-doce-text">Contato & Reservas</h1>
            </section>

            <?php endif; ?>

        </div>
    </div>

    <!-- MODAL DE PIN DO ADMIN -->
    <div id="admin-pin-modal" class="modal-target fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-doce-cream border-4 border-doce-mint-base rounded-3xl p-6 sm:p-8 max-w-sm w-full shadow-2xl relative text-center">
            <a href="index.php?page=home" class="absolute top-3 right-4 text-gray-400 hover:text-doce-text text-xl">
                <i class="fa-solid fa-xmark"></i>
            </a>

            <div class="w-16 h-16 rounded-full bg-doce-pink-base text-doce-pink-dark flex items-center justify-center text-2xl mx-auto mb-3 shadow-md">
                <i class="fa-solid fa-lock"></i>
            </div>

            <h3 class="font-serif text-2xl font-bold text-doce-text">Acesso Gerencial</h3>
            <p class="text-xs text-doce-text/70 mt-1 mb-4">Clique abaixo para acessar o painel:</p>

            <form action="index.php" method="GET" class="space-y-4">
                <input type="hidden" name="page" value="admin">
                <button type="submit" class="w-full bg-doce-mint-base hover:bg-doce-mint-dark text-white font-bold py-3 rounded-xl transition shadow text-xs uppercase tracking-wider block text-center">
                    Entrar no Painel
                </button>
            </form>
        </div>
    </div>

    <footer class="bg-doce-mint-base text-white py-8 border-t-4 border-doce-mint-dark mt-16 text-center">
        <p class="text-xs">&copy; 2026 Lanchonete Doce Encontro - Todos os direitos reservados.</p>
    </footer>

</body>
</html>