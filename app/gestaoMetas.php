<?php
    require_once __DIR__ . "/init.php";
    $setores = readAll(database(), "setor");
    $ambientesSetorA = readAll(database(), "ambientes", "setor_id = 1");
    $ambientesSetorB = readAll(database(), "ambientes", "setor_id = 2");
    $metas = readAll(database(), "metas");
    $somaA = 0;
    $somaB = 0;

    foreach($ambientesSetorA as $a){
        $ambienteid1 = $a['id'];

        $metaA = readAll(database(), "metas", "ambiente_id= {$ambienteid1}");
        $somaA += $metaA[0]['meta_kwh'];
    }
    foreach($ambientesSetorB as $b){
        $ambienteid2 = $b['id'];

        $metaB = readAll(database(), "metas", "ambiente_id= {$ambienteid2}");
        $somaB += $metaB[0]['meta_kwh'];
    }


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
                            <h3><?= $contador ?>. <?= $setor["nome"]?>- </h3>
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
                            <h3><?php print($contador1) ?>. <?php print($setor['nome'])?> - <?php if($contador1 == 1): print($somaA)?> kwh<?php else: print($somaB)?> kwh<?php endif ?></h3>
                            <?php
                            endforeach;
                            ?>
                        </div>
                    </div>
                    </div>
                    <div class="tabelasJuntas">
                        <?php foreach($setores as $setor): ?>
                            <div class="statusSetor">
                                <?php if($setor['estado_setor'] == 'Ativo'): ?>
                                <h2><?= $setor['nome'] ?> 🟢</h2>
                                <?php else: ?>
                                <h2><?= $setor['nome'] ?> 🔴</h2>
                                <?php endif ?>
                            </div>
                            <?php endforeach ?>
                        </div>
            </div>

        </div>
    </body>
</html>