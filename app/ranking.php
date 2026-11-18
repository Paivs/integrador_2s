
<?php

require_once __DIR__ . "/init.php";

$busca = trim($_GET['busca'] ?? '');


$sql = "
    SELECT
        r.id,
        r.pontuacao,
        u.username_conta,
        e.nome AS equipe,
        e.img AS img_equipe,
        e.jogo_equipe

    FROM ranking r

    INNER JOIN usuarios u
        ON r.id_usuario = u.id

    LEFT JOIN equipes e
        ON u.id_equipe = e.id
";


if ($busca !== '') {

    $sql .= "
        WHERE u.username_conta LIKE ?
        OR e.nome LIKE ?
        OR e.jogo_equipe LIKE ?
    ";

    $termo = "%{$busca}%";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $termo,
        $termo,
        $termo
    ]);

} else {

    $stmt = $pdo->query($sql);

}


$ranking = $stmt->fetchAll(PDO::FETCH_ASSOC);

usort($ranking, function ($a, $b) {
    return $b['pontuacao'] <=> $a['pontuacao'];
});

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ranking</title>

    <link rel="stylesheet" href="./css/ranking.css">

</head>

<body>

    <?php require_once __DIR__ . "/cabecalho.php"; ?>

    <main class="ranking-container">

        

        <form method="GET" class="barra-pesquisa">

            <input
                type="text"
                name="busca"
                placeholder="Buscar jogador ou equipe:"
                value="<?= htmlspecialchars($busca, ENT_QUOTES, 'UTF-8') ?>"
            >

            <button type="submit">
                Buscar
            </button>

        </form>


      

        <div class="tabela-ranking">

            <table>

                <thead>

                    <tr>

                        <th>PLACE</th>

                        <th>PLAYER</th>

                        <th>PONTUAÇÃO</th>

                    </tr>

                </thead>

                <tbody>

                    <?php if (!empty($ranking)): ?>

                        <?php foreach ($ranking as $index => $jogador): ?>

                            <tr>

                                

                                <td class="coluna-place">

                                    <?= $index + 1 ?>º

                                </td>


                                
                                <td class="coluna-player">

                                    <div class="info-player">

                                        <?php if (!empty($jogador['img_equipe'])): ?>

                                            <img
                                                src="/app/img/logos/<?= htmlspecialchars($jogador['img_equipe'], ENT_QUOTES, 'UTF-8') ?>"
                                                alt="Logo da equipe"
                                                class="logo-equipe"
                                            >

                                        <?php endif; ?>

                                        <div class="dados-player">

                                            <span class="nome-player">

                                                <?= htmlspecialchars($jogador['username_conta'], ENT_QUOTES, 'UTF-8') ?>

                                            </span>

                                            <span class="nome-equipe">

                                                <?= htmlspecialchars($jogador['equipe'] ?? 'Sem equipe', ENT_QUOTES, 'UTF-8') ?>

                                            </span>

                                        </div>

                                    </div>

                                </td>



                                <td class="coluna-pontuacao">

                                    <?= number_format($jogador['pontuacao'], 0, ',', '.') ?>

                                    <span>PTS</span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="3" class="sem-resultados">

                                Nenhum jogador encontrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </main>
                        <?php require_once __DIR__ . "/rodape.php" ?>
</body>

</html>
