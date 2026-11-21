<?php 

    require_once __DIR__ . "/init.php";

    $consulta = $pdo->query(" SELECT ranking.pontuacao, usuarios.id AS id_usuario, usuarios.username_conta FROM ranking INNER JOIN usuarios ON ranking.id_usuario = usuarios.id ORDER BY ranking.pontuacao DESC ");

$ranking = $consulta->fetchAll(PDO::FETCH_ASSOC);

    $local = 0;
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rankings</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php"?>

    <table border="1">
        <tr>
            <th>Place</th>
            <th>Player</th>
            <th>Pontuação</th>
        </tr>
    <?php foreach($ranking as $r):?>
        <tr>
            <td>
                <a href="perfil.php?id=<?= $r['id_usuario'] ?>"><?= $local = $local + 1 ?></a>
            </td>
            <td>
                <a href="perfil.php?id=<?= $r['id_usuario'] ?>"><?= $r['username_conta'] ?></a>
            </td>
            <td>
                <a href="perfil.php?id=<?= $r['id_usuario'] ?>"><?= $r['pontuacao'] ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</body>
</html>