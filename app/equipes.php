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

            <a href="#popup"><i>CRIAR <span>EQUIPE</span></i></a>

<div id="popup" class="criar-equipe">
    <div class="popup-box">
        <a class="fechar" href="#">&times;</a>

        <h1>CRIAÇÃO DE <span>EQUIPE</span></h1>

        <form class="criarConta" action="processaEquipes.php" method="POST">
            <div class="linha-superior">
                
                <label for="logo" class="logo">
                    ESCOLHA UMA LOGO
                    <input type="file" id="logo" name="logo" accept="image/*" hidden>
                </label>

                
                <div class="coluna-input">
                    <input type="text" name="nome" placeholder="ESCOLHA UM NOME:">
                    <input type="text" name="jogo" placeholder="ESCOLHA O JOGO:">
                </div>

                
                <select name="privacidade" class="privacidade">
                    <option value="" disabled selected>TIPO DE PRIVACIDADE</option>
                    <option value="publica">PÚBLICA</option>
                    <option value="privada">PRIVADA</option>
                </select>
            </div>

            
            <textarea name="descricao" placeholder="DESCRIÇÃO:"></textarea>

            
            <button type="submit">CRIAR EQUIPE:</button>
        </form>
    </div>
</div>

        </div>

        <div class="conteudo-equipes">
            <table class="tabela-equipes">
                <thead>
                    <tr>
                        <th><i>Escudo</i></th>
                        <th><i>Nome</i></th>
                        <th><i>Jogo</i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($equipes)): ?>
                        <?php foreach ($equipes as $e): ?>
                            <tr>
                                <td><img src="./img/logos/<?= htmlspecialchars($e['img']) ?>" alt="<?= htmlspecialchars($e['nome']) ?>" class="img-equipe"></td>
                                <td><?= htmlspecialchars($e['nome']) ?></td>
                                <td><?= htmlspecialchars($e['jogo_equipe']) ?></td>
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
