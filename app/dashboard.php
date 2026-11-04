<?php
    require_once __DIR__ . "/init.php";

    $bancadas = readAll($pdo, "Bancadas");
    $ferramentas = readAll($pdo, "Ferramentas");

?>

<html>
    <head></head>
    <body>
        <h1>Lista de Bancadas</h1>
        <table border=1>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Área</td>
                    <td>Preço</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($bancadas as $p): ?>
                    <tr>
                        <td><?=  $p['id_bancada'] ?></td>   
                        <td><?=  $p['nome_bancada'] ?></td>   
                        <td><?=  $p['area_bancada'] ?></td>     
                        <td><?=  $p['preco_bancada'] ?></td>     
                        <td>
                            <a href="editarBancada.php?id=<?= $p['id_bancada']?>">Editar</a>
                            <a href="deletarBancada.php?id=<?= $p['id_bancada']?>">Deletar</a>
                        </td>   
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <h1>Lista de Ferramentas</h1>
        <table border=1>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nome</td>
                    <td>Área</td>
                    <td>Estoque</td>
                    <td>Ações</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ferramentas as $p): ?>
                    <tr>
                        <td><?=  $p['id_ferramenta'] ?></td>   
                        <td><?=  $p['nome_ferramenta'] ?></td>   
                        <td><?=  $p['area'] ?></td>    
                        <td><?=  $p['estoque'] ?></td>    
                        <td>
                            <a href="editarFerramenta.php?id=<?= $p['id_ferramenta']?>">Editar</a>
                            <a href="deletarFerramenta.php?id=<?= $p['id_ferramenta']?>">Deletar</a>
                        </td>   
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </body>
</html>