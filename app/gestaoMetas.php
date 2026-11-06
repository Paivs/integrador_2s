<?php
    require_once __DIR__ . "/init.php";
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
                        </div>
                    </div>

                </div>
                

                    <div class="rankingMetaBorder">
                        <div class="rankingGastosMeta">
                            <h2>Rankings - Gasto p/ Meta</h2>
                            <p>Em R$</p>
                        </div>
                    </div>
                    
                    

            </div>

        </div>
    </body>
</html>