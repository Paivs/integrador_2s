<?php
    require_once __DIR__ . "/init.php";
    $setores = readAll(database(), "setor");
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
    $somaTR = [$somaAreais, $somaBreais];
    $contador2 = 0;
?>
<html>
    
    <head>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <div class="rankingGastosConteudo">
                        <canvas id="grafico1"></canvas>
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
                            <h3><?= $contador ?>. <?= $setor["nome"]?>- <?php if($contador == 1):?><?= $somaTR[0] ?><?php else: ?><?= $somaTR[1] ?><?php endif ?></h3>
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
                        <div class="rankingGastosConteudo">
                            <canvas id="grafico2"></canvas>
                        </div>
                    </div>
                    
                    <div class="rankingGastosTabela">
                        <div class="rankingGastosTabelaConteudo">
                            <h1>Meta</h1>
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
                                <?php elseif ($setor['estado_setor' == 'Interferência']): ?>
                                <h2><?= $setor['nome'] ?> 🟡</h2>
                                <?php else: ?>
                                <h2><?= $setor['nome'] ?> 🔴</h2>
                                <?php endif ?>
                            </div>
                            <?php endforeach ?>
                        </div>

                        <div class="tabelasJuntas">


                            <?php foreach($setores as $s): $contador2 += 1?>
                            <div class="lucro">
                                <center>    
                                
                                    <h2>Lucro - <?= $s['nome'] ?></h2>
                                    <canvas id="<?= $s['nome'] ?>" height="300"></canvas>
                                    <h3>Gasto: </h3>
                                    <h3>Meta: R$ <?php if($contador2 == 1): ?><?= print($somaAreais) ?><?php elseif($contador2 == 2): ?><?= print($somaBreais) ?><?php endif ?></h3>
                                </center>
                            </div>
                            <?php endforeach ?>
                        </div>
            </div>
        </div>
        
        <script>
        let setores = <?php echo json_encode($nomeSetores); ?>;
        let somametakwh = <?php echo json_encode($somaLista); ?>;
        let somareais = <?php echo json_encode($somaListaReais); ?>;
        let somaF = <?php echo json_encode($somaTR); ?>;
        const ctx = document.getElementById('grafico1').getContext('2d');

        new Chart(ctx, {
        type: 'bar',
        data: {
            labels: setores,
            datasets: [{
            label: 'Gasto',
            data: somaF,
            backgroundColor: '#7bd798',
            barThickness: 160
        }]
        },
            options: {
            responsive: true,

      }
    });
   const ctx2 = document.getElementById('grafico2');

    new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: setores,
        datasets: [
          {
            label: 'GASTO',
            data: somareais,
            backgroundColor: '#fde068',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          },
          {
            label: 'META',
            data: somametakwh,
            backgroundColor: '#00e667',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          }
        ]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: '#ffffff',
              usePointStyle: true,
              padding: 20
            }
          }
        },
        scales: {
          x: {
            grid: { color: '#2c3035' },
            ticks: {
              color: '#ffffff',
            }
          },
          y: {
            grid: { display: false },
            ticks: { color: '#ffffff' }
          }
        }
      }
    });

    const ctxblocoA = document.getElementById('Bloco A').getContext('2d');
    let metaAreais = <?php echo json_encode($somaAreais); ?>;
    new Chart(ctxblocoA, {
      type: 'bar',
      data: {
        labels: ['Bloco A'],
        datasets: [
          {
            label: 'GASTO',
            data: [metaAreais * 0.8],
            backgroundColor: '#fde068',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          },
          {
            label: 'META',
            data: [metaAreais],
            backgroundColor: '#00e667',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          }
        ]
      },
      options: {
        indexAxis: 'x',
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: '#ffffff',
              usePointStyle: true,
              padding: 20
            }
          }
        },
      }
    });



    const ctxblocoB = document.getElementById('Bloco B').getContext('2d');
    let metaBreais = <?php echo json_encode($somaBreais); ?>;
    new Chart(ctxblocoB, {
      type: 'bar',
      data: {
        labels: ['Bloco B'],
        datasets: [
          {
            label: 'GASTO',
            data: [metaBreais * 0.8],
            backgroundColor: '#fde068',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          },
          {
            label: 'META',
            data: [metaBreais],
            backgroundColor: '#00e667',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          }
        ]
      },
      options: {
        indexAxis: 'x',
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: '#ffffff',
              usePointStyle: true,
              padding: 20
            }
          }
        },
      }
    });
  </script>
    </body>
</html>