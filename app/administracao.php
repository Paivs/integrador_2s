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

        <?php if( $_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['erro'])):?>
            <div class="erro">
                <?php if($_GET['erro'] == "HORARIO_PASSADO"): ?>
                    <p>O horário do torneio não pode ser no passado.</p>
                <?php elseif($_GET['erro'] == "NOME_INVALIDO"): ?>
                    <p>O nome do torneio é inválido.</p>
                <?php elseif($_GET['erro'] == "FORMATO_INVALIDO"): ?>
                    <p>O formato do torneio é inválido.</p>
                <?php elseif($_GET['erro'] == "JOGADORES_INVALIDO"): ?>
                    <p>A quantidade de jogadores deve ser maior que 0.</p>
                <?php elseif($_GET['erro'] == "TAXA_INVALIDA"): ?>
                    <p>A taxa do torneio não pode ser negativa.</p>
                <?php elseif($_GET['erro'] == "ID_NAO_ENCONTRADO"): ?>
                    <p>ID do torneio não encontrado.</p>
                <?php elseif($_GET['erro'] == "TORNEIO_JA_PASSOU"): ?>
                    <p>A data do torneio não pode ser no passado.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
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
                            <?= htmlspecialchars($t['qnt_jogadores']) ?> Jogadores | Jogo:
                            <?= htmlspecialchars($t['nmjogo_torneio']) ?> | 
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