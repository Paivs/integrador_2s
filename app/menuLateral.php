<?php
    require_once __DIR__ . "/init.php";
    $setores = readAll(database(), "setor");
?>
<header class="menu-lateral">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <center>
        <img src="./img/Energy Monitor.png" width="130">
    </center>
    <nav>
        <ul class="nav">
            <div class="elemento">
                <a href="./index.php"><img src="./img/Dashboard.png"></a>
                <li><b><a href="./index.php">DashBoard</a></b></li>
            </div>
            <div class="elemento">
                <a href="./lançamento_de_dados.php"><img src="./img/LançamentoDados.png"></a>
                <li><a href="./lancamento_de_dados.php">Lançamento de Dados</a></li>
            </div>

            <details class="mouse">
                <summary class="titulo">
                    <div class="elemento">
                        <a href="./estrutura_medidores.php"><img src="./img/EstruturaMedidores.png"></a>
                        <p>Estrutura e Medidores</p>
                    </div>
                </summary>
                <div class="elementos-blocos">
                    <button class="item"><a href="./estrutura_medidores.php">🟢 Início</a></button>
                    <?php foreach($setores as $s): ?>
                        <button class="item"><a href="./setores_ambientes.php?id=<?= $s['id'] ?>">🟢 <?= $s['nome'] ?></a></button>
                    <?php endforeach ?>
                    
                    </div>
            </details>

            <div class="elemento">
                <a href="./gestaoMetas.php"><img src="./img/GestãoMetas.png"></a>
                <li><a href="./gestaoMetas.php">Gestão de Metas e Rankings</a></li>
            </div>
            <div class="elemento">
                <a href="./analise_e_comparativos.php"><img src="./img/AnaliseComparativos.png"></a>
                <li><a href="./analise_e_comparativos.php">Análise e comparativos</a></li>
            </div>
            <div class="elemento">
                <a href="./engajamento_e_avisos.php"><img src="./img/Avisos.png"></a>
                <li><a href="./engajamento_e_avisos.php">Engajamento e Avisos</a></li>
            </div>
        </ul>
    </nav>
    
</header>