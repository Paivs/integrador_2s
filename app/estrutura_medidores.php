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
            
                <h1>Estrutura de Medidores </h1> <! Título da página >
                            <br>
                            <br>

                <?php foreach ($setores as $setor): ?> <! Cards com cada setor >
                    <?php
            
                        $area_total = 0;
                        foreach ($ambientes as $ambiente) {
                            if ($ambiente['setor_id'] == $setor['id']) {
                                $area_total += $ambiente['area_m2'];
                            }
                        }

                        $total_kwh = 0;
                        foreach ($ambientes as $ambiente) {
                            foreach ($leituras as $leitura) {
                                if ($leitura['ambiente_id'] == $ambiente['id'] && $ambiente['setor_id'] == $setor['id']) {
                                    $total_kwh += $leitura['leitura_acumulada_kwh'];
                                }
                            }
                        } 
                        
                        $meta_setor = 0;
                        foreach ($metas as $meta) {
                            foreach ($ambientes as $ambiente) {     
                                if($meta['ambiente_id'] == $ambiente['id'] && $ambiente['setor_id'] == $setor['id']) {
                                    $meta_setor += $meta['meta_kwh'];
                                }
                            }
                        }
                        
                        $porcentagem_meta = ($total_kwh / $meta_setor) * 100;
                        $porcentagem_meta = number_format($porcentagem_meta, 2);

                        if ($porcentagem_meta > 100) {
                            $cor_meta = 'vermelho';
                        } elseif ($porcentagem_meta > 80) {
                            $cor_meta = 'amarelo';
                        } else {
                            $cor_meta = 'verde';
                        }

                    ?>

                    <div class="setor_<?php echo $cor_meta; ?>">

                        <div class="setor_info">

                            <div class="setor_e_area">
                                <h2>Setor 0<?php echo $setor['id']; ?></h2>  <! Setor com seu id > 

                                <h3>Área total monitorada: <?php echo $area_total; ?> m²</h3>
                            </div>    

                            <div class="info">
                                <h2 class="setor_nome"><?php echo $setor['nome']; ?></h2>
                                <h2>
                                    <?php 
                                    
                                    if($cor_meta == 'vermelho'){ 
                                        echo "<b>Alerta 🔴</b>"; 
                                    } elseif($cor_meta == 'amarelo'){ 
                                        echo "<b>Atenção 🟡</b>";
                                    } else {
                                        echo "<b>Suave 🟢</b>";
                                    }
                    
                                    ?>
                                </h2>
                            </div>
                                    
                        </div>  <br>
                        
                        <div class="kwh_e_reais">
                        <div class="total_kwh">
                            <h2>Gasto de energia</h2>
                            <h4>Em quilowatt-hora (kWh)</h4> <br>
                            <?php
                                
                                echo "<h1>" . $total_kwh . " kWh</h1><br>";
                          
                                echo "<h4>Meta: " . $meta_setor . " kWh | <b class='meta_" . $cor_meta . "'>" . $porcentagem_meta . " % da meta</b></h4>";
                            
                            ?> 


                        </div>

                        <div class="total_reais">
                            <h2>Custo estimado</h2>
                            <h4>Em reais (R$)</h4> <br>
                            <?php
                                $tarifa_media = 0.7;

                                $total_reais = $total_kwh * $tarifa_media;

                                echo "<h1>R$ " . $total_reais . " </h1><br>";
                            
                                echo "<h4>Tarifa média: R$ " . $tarifa_media . " p/ kWh</h4>";
                            ?> 

                        </div>

                        <div class="eficiencia">

                            <h2>Eficiência energética</h2>
                            <h4>Em quilowatt-hora por metro quadrado</h4> <br>
                            <?php
                                $eficiencia = $total_kwh / $area_total;
                                $eficiencia = number_format($eficiencia, 2);

                                echo "<h1>" . $eficiencia . " kWh/m²</h1><br>";
                            
                            ?> 

                        </div>

                        </div>

                    </div> 
                <?php endforeach; ?>
                    
            </div>
        </div>
    </body>
</html>
