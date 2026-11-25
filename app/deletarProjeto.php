<?php   
    require_once __DIR__ . "/init.php";

    if (isset($_SESSION['id'])) {
        $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
        if (!isset($userAtual) || $userAtual == null) {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }

    $projetoAtual = [];
    
    if (!isset($_GET['id']) || $_GET['id'] == null) {
        print("<p>Projeto não reconhecido</p>");
    }

    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
        $idProjeto = $_GET['id'];  
        $projetoAtual = read(database(), "Projetos", "id_projeto = ? AND id_criador = ?", [$idProjeto, $_SESSION['id']]);
        if ($projetoAtual == null) {
            print("<p>Projeto não reconhecido</p>");
            exit;
        }
    }  

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {
        $idProjeto = $_POST['id'];  
        update(database(), "Projetos", [
            "nome_projeto"      => "",
            "descricao_projeto" => "",
            "imagem_projeto"    => ""
        ], "id_projeto = ? AND id_criador = ?", [$idProjeto, $_SESSION['id']]);
        header("Location: perfil.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Deletar Projeto</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php require_once __DIR__ . '/nav.php'; ?>

    <main class="conteudo pagina-formulario">

        <h1 class="titulo-formulario">Deletar Projeto</h1>

        <form class="formulario" action="" method="POST">
            <input type="hidden" name="id" value="<?= $idProjeto ?>">

            <div class="coluna">
                <label class="rotulo">Nome do projeto:</label>
                <input class="campo" value="<?= $projetoAtual['nome_projeto'] ?>" readonly>

                <label class="rotulo">Link da imagem:</label>
                <input class="campo campo-imagem" value="<?= $projetoAtual['imagem_projeto'] ?>" readonly>
            </div>

            <div class="coluna">
                <label class="rotulo">Descrição:</label>
                <textarea class="campo campo-descricao" readonly><?= $projetoAtual['descricao_projeto'] ?></textarea>

                <button class="botao-registrar botao-deletar" type="submit">Deletar Projeto</button>
            </div>

        </form>
    </main>  
</body>
</html>