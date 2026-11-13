<?php
    require_once __DIR__ . "/init.php";

    $bancadas = readAll($pdo, "Bancadas");
    $ferramentas = readAll($pdo, "Ferramentas");

    if (isset($_SESSION['id'])) {
        $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
        if($userAtual['perfil'] != "admin" || !isset($userAtual)){
            header("Location: index.php");
            exit;
        }
    }else{
        header("Location: index.php");
        exit;
    };
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
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
                    
                    <a href="./dashboard.php" class="item ativo">
                        <img src="./img/icons/pen_roxo.png" alt="" class="icone">
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="./adicionarFerramenta.php" class="item">
                        <img src="./img/icons/plus_branco.png" alt="" class="icone">
                        <span>Ferramenta</span>
                    </a>
                    
                    <a href="./adicionarBancada.php" class="item">
                        <img src="./img/icons/plus_branco.png" alt="" class="icone">
                        <span>Bancada</span>
                    </a>
                    
                    <a href="./historicoReservas.php" class="item">
                        <img src="./img/icons/folder_branco.png" alt="" class="icone">
                        <span>Reservas</span>
                    </a>
                </div>
            </nav>
        </header>

        <main class="conteudo">

            <section class="secao">
                <h1>Lista de Bancadas</h1>
                <div class="caixa-tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Área</th>
                                <th>Preço</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($bancadas as $p): ?>
                                <tr>
                                    <td><?= $p['id_bancada'] ?></td>
                                    <td><?= $p['nome_bancada'] ?></td>
                                    <td><?= $p['area_bancada'] ?></td>
                                    <td><?= $p['preco_bancada'] ?></td>
                                    <td>
                                        <?php if ($p['status_bancada'] == "indisponivel"): ?>
                                            <span class="etiqueta vermelha">Indisponível</span>
                                        <?php elseif ($p['status_bancada'] == "disponivel"): ?>
                                            <span class="etiqueta verde">Disponível</span>
                                        <?php else: ?>
                                            <?= $p['status_bancada'] ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a class="botao editar" href="editarBancada.php?id=<?= $p['id_bancada'] ?>">Editar</a>
                                        <a class="botao excluir" href="deleteBancada.php?id=<?= $p['id_bancada'] ?>">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="secao">
                <h1>Lista de Ferramentas</h1>
                <div class="caixa-tabela">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Área</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ferramentas as $p): ?>
                                <tr>
                                    <td><?= $p['id_ferramenta'] ?></td>
                                    <td><?= $p['nome_ferramenta'] ?></td>
                                    <td><?= $p['area'] ?></td>
                                    <td>
                                        <?php if ($p['estoque'] == 0): ?>
                                            <span class="etiqueta vermelha">Sem estoque</span>
                                        <?php else: ?>
                                            <span class="etiqueta verde"><?= $p['estoque'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a class="botao editar" href="editarFerramenta.php?id=<?= $p['id_ferramenta'] ?>">Editar</a>
                                        <a class="botao excluir" href="deleteFerramenta.php?id=<?= $p['id_ferramenta'] ?>">Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </main>
    </body>
</html>