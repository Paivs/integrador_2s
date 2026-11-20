<?php

require_once __DIR__ . "/init.php";

if (!isset($_SESSION['id_usuario'])) {
    $_SESSION['voltar_para'] = 'cadastraObj.php';
    header('Location: login.php');
    exit;
}

$categorias = [
    'acessorios'      => 'Acessórios',
    'bolsas_mochilas' => 'Bolsas e Mochilas',
    'documentos'      => 'Documentos',
    'eletronicos'     => 'Eletrônicos',
    'roupas'          => 'Roupas',
    'outros'          => 'Outros',
];

$statusPermitidos = [
    'perdido'    => 'Perdido',
    'encontrado' => 'Encontrado',
];

$emojisPermitidos = [
    '🍫',
    '🥤',
    '⌚',
    '🌂',
    '⚽',
    '🛼',
    '🎮',
    '🧸',
    '👓',
    '🧥',
    '🧢',
    '👜',
    '💄',
    '💍',
    '🎧',
    '📱',
    '💻',
    '📷',
    '📚',
    '📓',
    '💳',
    '🖊️',
    '🔑',
    '🔨',
];

// Conta caracteres sem depender da extensão mbstring
function tamanho(string $texto): int
{
    return preg_match_all('/./us', $texto);
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome      = trim($_POST['nome'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $local     = trim($_POST['local'] ?? '');
    $categoria = $_POST['categoria'] ?? '';
    $status    = $_POST['status'] ?? '';
    $emoji     = $_POST['emoji_escolhido'] ?? '';

    if ($nome === '' || $descricao === '' || $local === '') {
        $erro = 'Preencha o nome, a descrição e o local do objeto.';
    } elseif (tamanho($nome) > 100 || tamanho($descricao) > 255 || tamanho($local) > 150) {
        $erro = 'Algum campo ultrapassou o tamanho máximo permitido.';
    } elseif (!isset($categorias[$categoria])) {
        $erro = 'Selecione uma categoria válida.';
    } elseif (!isset($statusPermitidos[$status])) {
        $erro = 'Selecione um status válido.';
    } elseif (!in_array($emoji, $emojisPermitidos, true)) {
        $erro = 'Selecione um ícone para o objeto.';
    } else {
        try {
            create($pdo, 'objetos', [
                'nomeUsuario'     => (int) ($_SESSION['id_usuario']),
                'nome'            => $nome,
                'descricao'       => $descricao,
                'localEncontrado' => $local,
                'categoria'       => $categorias[$categoria],
                'imagemObjeto'    => $emoji,
                'status_objeto'   => $statusPermitidos[$status],
            ]);

            header('Location: painelObjetos.php');
            exit;
        } catch (PDOException $e) {
            error_log('Erro ao cadastrar objeto: ' . $e->getMessage());
            $erro = 'Não foi possível cadastrar o objeto. Tente novamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Item</title>
    <link rel="stylesheet" href="css/cadastraObj.css">
    <link rel="icon" type="image/png" href="./imagens/finditDesenho.png">
</head>

<body>

    <!-- menu -->
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

    <div class="lado-direito">
        <h2>Para realizar o cadastro de um novo objeto são necessárias as seguintes etapas:</h2>

        <?php if ($erro !== ''): ?>
            <p class="erro" style="color:#c0392b;font-weight:bold;"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="formulario">
            <div class="cadastro">
                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">1.</p>
                        <label for="nome">
                            <p>Nome do objeto:</p>
                        </label>
                    </div>

                    <input class="resposta" type="text" id="nome" name="nome" required>
                

               
                    <div class="linha-titulo">
                        <p class="ordem">2.</p>
                        <label for="descricao">
                            <p>Descrição do objeto:</p>
                        </label>
                    </div>

                    <input class="resposta" type="text" id="descricao" name="descricao" required>
                

                
                    <div class="linha-titulo">
                        <p class="ordem">3.</p>
                        <label for="local">
                            <p>Local onde foi perdido ou encontrado:</p>
                        </label>
                    </div>

                    <input class="resposta" type="text" id="local" name="local" required>
                

                
                    <div class="linha-titulo">
                        <p class="ordem">4.</p>
                        <label for="categoria">
                            <p>Categoria</p>
                        </label>

                        <select name="categoria" id="categoria" required>

                            <option value="" disabled selected>Selecione...</option>
                            <option value="acessorios">Acessórios</option>
                            <option value="bolsas_mochilas">Bolsas e Mochilas</option>
                            <option value="documentos">Documentos</option>
                            <option value="eletronicos">Eletrônicos</option>
                            <option value="roupas">Roupas</option>
                            <option value="outros">Outros</option>
                        </select>
                    </div>
                
                    <div class="linha-titulo">
                        <p class="ordem">5.</p>
                        <label for="status">
                            <p>Status atual:</p>
                        </label>
                        <select name="status" id="status">
                            <option value="perdido">Perdido</option>
                            <option value="encontrado">Encontrado</option>
                        </select>
                    </div>
                </div>

                <div class="grupo-campo">
                    <div class="linha-titulo">
                        <p class="ordem">6.</p>
                        <p>Selecione o ícone do objeto:</p>
                    </div>

                    <div class="">

                        <div class="circulos-container">
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🍫" required>🍫</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🥤">🥤</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="⌚">⌚</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🌂">🌂</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="⚽">⚽</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🛼">🛼</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🎮">🎮</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧸">🧸</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="👓">👓</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧥">🧥</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🧢">🧢</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="👜">👜</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="💄">💄</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="💍">💍</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🎧">🎧</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="📱">📱</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="💻">💻</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="📷">📷</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="📚">📚</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="📓">📓</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="💳">💳</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🖊️">🖊️</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🔑">🔑</label>
                            <label class="circulo"><input type="radio" name="emoji_escolhido" value="🔨">🔨</label>
                        </div>
                        <button class="botao" type="submit">Cadastrar</button>
                    </div>
                    </div>
                    
            

            </div>
        </form>
    </div>

    <div class="prateleira">
        <img src="imagens/prateleira.jpg" alt="prateleira com objetos guardados">
    </div>
</body>

</html>