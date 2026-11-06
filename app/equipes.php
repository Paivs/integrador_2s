<?php

require_once __DIR__ . "/init.php";

$equipes = readAll($pdo, "equipes")
?>

<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/app/css/equipes.css">
</head>
<body>
    <?php require_once __DIR__ . "/cabecalho.php"?>

    <section class="fundo-equipes">

    <div class="conteudo-equipes">
        <div class="funcao">
        <form action="https://google.com" method="get" target="_blank" class="barra-pesquisa">
            <input type="hidden" name="q" value="site:seu-site.com">
            <input type="text" name="q" placeholder="Buscar equipe:" required class="pesquisar">
            <button type="submit" class="enviar">Buscar</button>
        </form>

        <a href=""><i>CRIAR <span>EQUIPE</span></i></a>
        </div>

        

          <table class="tabela-equipes">
    <thead>
        <tr>
            <th>Jogo</th>
            <th>Escudo</th>
            <th>Nome</th>
        </tr>
    </thead>
    <tbody>
        <?php 

        $jogos = ["Counter-Strike 2", "Valorant", "League of Legends", "Free Fire"];
        foreach ($jogos as $jogo): 
            foreach ($equipes as $e): 
                if ($e['jogo_equipe'] === $jogo): ?>
                    <tr>
                        <td><?= htmlspecialchars($e['jogo_equipe']) ?></td>
                        <td><img src="<?= htmlspecialchars($e['img']) ?>" alt="<?= htmlspecialchars($e['nome']) ?>" class="img-equipe"></td>
                        <td><?= htmlspecialchars($e['nome']) ?></td>
                    </tr>
                <?php 
                endif;
            endforeach;
        endforeach; 
        ?>
            </tbody>
        </table>
        </div>
    </section>
    
</body>
</html>