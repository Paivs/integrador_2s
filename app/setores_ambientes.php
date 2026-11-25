<?php 

require_once __DIR__ . '/init.php';

$setores = readAll(database(), "setor");
$ambientes = readAll(database(), "ambientes");
$leituras = readAll(database(), "leituras");
$metas = readAll(database(), "metas");

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['setor_id'])) {
    exit;
}

$andar_existe = false;
$setor_existe = false;

?>

<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <title>Setores e Ambientes</title>
        <link rel="stylesheet" href="./css/styleMenu.css">
        <link rel="stylesheet" href="./css/styleAmbientes.css">
    </head>
    <body>
        <div class="menu-conf">
            <?php require_once __DIR__ . '/menuLateral.php'; ?>
            <div class="conteudo"> 

            <?php foreach ($setores as $setor){

                $area_total = 0;
                foreach ($ambientes as $ambiente) {
                    if ($ambiente['setor_id'] == $setor['id']) {
                        $area_total += $ambiente['area_m2'];
                    }
                }

                if($setor['id'] == $_GET['id']){
                    $setor_existe = true;
                    echo "

                    <div class='info_pagina'>

                    <h1>Setor 0" . $setor['id'] . "</h1>

                    <h2>" . $setor['nome'] . "</h2>

                    <h2>Área total monitorada: " . $area_total . " m²</h2>
                    
                    </div>

                    ";
                }

            }

            if($setor_existe): ?> 

                <?php

                    if(isset($_GET['andar'])){
                        $andar_anima = "1";
                    } else {
                        $andar_anima = null;
                    }

                ?>

                <div class="andar<?= $andar_anima ?>">
                    <?php  
                    $area_andar = 0;
                    $qtd_equipamentos = 0;
                    foreach($ambientes as $ambiente){
                        if($ambiente['setor_id'] == $_GET['id'] && $ambiente['andar'] == "Térreo"){
                            $area_andar += $ambiente['area_m2'];
                            $qtd_equipamentos += $ambiente['qtd_equipamentos'];
                            $nome_andar = $ambiente['andar'];
                        } 
                    }
                    
                    ?>
                        
                        <div class="titulo_e_link">
                            <div class="titulo_andar">
                                <h2>Andar: <?php echo $nome_andar ?></h2> <p class="area">Área total monitorada: <span class="dados"><?php echo $area_andar; ?> m²</span></p> <p class="area">Quantidade de equipamentos:  <span class="dados"><?php echo $qtd_equipamentos ?></span></p>
                            </div> 

                            <div class="ver_dados"><a href="setores_ambientes.php?id=<?= $_GET['id'] ?>&andar=Térreo">Ver dados</a></div>
                        </div>

                        <br>


                        <div class="info_andar">
                            <div class="ambientes">
                                <h4>Ambientes: </h4> <hr>

                                <table>
                                    <?php  
                                    foreach($ambientes as $ambiente): 
                                        if($ambiente['setor_id'] == $_GET['id'] && $ambiente['andar'] == "Térreo"): ?>
                                                
                                                <tr class="ambiente">
                                                    <td class="nome"><?= $ambiente['nome'] ?></td>
                                                    <td>Medidor: 
                                                    <span class="dados_medidor"><?= $ambiente['codigo_medidor'] ?>
                                                        <div class="card-info">
                                                            <h4>Ambiente: <?= $ambiente['nome'] ?></h4> <br>
                                                            <p>
                                                            <?php
                                                                $kwh_ambiente = 0;
                                                                foreach ($leituras as $leitura) {
                                                                    if ($leitura['ambiente_id'] == $ambiente['id']) {
                                                                        $kwh_ambiente += $leitura['leitura_acumulada_kwh'];
                                                                    }
                                                                }
                                                                echo "kilowatts gastos: " . $kwh_ambiente . " kWh";
                                                            ?>
                                                            </p>
                                                        </div>
                                                    </span>
                                                </td>
                                                    <td>Área total monitorada: <span class="dados"><?= $ambiente['area_m2'] ?></span></td>
                                                    <td>Quantidade de equipamentos: <span class="dados"><?= $ambiente['qtd_equipamentos'] ?></span></td>
                                                    <td>Tempo de uso diário: <span class="dados"><?= $ambiente['tempo_uso_medio_diario'] ?></span></td>
                                                    <td><span class="status"><?= $ambiente['estado_medidor'] ?></span></td>
                                                </tr>
                                            
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </table>

                            </div>
                        
                        </div>
                            
                </div> 
                
                <div class="andar<?= $andar_anima ?>">
                    <?php  
                    $area_andar = 0;
                    $qtd_equipamentos = 0;
                    foreach($ambientes as $ambiente){
                        if($ambiente['setor_id'] == $_GET['id'] && $ambiente['andar'] == 1){
                            $area_andar += $ambiente['area_m2'];
                            $qtd_equipamentos += $ambiente['qtd_equipamentos'];
                            $nome_andar = $ambiente['andar'];
                        } 
                    }
                    
                    ?>
                        <div class="titulo_e_link">
                            <div class="titulo_andar">
                                <h2>Andar: <?php echo $nome_andar ?></h2> <p class="area">Área total monitorada: <span class="dados"><?php echo $area_andar; ?> m²</span></p> <p class="area">Quantidade de equipamentos:  <span class="dados"><?php echo $qtd_equipamentos ?></span></p>
                            </div> 

                            <div class="ver_dados"><a href="setores_ambientes.php?id=<?= $_GET['id'] ?>&andar=1">Ver dados</a></div>

                        </div>
                        <br>

                        <div class="info_andar">
                            <div class="ambientes">
                                <h4>Ambientes: </h4> <hr>

                                <table>
                                    <?php  
                                    
                                    foreach($ambientes as $ambiente): 
                                        if($ambiente['setor_id'] == $_GET['id'] && $ambiente['andar'] == 1): ?>
                                            
                                            <tr>
                                                <td class="nome"><?= $ambiente['nome'] ?></td>
                                                <td>Medidor: 
                                                    <span class="dados_medidor"><?= $ambiente['codigo_medidor'] ?>
                                                        <div class="card-info">
                                                            <h4>Ambiente: <?= $ambiente['nome'] ?></h4> <br>
                                                            <p>
                                                            <?php
                                                                $kwh_ambiente = 0;
                                                                foreach ($leituras as $leitura) {
                                                                    if ($leitura['ambiente_id'] == $ambiente['id']) {
                                                                        $kwh_ambiente += $leitura['leitura_acumulada_kwh'];
                                                                    }
                                                                }
                                                                echo "kilowatts gastos: " . $kwh_ambiente . " kWh";
                                                            ?>
                                                            </p>
                                                        </div>
                                                    </span>
                                                </td>
                                                <td>Área total monitorada: <span class="dados"><?= $ambiente['area_m2'] ?></span></td>
                                                <td>Quantidade de equipamentos: <span class="dados"><?= $ambiente['qtd_equipamentos'] ?></span></td>
                                                <td>Tempo de uso diário: <span class="dados"><?= $ambiente['tempo_uso_medio_diario'] ?></span></td>
                                                <td><span class="status"><?= $ambiente['estado_medidor'] ?></span></td>
                                            </tr>                            

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </table>

                            </div>
                        
                        </div>
                            
                </div> 
                
                <?php
                if(isset($_GET['andar'])){
                    if($_GET['andar'] == 'Térreo' || $_GET['andar'] == '1'){
                        $andar_existe = true;
                    }else{
                    echo 
                    "

                        <br>

                        <div class='erro'>
                            
                        <h1>⛔ ERRO: Andar não encontrado dentro do banco.</h1> <br>

                        <h2>Tente ver os dados novamente...</h2>

                        </div>

                        "; 
        
                    }; 
                                            
                }

                if($andar_existe){

                    $area_andar = 0;
                        foreach ($ambientes as $ambiente) {
                            if ($ambiente['andar'] == $_GET['andar'] && $ambiente['setor_id'] == $_GET['id']) {
                                $area_andar += $ambiente['area_m2'];
                            }
                        }                        

                    $total_kwh = 0;
                        foreach ($ambientes as $ambiente) {
                            foreach ($leituras as $leitura) {
                                if ($leitura['ambiente_id'] == $ambiente['id'] && $ambiente['andar'] == $_GET['andar'] && $ambiente['setor_id'] == $_GET['id']) {
                                    $total_kwh += $leitura['leitura_acumulada_kwh'];
                                }
                            }
                        } 
                        
                    $meta_andar = 0;
                        foreach ($metas as $meta) {
                            foreach ($ambientes as $ambiente) {     
                                if($meta['ambiente_id'] == $ambiente['id'] && $ambiente['andar'] == $_GET['andar'] && $ambiente['setor_id'] == $_GET['id']) {
                                    $meta_andar += $meta['meta_kwh'];
                                }
                            }
                        } 

                    if($total_kwh <= 0){    
                        $porcentagem_meta = 0;
                    } elseif($meta_andar <= 0) {
                        $porcentagem_meta = "Acima de 100";
                    } else {
                        $porcentagem_meta = ($total_kwh / $meta_andar) * 100; 
                        $porcentagem_meta = number_format($porcentagem_meta, 2);
                    };

                        if ($porcentagem_meta == "Acima de 100" || $porcentagem_meta > 100) {
                            $cor_meta = 'vermelho';
                        } elseif ($porcentagem_meta > 90) {
                            $cor_meta = 'amarelo';
                        } else {
                            $cor_meta = 'verde';
                        }
                    
                    ?>

                        <div class="card_resumo_andar">

                            <div class="resumo_andar_title">
                                <div>
                                    <h2>Andar: <?php echo $_GET['andar']; ?></h2> 
                                </div>
                                

                                <div class="info">
                                    <h2>
                                        <?php 
                                        
                                        if($cor_meta == 'vermelho'){ 
                                            echo "<b>Alerta 🔴</b>"; 
                                        } elseif($cor_meta == 'amarelo'){ 
                                            echo "<b>Atenção 🟡</b>";
                                        } else {
                                            echo "<b>Estável 🟢</b>";
                                        }
                        
                                        ?>
                                    </h2>
                                </div>
                            </div>
                                    
                            <br>

                            <div class="kwh_real_efic">

                                <div class="total_kwh_andar">
                                    <h2>Gasto de energia</h2>
                                    <h4>Em quilowatt-hora (kWh)</h4> <br>
                                    <?php
                                        
                                        echo "<h1><span class='contador'>" . $total_kwh . "</span> kWh</h1><br>";
                                
                                        echo "<h4>Meta: " . $meta_andar . " kWh | <b class='meta_" . $cor_meta . "'><span class='contador'>" . $porcentagem_meta . "</span>% da meta</b></h4>";
                                        
                                    ?> <br> <hr>

                                    <canvas id="grafico1"></canvas>

                                </div>

                                <div>
                                    <div class="titulo_andar">

                                        <div class="total_reais_andar">
                                            <h2>Custo estimado</h2>
                                            <h4>Em reais (R$)</h4> <br>
                                            <?php
                                                $tarifa_media = 0.8;

                                                $total_reais = $total_kwh * $tarifa_media;

                                                echo "<h1>R$ <span class='contador'>" . $total_reais . "</span> </h1><br>";
                                            
                                                echo "<h4>Tarifa média: R$ " . $tarifa_media . " p/ kWh</h4>";
                                            ?> 

                                        </div>

                                        <div class="eficiencia_andar">

                                            <h2>Eficiência energética</h2>
                                            <h4>Em quilowatt-hora por metro quadrado</h4> <br>
                                            <?php
                                                if($total_kwh <= 0 || $area_andar <= 0 || !isset($total_kwh) || !isset($area_andar)){
                                                    $eficiencia = 0;
                                                } else {
                                                    $eficiencia = $total_kwh / $area_andar;
                                                }
                                                $eficiencia = number_format($eficiencia, 2);

                                                echo "<h1><span class='contador'>" . $eficiencia . "</span> kWh/m²</h1><br>";

                                                echo "<h4>Área total: " . $area_andar . " m²"
                                            
                                            ?> 
                                        </div>

                                    </div> 
                                    
                                    <div class="projecao">
                                        
                                        <?php

                                        $kwh_lidos = [];
                                        $data_leitura = [];

                                        try{

                                            $leitura = $pdo->prepare('
                                                SELECT * FROM leituras ORDER BY data_hora ASC
                                            ');
                                            $leitura->execute();
                                            $leituras = $leitura->fetchAll();

                                        } catch(PDOException $erro) {
                                            error_log($erro->getMessage());
                                            exit("Falha ao ler as leituras.");
                                        }

                                        foreach($leituras as $l){
                                            foreach($ambientes as $a){
                                                if($l['ambiente_id'] == $a['id'] && $a['andar'] == $_GET['andar'] && $a['setor_id'] == $_GET['id']){
                                                $kwh_lidos[] = $l['leitura_acumulada_kwh'];

                                                $data = new DateTimeImmutable($l['data_hora']);

                                                $diaMes = $data->format('d/m');
                                            
                                                $data_leitura[] = $diaMes;
                                                }
                                            }
                                        } 
                                        
                                        ?>

                                        <div> 
                                            <h2>Projeção para o fim do mês</h2> <br>
                                            <h4>Com a média de consumo das últimas leituras: </h4> 
                                            <?php
                                            
                                                if($total_kwh <= 0 || !isset($total_kwh)){
                                                    $media_consumo = 0;
                                                    $consumo_final = 0;
                                                } else {
                                                    $media_consumo = $total_kwh / count($data_leitura);
                                                    $consumo_final = $media_consumo * 30;
                                                }

                                                
                                                echo "<h1><span class='contador'>" . $media_consumo . "</span> kWh p/ dia</h1></div><br>";
                                        
                                                echo "

                                                <div class='consumo_final'>

                                                <h4>No final do mês teremos um consumo de: </h4>
                                                
                                                <h1><span class='contador'>" . $consumo_final . "</span> kWh</h1>
                                                
                                                </div>
                                                
                                                "
                                                
                                            ?>

                                    </div>


                                </div>

                            </div>

                        </div>

                    <script>
                        const gfc = document.getElementById('grafico1');
                        let info = <?php echo json_encode($kwh_lidos); ?>;
                        let data = <?php echo json_encode($data_leitura); ?>;
                        new Chart(gfc, {
                        type: 'line',
                        label: ["Gastos"],
                        data: {
                            labels: data,
                            datasets: [{
                            label: ["Gastos"],
                            data: info,
                            borderColor: '#7bd798',
                            backgroundColor: '#7bd798',
                            barThickness: 160
                        }]
                        },
                            options: {
                            responsive: true,
                        }
                        });
                    </script>

                <?php } ?>
                
            <?php else: ?>

                <?php
                
                echo 
                "

                <br>

                <div class='erro'>
                    
                <h1>⛔ ERRO: Setor não encontrado dentro do banco.</h1> <br>

                <h2>Retorne aos setores clicando <a href='estrutura_medidores.php'>AQUI</a></h2>

                </div>

                "; 
                
                ?>

            <?php endif;?>

            </div>
        </div>
        <script>
            document.querySelectorAll('.contador').forEach(el => {
                const final = parseFloat(el.innerText);
                const casasDecimais = el.innerText.includes('.') ? 2 : 0;
                
                let atual = 0;
                const passo = final / 75;

                const timer = setInterval(() => {
                    atual += passo;

                    if (atual >= final) {
                        el.innerText = final.toFixed(casasDecimais);
                        clearInterval(timer);
                    } else {
                        el.innerText = atual.toFixed(casasDecimais);
                    }
                }, 20);
            });
        </script>
    </body>
</html>