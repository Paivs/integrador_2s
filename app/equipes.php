<?php

require_once __DIR__ . "/init.php";

$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_SPECIAL_CHARS);
    if($busca == "cs" || $busca == "cs2" || $busca == "CS" || $busca == "CS2"){
        $busca = "Counter-Strike 2";
    }

if (!empty($busca)) {
    $sql = "SELECT * FROM equipes WHERE nome LIKE ? OR jogo_equipe LIKE ? ORDER BY jogo_equipe ASC";
    $stmt = $pdo->prepare($sql);

    $termo = '%' . $busca . '%';
    $stmt->execute([$termo, $termo]);

    $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $sql = "SELECT * FROM equipes ORDER BY jogo_equipe ASC";
    $equipes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipes</title>
    <link rel="stylesheet" href="/app/css/equipes.css">
</head>

<body>
    <?php require_once __DIR__ . "/cabecalho.php" ?>

    <section class="fundo-equipes">

        <div class="funcao">

            <form action="" method="get" class="barra-pesquisa">
                <input type="text" name="busca" value="<?= htmlspecialchars($busca ?? '') ?>" placeholder="Buscar equipe:" required class="pesquisar">
                <button type="submit" class="enviar">Buscar</button>

                <?php if (!empty($busca)): ?>
                    <a href="?" class="limpar-filtro">Limpar</a>
                <?php endif; ?>
            </form>

            <a href=""><i>CRIAR <span>EQUIPE</span></i></a>
        </div>

        <div class="conteudo-equipes">
            <table class="tabela-equipes">
                <thead>
                    <tr>
                        <th>Jogo</th>
                        <th>Escudo</th>
                        <th>Nome</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($equipes)): ?>
                        <?php foreach ($equipes as $e): ?>
                            <tr>
                                <td><?= htmlspecialchars($e['jogo_equipe']) ?></td>
                                <td><img src="<?= htmlspecialchars($e['img']) ?>" alt="<?= htmlspecialchars($e['nome']) ?>" class="img-equipe"></td>
                                <td><?= htmlspecialchars($e['nome']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px;">Nenhuma equipe encontrada para "<?= htmlspecialchars($busca) ?>".</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</body>

</html>
