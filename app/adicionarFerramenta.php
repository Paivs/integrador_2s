<?php

    require_once __DIR__ . "/init.php";

    $bancadas = readAll($pdo, "Bancadas");

    if (isset($_SESSION['id'])) {
            $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
            if($userAtual['perfil'] != "admin" || !isset($userAtual)){
                header("Location: index.php");
                exit;
            }
        }else{
            header("Location: index.php");
            exit;
        };


    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $erros = [];

        $dadosFerramentas = [
            'nome_ferramenta' => trim($_POST['nomeFerramenta'] ?? ''),
            'area' => trim($_POST['area'] ?? ''),
            'estoque' => trim($_POST['valorEstoque'] ?? ''),
            'id_bancada' => (int)($_POST['bancada'] ?? 0)
        ];

        if ($dadosFerramentas['nome_ferramenta'] == '') {
            $erros['nome'] = 'O campo nome da ferramenta é obrigatório, tente novamente.';
        } elseif (strlen($dadosFerramentas['nome_ferramenta']) > 100) {
            $erros['nome'] = 'O campo nome da ferramenta deve ter no máximo 100 caracteres, tente novamente.';
        } elseif (read($pdo, 'Ferramentas', 'nome_ferramenta = ?', [$dadosFerramentas['nome_ferramenta']]) !== false) {
            $erros['nome'] = 'O nome da ferramenta já está sendo utilizado, por favor escolha outro.';
        }

        // --------------------------------------------------

        if ($dadosFerramentas['area'] == '') {
            $erros['area'] = 'O campo de área é obrigatório, tente novamente.';
        } elseif (strlen($dadosFerramentas['area']) < 5 || strlen($dadosFerramentas['area']) > 50) {
            $erros['area'] = 'O campo de área deve ser preenchido com no mínimo 5 caracteres e máximo 50 caracteres, tente novamente.';
        }

        // ---------------------------------------------------

        if ($dadosFerramentas['estoque'] == '') {
            $erros['estoque'] = 'O campo estoque é obrigatório, tente novamente.';
        } elseif ($dadosFerramentas['estoque'] < 0 || $dadosFerramentas['estoque'] > 20000) {
            $erros['estoque'] = 'O campo quantidade deve ser preenchido com valores reais, tente novamente.';
        }

        // ----------------------------------------------------

        if (read($pdo, 'Ferramentas', 'id_bancada = ?', [$dadosFerramentas['id_bancada']]) == false || $dadosFerramentas['id_bancada'] == '') {
            $erros['bancada'] = 'A bancada selecionada não existe, tente novamente.';
        }

        // ----------------------------------------------------

        if ($erros === []) {
            create($pdo, 'Ferramentas', [
                'nome_ferramenta' => $dadosFerramentas['nome_ferramenta'],
                'area' => $dadosFerramentas['area'],
                'estoque' => (int) $dadosFerramentas['estoque'],
                'id_bancada' => $dadosFerramentas['id_bancada'],
            ]);

            header('Location: dashboard.php?');
            exit;
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MakerLab - Adicionar Ferramenta</title>
        <link rel="stylesheet" href="css/navAdm.css">
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>
        <header>
            <nav class="sidebar">
                <div class="sidebar-content">
                    
                    <div class="logo">
                        <a href="index.php"><img src="img/cabecalho/logo.png" alt=""></a>
                    </div>
                    
                    <a href="./dashboard.php" class="item">
                        <img src="./img/icons/pen_branco.png" alt="" class="icone">
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="./adicionarFerramenta.php" class="item ativo">
                        <img src="./img/icons/plus_roxo.png" alt="" class="icone">
                        <span>Ferramenta</span>
                    </a>
                    
                    <a href="./adicionarBancada.php" class="item">
                        <img src="./img/icons/plus_branco.png" alt="" class="icone">
                        <span>Bancada</span>
                    </a>
                    
                    <a href="./historicoReservas.php" class="item">
                        <img src="./img/icons/folder_branco.png" alt="" class="icone">
                        <span>Reservas</span>
                    </a>
                </div>
            </nav>
        </header>
        <main class="conteudo pagina-formulario">

            <h1 class="titulo-formulario">Adicionar Ferramenta</h1>

            <?php if (!empty($erros)): ?>
                <div class="erros">
                    <p>Corrija os campos abaixo:</p>
                    <ul>
                        <?php foreach ($erros as $mensagem): ?>
                            <li><?= ($mensagem) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="formulario" action="" method="POST">

                <div class="coluna">
                    <label class="rotulo" for="nomeFerramenta">Nome da ferramenta:</label>
                    <input class="campo" type="text" name="nomeFerramenta" id="nomeFerramenta" required>

                    <label class="rotulo" for="area">Escreva a área da bancada:</label>
                    <input class="campo" type="text" name="area" id="area" required>
                </div>

                <div class="coluna">
                    <label class="rotulo" for="valorEstoque">Quantos temos em estoque?:</label>
                    <input class="campo campo-numero" type="number" name="valorEstoque" id="valorEstoque" step="1" required>

                    <label class="rotulo" for="bancada">De qual bancada ela pertence?</label>
                    <select class="campo campo-select" name="bancada" id="bancada" required>
                        <option value="">-- Escolha uma bancada --</option>
                        <?php foreach ($bancadas as $b): ?>
                            <option value="<?= $b['id_bancada'] ?>"><?= htmlspecialchars($b['nome_bancada']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button class="botao-registrar" type="submit">Registrar</button>
                </div>

            </form>
        </main>
    </body>
</html>