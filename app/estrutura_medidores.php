<?php 

require_once __DIR__ . '/init.php';

$setores = readAll(database(), "setor");
$ambientes = readAll(database(), "ambientes");
$leituras = readAll(database(), "leituras");
$metas = readAll(database(), "metas");

?>

<html>
    <head>
        <title>Estrutura de Medidores</title>
        <link rel="stylesheet" href="./css/styleMenu.css">
        <link rel="stylesheet" href="./css/styleEstrutura.css">
    </head>
    <body>
        <div class="menu-conf">
            <?php require_once __DIR__ . '/menuLateral.php'; ?>
            <div class="conteudo"> <! Todo o conteúdo da página vai aqui >

                <h1>Estrutura de Medidores</h1> <! Título da página >
                            <br>

                <?php foreach ($setores as $setor): ?> <! Cards com cada setor >

                    <div class="setor">
                        
                        <h2>Setor <?php echo $setor['id']; ?></h2> <! Setor com seu id >
                                    <br>
                        
                        <div class="total_kwh">
                            <h2>Gasto de energia</h2>
                            <h4>Em quilowatt-hora (kWh)</h4> <br>
                            <?php
                                $total_kwh = 0;
                                foreach ($leituras as $leitura) {
                                    foreach ($ambientes as $ambiente) {
                                        if ($leitura['ambiente_id'] == $ambiente['id'] && $ambiente['setor_id'] == $setor['id']) {
                                            $total_kwh += $leitura['leitura_acumulada_kwh'];
                                            
                                            echo "<h1>" . $total_kwh . " kWh</1>";

                                        }
                                        
                                    }
                                }
                            ?> <br>

                        </div>

                    </div> <br>
                <?php endforeach; ?>
                    
            </div>
        </div>
    </body>
</html>

<!
<?php foreach ($ambientes as $ambiente) : ?>
    <?php if ($ambiente['setor_id'] == $setor['id']): ?>
                                
        <h3><?php echo $ambiente['nome']; ?></h3>
        <p>Medidor: <?php echo $ambiente['codigo_medidor']; ?></p>
                                
    <?php endif; ?>
<?php endforeach; ?>

>