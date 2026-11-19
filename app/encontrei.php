<?php

require_once __DIR__ . "/init.php";

$id = (int) ($_GET['idObjeto'] ?? 0);

$objeto = read($pdo, 'objetos', 'idObjeto = ?', [$id]);

$pontos = readAll($pdo, 'pontoColeta');

if (!$objeto || $objeto['status_objeto'] !== 'Perdido') {
    header('Location: painelObjetos.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = trim($_POST['estadoObjeto'] ?? '');
    $local  = trim($_POST['localEncontrado'] ?? '');
    $idPonto = (int) ($_POST['idPontoColeta'] ?? 0);

    $ponto   = read($pdo, 'pontoColeta', 'idEndereco = ?', [$idPonto]);

    if ($estado === '' || $local === '' || !$ponto) {
        $erro = 'Preencha o estado e o local.';
    } else {
        create($pdo, 'achado', [
            'idObjeto'        => $id,
            'idUsuarioAchou'  => (int) $_SESSION['id_usuario'],
            'estadoObjeto'    => $estado,
            'localEncontrado' => $local,
            'idPontoColeta'   => $idPonto,
        ]);

        update($pdo, 'objetos', ['status_objeto' => 'Encontrado'], 'idObjeto = ?', [$id]);

        header('Location: painelObjetos.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontrou objeto</title>

    <link rel="stylesheet" href="./css/style-encontrei.css">
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

        <?php if ($erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <h1>Você encontrou este objeto?</h1>

        <div class="tabela">
            <div class="objeto">
                <div class="emoji">
                    <p><?= htmlspecialchars($objeto['imagemObjeto']) ?></p>
                </div>

                <div class="conteudo">
                    <p>Nome: <?= htmlspecialchars($objeto['nome']) ?></p>
                    <p>Descrição: <?= htmlspecialchars($objeto['descricao']) ?></p>
                    <p>Categoria: <?= htmlspecialchars($objeto['categoria']) ?></p>
                    <p>Perdido em: <?= htmlspecialchars($objeto['localEncontrado']) ?></p>
                </div>
            </div>

            <form action="" method="post">

                <label for="estadoObjeto">Qual era o estado do objeto:</label>
                <select name="estadoObjeto" id="estadoObjeto" required>
                    <option value="">Selecione</option>
                    <option value="Perfeito">Perfeito</option>
                    <option value="Com marcas de uso">Com marcas de uso</option>
                    <option value="Danificado">Danificado</option>
                </select>


                <label for="idPontoColeta">Onde você vai entregar o objeto?</label>
                <select name="idPontoColeta" id="idPontoColeta" required>
                    <option value="">Selecione</option>
                    <?php foreach ($pontos as $p): ?>
                        <option value="<?= (int) $p['idEndereco'] ?>">
                            <?= htmlspecialchars($p['nome']) ?> - <?= htmlspecialchars($p['logradouro']) ?>, <?= (int) $p['numero'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="localEncontrado">Onde você o achou?</label>
                <input type="text" id="localEncontrado" name="localEncontrado" required>

                <div class="botoes">
                    <button type="submit">Enviar</button>
                    <a href="./FormContato.php">Não é este</a>
                </div>
            </form>
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
</body>

</html>