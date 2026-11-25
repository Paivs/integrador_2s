<?php
    require_once __DIR__ . '/init.php';
    $nomeSetores = [];

    $setores = readAll(database(), 'setor');
    foreach($setores as $s){
        $nome = $s['nome'];
        $nomeSetores[] = $nome;
    }
    $setoresA = readAll(database(), 'setor', "estado_setor = 'Ativo'");
    $por = count($setores) * 0.8;
    $por2 = count($setores) * 0.5;
    if(count($setoresA) >= $por){
        $aviso = "🟢";
    }else if(count($setoresA) >= $por2){
        $aviso = "🟡";
    }else{
        $aviso = "🔴";
    }
    $ambientesSetorA = readAll(database(), "ambientes", "setor_id = 1");
    $ambientesSetorB = readAll(database(), "ambientes", "setor_id = 2");
    $metas = readAll(database(), "metas");
    $somaA = 0;
    $somaB = 0;

    $nomeSetores = [];
    foreach($setores as $s){
        $nome = $s['nome'];
        $nomeSetores[] = $nome;
    }
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
    $somaLista = [$somaA, $somaB];
    $somaListaReais = [];
    foreach($somaLista as $soma){
        $somaM = $soma * 0.8;
        $somaListaReais[] = $somaM;
    }
    $somaAreais = $somaA / 0.8;
    $somaBreais = $somaB / 0.8;
    $somaTR = $somaAreais + $somaBreais;

    $leituras = readAll(database(), "leituras");
    $leiturasSetorA = [];
    $leiturasSetorB = [];
    foreach($leituras as $l){
        if($l['ambiente_id'] == 1){
            $leiturasSetorA[] = $l;
        }else if($l['ambiente_id'] == 2){
            $leiturasSetorB[] = $l;
        }
    }
    $somaLeiturasA = 0;
    $somaLeiturasB = 0;
    foreach($leiturasSetorA as $la){
        $somaLeiturasA += $la['leitura_acumulada_kwh'];
    }
    foreach($leiturasSetorB as $lb){
        $somaLeiturasB += $lb['leitura_acumulada_kwh'];
    }
    $somaLeituras = $somaLeiturasA + $somaLeiturasB;
    $somaLeiturasReais = $somaLeituras * 0.8;

    $porcentagem = ($somaLeiturasReais / $somaTR) * 100;
    if($porcentagem <= 60){
        $alerta = "🟢";
    }else if($porcentagem <= 40){
        $alerta = "🟡";
    }else{
        $alerta = "🔴";
}
?>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/styleDashboard.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
</head>

<body>
    <div class="menu-conf">
        <?php require_once __DIR__ . "/menuLateral.php" ?>
        <div class="conteudo">
        <div class="tituloD">
        <h1>DashBoard</h1>
        </div>


        <div class="infoJ">
        <div class="info">
                <div class="info-cont">
                    <img src="./img/EstruturaMedidores.png" alt="">
                    <p><b><?php print(count($setores)); ?></b></p>
                    <h1>Setores Registrados</h1>
                </div>
        </div>
        <div class="info">
                <div class="info-cont">
                    <img src="./img/Gasto.png" width="75px">
                    <p><b>R$<?php print(number_format($somaTR, 2, ',', '.')); ?></b></p>
                    <h1>Gasto Total</h1>
                </div>
        </div>
        <div class="info">
                <div class="info-cont">
                    <img src="./img/LançamentoDados.png" alt="">
                    <p><b><?= number_format($somaLeiturasReais, 2, ',', '.') ?></b></p>
                    <h1>KWH GASTOS</h1>
                </div>
        </div>
        </div>

        <div class="infoJ">
        <div class="info2">
        <h1> <?php print(count($setoresA)); ?> / <?php print(count($setores)); ?> SETORES ATIVOS <?php print($aviso) ?></h1>
        </div>

        <div class="info2">
        <h2>Meta P/ Gasto: <?= number_format($porcentagem, 2, ',', '.') ?>% <?= $alerta ?></h2>
        </div>

        </div>


        <div class="infoJ">
        <div class="info3">
            <h1>Gastos p/ Meta</h1>
            <p>Nos últimos meses</p>
            <div>
                <canvas id="grafico3"></canvas>
            </div>
        </div>







        <div class="info3">
            <h1>Gasto P/ Setor</h1>
            <p>Em R$</p>
            <div class="graficoinfo3">
            <canvas id="grafico1"></canvas>
            </div>
        </div>
        </div>

        <div class="info3B">
            <h1>Comparação de Gastos</h1>
            <div class="graficoinfo3B">
            <canvas id="grafico2"></canvas>
        </div>
        </div>

        <div class="infoJ">
        <div class="info2">
            <h1 class="cor">PAGAMENTOS PENDENTES: 0 🟢</h1>
        </div>

        <div class="info2">
            <h2>QUANTIA DISPONÍVEL: R$ 84.461.322,82</h2>
        </div>

        <div class="info2">
            <style>
                .cor{
                    color: #ffff;
                }
                .cor2{
                    color: #ffde59;
                }
            </style>
            <h1 style="margin-top: 17px;" class="cor2">KWH GASTOS: <?= number_format($somaLeituras, 2, ',', '.') ?></h1>
        </div>

        </div>        



    </div>
    </div>
<script>
        const ctx = document.getElementById('grafico1').getContext('2d');
        const ctx2 = document.getElementById('grafico2').getContext('2d');
        const ctx3 = document.getElementById('grafico3').getContext('2d');
        let setores = <?php print(json_encode($nomeSetores)); ?>;
        let somaReaisA = <?php print(json_encode($somaAreais)); ?>;
        let somaReaisB = <?php print(json_encode($somaBreais)); ?>;
        let somakhwr = <?php print(json_encode($somaLeiturasReais)); ?>;
        let somaTR = <?php print(json_encode($somaTR)); ?>;
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: setores,
        datasets: [
          {
            label: "Gastos",
            data: [somaReaisA, somaReaisB],
            backgroundColor: '#00e667',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65,
          },
        ],
        options: {
            responsive: true,
        }
      },
    });
    new Chart(ctx2, {
      type: 'doughnut',
      data: {
        labels: setores,
        datasets: [
          {
            label: "Gastos",
            data: [somaReaisA, somaReaisB],
            backgroundColor: ['#00e667', '#ffffff'],
            barPercentage: 0.85,
            categoryPercentage: 0.65,
          },
        ],
        options: {
            responsive: true,
        }
      },
    });
    new Chart(ctx3, {
      type: 'line',
      data: {
        labels: ['Julho','Agosto', 'Setembro', 'Outubro', 'Novembro'],
        datasets: [
          {
            label: "Gastos",
            data: [32, 12, 43, 22, somakhwr],
            backgroundColor: ['#ffde59'],
            barPercentage: 0.85,
            categoryPercentage: 0.65,
            borderColor: '#ffde59',
            
          },
          {
            label: "Meta",
            data: [35, 15, 31, 58, somaTR],
            backgroundColor: ['#00ff73'],
            barPercentage: 0.85,
            categoryPercentage: 0.65,
            borderColor: '#00ff73',
            
          },
        ],
        options: {
            responsive: true,
        }
      },
    });

    
</script>
</body>
</html>