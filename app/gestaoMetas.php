<?php
    require_once __DIR__ . "/init.php";
    $setores = readAll(database(), "setor");
    $gastos = [3100012, 2400042];
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/styleMenu.css">
        <link rel="stylesheet" href="./css/styleGestao.css">
    </head>
    <body>
        <div class="menu-conf">
            <?php require_once __DIR__ . "/menuLateral.php"; ?>
            <div class="conteudo">
                <h1>Gestão de Metas e Rankings</h1>
                <div class="tabelasJuntas">
                <div class="rankingBorder">
                    <div class="rankingGastos">
                        <h2>Rankings - Gastos</h2>
                        <p>Em R$</p>
                    </div>
                </div>
                    
                    <div class="rankingTabela">
                        <div class="rankingTabelaConteudo">
                            <h2>Ranking - Gastos</h2>
                            <?php
                            $contador = 0;
                            foreach($setores as $setor):
                                $contador += 1
                            ?>
                            <h3><?= $contador ?>- <?= $setor["nome"]?></h3>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>

                </div>
                
                <div class="tabelasJuntas">
                    <div class="rankingMetaBorder">
                        <div class="rankingGastosMeta">
                            <h2>Rankings - Gasto p/ Meta</h2>
                            <p>Em R$</p>
                        </div>
                    </div>
                    
                    <div class="rankingGastosTabela">
                        <div class="rankingGastosTabelaConteudo">
                            <h2>Meta p/ setor</h2>
                            <?php
                            $contador1 = 0;
                            foreach($setores as $setor):
                                $contador1++
                            ?>
                            <h3><?= $contador1 ?>- <?= $setor["nome"]?></h3>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>


                    </div>
            </div>

        </div>
    </body>
</html>