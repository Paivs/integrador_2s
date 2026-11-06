<?php
    require_once __DIR__ . "/init.php";

    $bancadas = readAll($pdo, "Bancadas");
    $ferramentas = readAll($pdo, "Ferramentas");

?>

<html>
    <head>
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
                    
                    <a href="#" class="item ativo">
                        <img src="./img/icons/pen_whiteback.webp" alt="" class="icone">
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="#" class="item">
                        <img src="./img/icons/plus.webp" alt="" class="icone">
                        <span>Adicionar Equipamento</span>
                    </a>
                    
                    <a href="./cadastro.php" class="item">
                        <img src="./img/icons/plus.webp" alt="" class="icone">
                        <span>Adicionar Bancada</span>
                    </a>
                    
                    <a href="#" class="item">
                        <img src="./img/icons/folder.webp" alt="" class="icone">
                        <span>Histórico de Reservas</span>
                    </a>
                </div>
            </nav>
        </header>
        <main class="conteudo">
            <h1>Lista de Bancadas</h1>
            <table border=1>
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nome</td>
                        <td>Área</td>
                        <td>Preço</td>
                        <td>Ações</td>
                        <td>Status</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bancadas as $p): ?>
                        <tr>
                            <td><?=  $p['id_bancada'] ?></td>   
                            <td><?=  $p['nome_bancada'] ?></td>   
                            <td><?=  $p['area_bancada'] ?></td>     
                            <td><?=  $p['preco_bancada'] ?></td>     
                            <td><?=  $p['status_bancada'] ?></td>     
                            <td>
                                <a href="editarBancada.php?id=<?= $p['id_bancada']?>">Editar</a>
                                <a href="deleteBancada.php?id=<?= $p['id_bancada']?>">Deletar</a>
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
                                <a href="deleteFerramenta.php?id=<?= $p['id_ferramenta']?>">Deletar</a>
                            </td>   
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </main>
    </body>
</html>