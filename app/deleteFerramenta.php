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

    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
        $ferramentaSelecionada = readAll($pdo, "Ferramentas", "id_ferramenta = {$_GET['id']}");
        $idFerramenta = $_GET['id'];

        if ($ferramentaSelecionada == false) {
            print("<p>Ferramenta não reconhecida</p>");
            exit;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $idFerramenta = $_POST['idFerramenta'];
        // Zera o estoque: o dashboard mostra "Sem estoque" para ela
        update(database(), "Ferramentas", ["status_ferramenta" => 'indisponivel'], "id_ferramenta={$idFerramenta}");
        header("Location: dashboard.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Deletar Ferramenta</title>
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

        <h1 class="titulo-formulario">Deletar Ferramenta</h1>

        <?php foreach($ferramentaSelecionada as $campoDaFerramenta): ?>

            <form class="formulario" action="" method="POST">
                <input type="hidden" name="idFerramenta" value="<?= $idFerramenta ?>">

                <div class="coluna">
                    <label class="rotulo" for="nomeFerramenta">Nome da ferramenta:</label>
                    <input class="campo" type="text" name="nomeFerramenta" id="nomeFerramenta" value="<?= $campoDaFerramenta['nome_ferramenta'] ?>" readonly>

                    <label class="rotulo" for="area">Escreva a área da bancada:</label>
                    <input class="campo" type="text" name="area" id="area" value="<?= $campoDaFerramenta['area'] ?>" readonly>
                </div>

                <div class="coluna">
                    <label class="rotulo" for="valorEstoque">Quantos temos em estoque?:</label>
                    <input class="campo campo-numero" type="number" name="valorEstoque" id="valorEstoque" step="1" value="<?= $campoDaFerramenta['estoque'] ?>" readonly>

                    <label class="rotulo" for="bancada">De qual bancada ela pertence?</label>
                    <select class="campo campo-select" name="bancada" id="bancada" disabled>
                        <?php foreach ($bancadas as $b): ?>
                            <option value="<?= $b['id_bancada'] ?>"
                                <?= $campoDaFerramenta['id_bancada'] == $b['id_bancada'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($b['nome_bancada']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button class="botao-registrar botao-deletar" type="submit">Deletar</button>
                </div>

            </form>

        <?php endforeach; ?>
    </main>
</body>
</html>
