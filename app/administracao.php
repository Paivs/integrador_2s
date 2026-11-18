<?php 

require_once __DIR__ . "/init.php";

$torneios = readAll($pdo, "torneios");

?>

<!DOCTYPE html>
<html lang="PT-BR">

<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/administracao.css">
    <title>administração</title>
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php" ?>
    <table border="1">
        <tr>
            <th>Torneios</th>
            <th>Data</th>
            <th>Horario</th>
            <th>Premiação</th>
            <th>Quantidade de jogadores</th>
            <th>Formato do torneio</th>
            <th>Taxa</th>
            <th>Imagens</th>
            <th>Ações</th>
        </tr>
    <?php foreach($torneios as $t): ?>
        <?php print"
            <tr>
                <td>$t[nome_torneio]</td>
                <td>$t[data_torneio]</td>
                <td>$t[horainit_torneio]</td>
                <td>$t[premiacao]</td>
                <td>$t[qnt_jogadores]</td>
                <td>$t[format_torneio]</td>
                <td>$t[taxa]</td>
                <td>$t[img]</td>
                <td><a href='./editarTorneio.php?id={$t['id']}'>Editar</a>
                <a href='./deletarTorneio.phpid?={$t['id']}'>Deletar</a></td>
            </tr>
        "?>
    <?php endforeach ?>
    </table>
</body>