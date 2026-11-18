<?php 
require_once __DIR__ . "/init.php";

$torneios = readAll($pdo, "torneios");
$equipes = readAll($pdo, "equipes");
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/app/css/administracao.css">
    <title>Administração</title>
</head>
<body>
    
    <div class="tudo">
        <?php require_once __DIR__ . "/cabecalho.php" ?>
        
        <div class="admin-list-container">
            <div class="list-header">
                <div class="col-principal">Torneios</div>
                <div class="col-secundaria">Premiação</div>
                <div class="col-acoes">Ações</div>
            </div>

            <?php foreach($torneios as$t): ?>
                <div class="list-item">
                    <div class="col-principal info-group">
                        <span class="nome-item"><?= htmlspecialchars($t['nome_torneio']) ?></span>
                        <span class="detalhes-item">
                            <?= htmlspecialchars($t['data_torneio']) ?> às <?= htmlspecialchars($t['horainit_torneio']) ?> | 
                            <?= htmlspecialchars($t['format_torneio']) ?> | 
                            <?= htmlspecialchars($t['qnt_jogadores']) ?> Jogadores | 
                            Taxa: <?= htmlspecialchars($t['taxa']) ?>
                        </span>
                    </div>

                    <div class="col-secundaria">
                        <span class="valor"><?= htmlspecialchars($t['premiacao']) ?></span> 
                        <span class="moeda">COINS</span> 
                    </div>

                    <div class="col-acoes">
                        <a href="./editarTorneio.php?id=<?= $t['id'] ?>" class="btn-icon" title="Editar">Editar</a>
                        <a href="./deletarTorneio.php?id=<?= $t['id'] ?>" class="btn-icon" title="Deletar"><span class="delBranco">EXCLUIR</span></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="admin-list-container">
            <div class="list-header">
                <div class="col-principal">Equipes</div>
                <div class="col-secundaria">Privacidade</div>
                <div class="col-acoes">Ações</div>
            </div>

            <?php foreach($equipes as$e): ?>
                <div class="list-item">
                    <div class="col-principal info-group">
                        <span class="nome-item"><?= htmlspecialchars($e['nome']) ?></span>
                        <span class="detalhes-item"><?= htmlspecialchars($e['descricao']) ?></span>
                    </div>

                    <div class="col-secundaria">
                        <span class="valor2"><?= htmlspecialchars($e['privacidade']) ?></span> 
                    </div>

                    <div class="col-acoes">
                        <a href="./editarEquipe.php?id=<?= $e['id'] ?>" class="btn-icon" title="Editar">Editar</a>
                        <a href="./deletarEquipe.php?id=<?= $e['id'] ?>" class="btn-icon" title="Deletar"><span class="delBranco">EXCLUIR</span></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>