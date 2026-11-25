<?php

    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/banco/crud.php';

    if (empty($_SESSION['id'])) {
        header("Location: loginUsuario.php");
        exit;
    }

    $pdo = database();
    $projetoSelecionado = [];

    if (!isset($_GET['id']) || $_GET['id'] == null) {
        print("<p>Projeto não reconhecido</p>");
        exit;
    }

    $idProjeto = $_GET['id'];
    $projetoSelecionado = readAll(
        $pdo,
        "Projetos",
        "id_projeto = ? AND id_criador = ?",
        [$idProjeto, $_SESSION['id']]
    );

    if ($projetoSelecionado == null) {
        print("<p>Projeto não reconhecido ou você não tem permissão para editá-lo.</p>");
        exit;
    }

    $erros = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $dados = [
            'nomeProjeto' => trim($_POST['nomeProjeto'] ?? ''),
            'descricao'   => trim($_POST['descricao'] ?? ''),
            'imagem'      => trim($_POST['imagem'] ?? ''),
        ];

        // -------------- Validação dos dados (após limpar eles) -----------------

        if ($dados['nomeProjeto'] == '') {
            $erros['nome'] = 'O campo nome do projeto é obrigatório, tente novamente.';
        } elseif (strlen($dados['nomeProjeto']) > 100) {
            $erros['nome'] = 'O campo nome do projeto deve ter no máximo 100 caracteres, tente novamente.';
        } elseif (!empty(read($pdo, 'Projetos', 'nome_projeto = ? AND id_projeto <> ?', [$dados['nomeProjeto'], $idProjeto]))) {
            $erros['nome'] = 'O nome do projeto já está sendo utilizado, por favor escolha outro.';
        }

        // -----------------------------------------------------

        if ($dados['descricao'] == '') {
            $erros['descricao'] = 'O campo descrição é obrigatório, tente novamente.';
        } elseif (strlen($dados['descricao']) > 300) {
            $erros['descricao'] = 'O campo descrição deve ter no máximo 300 caracteres, tente novamente.';
        }

        // -----------------------------------------------------

        if ($dados['imagem'] !== '') {
            if (filter_var($dados['imagem'], FILTER_VALIDATE_URL) === false) {
                $erros['imagem'] = 'O campo de imagem precisa ser um link válido.';
            } elseif (strlen($dados['imagem']) > 255) {
                $erros['imagem'] = 'O link da imagem deve ter no máximo 255 caracteres.';
            }
        }

        // -----------------------------------------------------

        if ($erros === []) {
            update($pdo, 'Projetos', [
                'nome_projeto'      => $dados['nomeProjeto'],
                'descricao_projeto' => $dados['descricao'],
                'imagem_projeto'    => $dados['imagem']
            ], "id_projeto = ? AND id_criador = ?", [$idProjeto, $_SESSION['id']]);

            header('Location: perfil.php');
            exit;
        }

        $projetoSelecionado[0]['nome_projeto']      = $dados['nomeProjeto'];
        $projetoSelecionado[0]['descricao_projeto'] = $dados['descricao'];
        $projetoSelecionado[0]['imagem_projeto']    = $dados['imagem'];
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Editar Projeto</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <?php require_once __DIR__ . '/nav.php'; ?>
    <br><br><br>

    <main class="conteudo pagina-formulario" style="margin-left: auto; margin-right: auto;">

        <h1 class="titulo-formulario">Editar Projeto</h1>

        <?php if (!empty($erros)): ?>
            <div class="erros" style="background: #ffdddd; color: #900; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                <p>Corrija os campos abaixo:</p>
                <ul>
                    <?php foreach ($erros as $mensagem): ?>
                        <li><?= $mensagem ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php foreach ($projetoSelecionado as $projeto): ?>

            <form class="formulario" action="editarProjeto.php?id=<?= urlencode($idProjeto) ?>" method="POST">

                <div class="coluna">
                    <label class="rotulo" for="nomeProjeto">Nome do projeto:</label>
                    <input class="campo" type="text" name="nomeProjeto" id="nomeProjeto" value="<?= $projeto['nome_projeto'] ?>" required>

                    <label class="rotulo" for="imagem">Cole o link da imagem:</label>
                    <input class="campo campo-imagem" type="text" name="imagem" id="imagem" value="<?= $projeto['imagem_projeto'] ?>">
                </div>

                <div class="coluna">
                    <label class="rotulo" for="descricao">Escreva uma descrição do projeto:</label>
                    <textarea class="campo campo-descricao" name="descricao" id="descricao" required><?= $projeto['descricao_projeto'] ?></textarea>

                    <button class="botao-registrar" type="submit">Salvar alterações</button>
                </div>

            </form>

        <?php endforeach; ?>
    </main>
</body>
</html>