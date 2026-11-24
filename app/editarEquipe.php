<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $privacidade = trim($_POST['privacidade']);
    $jogo = trim($_POST['jogo']);

    $equipe = read($pdo, "equipes", "id = ?", [$id]);

    if (!$equipe) {
        header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
        exit;
    }

    if ($nome == "" || ($nome) > 100) {
        header("Location: administracao.php?erro=NOME_INVALIDO");
        exit;
    }

    if ($descricao == "" || ($descricao) > 100) {
        header("Location: administracao.php?erro=DESCRICAO_INVALIDA");
        exit;
    }

    if ($privacidade == "" || ($privacidade) > 100) {
        header("Location: administracao.php?erro=PRIVACIDADE_INVALIDA");
        exit;
    }

    update($pdo, "equipes", [
        "nome" => $nome,
        "descricao" => $descricao,
        "privacidade" => $privacidade,
        "jogo_equipe" => $jogo
    ], "id = ?", [$id]);

    header("Location: administracao.php");
    exit;
}

if (
    $_SERVER['REQUEST_METHOD'] == "GET" &&
    isset($_GET['id']) &&
    $_GET['id'] != ""
) {
    $id = $_GET['id'];
    $equipe = read($pdo, "equipes", "id = ?", [$id]);
}

if (!isset($equipe) || !$equipe) {
    header("Location: administracao.php?erro=ID_NAO_ENCONTRADO");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Editar Equipe</title>
</head>

<body>

    <?php require_once __DIR__ . "/cabecalho.php" ?>

    <form action="" method="POST">

        <label for="nome">Nome:</label>
        <input type="hidden" name="id" id="id" value="<?= htmlspecialchars((string) $id) ?>" >
        <input type="text" name="nome" id="nome" maxlength="100" required value="<?= htmlspecialchars($equipe['nome']) ?>">
        <br>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" maxlength="100" required value="<?= htmlspecialchars($equipe['descricao']) ?>" >
        <br>

        <select name="privacidade" id="privacidade" class="privacidade">
            <option value="<?= $equipe['privacidade'] ?>" hidden><?= $equipe['privacidade'] ?></option>
            <option value="publica">pública</option>
            <option value="privada">privada</option>
        </select>
        <br>

        <select name="jogo" id="jogo" required>
            <option value="<?= $equipe['jogo_equipe'] ?>" hidden><?= $equipe['jogo_equipe'] ?></option>
            <option value="Counter-Strike 2">Counter-Strike 2</option>
            <option value="Valorant">Valorant</option>
            <option value="Rocket League">Rocket League</option> 
            <option value="EA FC">EA FC</option> 
            <option value="Fortnite">Fortnite</option> 
            <option value="Tom Clancy's Rainbow Six Siege">Tom Clancy's Rainbow Six Siege</option> 
            <option value="League of Legends">League of Legends</option> 
        </select>

        <button type="submit">Alterar</button>
    </form>
</body>
</html>
