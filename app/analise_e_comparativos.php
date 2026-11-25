<?php
$id = null;
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
}
    require_once __DIR__ . '/init.php';
    $setores = readAll(database(), "setor");
    $ambientesSetorA = readAll(database(), "ambientes", "setor_id = 1");
    $ambientesSetorB = readAll(database(), "ambientes", "setor_id = 2");
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
    $somaLista = [$somaA, $somaB];
    $somaListaReais = [];
    foreach($somaLista as $soma){
        $somaM = $soma * 0.8;
        $somaListaReais[] = $somaM;
    }
    $somaAreais = $somaA / 0.8;
    $somaBreais = $somaB / 0.8;
?>

<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/styleAnaliseE_Compara.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title>Análise e Comparativos</title>
</head>

<body>
    <div class="menu-conf"><?php require_once __DIR__ . "/menuLateral.php" ?>

        <div class="conteudo">
            <h2>Análise Histórica e Comparativos</h2>

                <div class="card">
                    <form action="" method="GET">
                        <select name="id" id="id">
                            <?php foreach ($setores as $setor): ?>
                            <option value="<?= $setor['id'] ?>"><?= $setor['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Filtrar</button>
                    </form>
                </div>

                <center><div class="graficos"><?php if($id == 1): ?> <canvas id="Bloco A"></canvas><?php else: ?> <canvas id="Bloco B"></canvas><?php endif; ?></div></center>

            <center>
                <div class="comparativo">
    <table class="ranking">
    <tr>
        <th>Pos.</th>
        <th>Ambiente/Sala</th>
        <th>Gasto</th>
        <th>Status de Meta</th>
    </tr>
    <?php if($id == 1): foreach($ambientesSetorA as $ambiente): ?>
    <tr>
        <td class="num"><?= $ambiente['id'] ?></td>
        <td class="num"><?= $ambiente['nome'] ?></td>
        <td class="num"><?= $ambiente['area_m2'] ?>.0 kwh</td>
        <td class="num">Dentro da Meta</td>
    </tr>
    <?php endforeach ?>
    <?php else: foreach($ambientesSetorB as $ambiente): ?>
    <tr>
        <td class="num"><?= $ambiente['id'] ?></td>
        <td class="num"><?= $ambiente['nome'] ?></td>
        <td class="num"><?= $ambiente['area_m2'] ?>.0 kwh</td>
        <td class="num">Dentro da Meta</td>
    </tr>
    <?php endforeach ?>
    <?php endif; ?>
                    </table>
                    

                </div>
            </center>
                
        </div>
        <script>
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
</script>
<script>


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