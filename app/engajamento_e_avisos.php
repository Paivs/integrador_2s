<?php
    require_once __DIR__ . '/init.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $mensagem = "Relatório de Problema enviado!";
    }
    $setores = readAll(database(), "setor");
    $ambientesSetorA = readAll(database(), "ambientes", "setor_id = 1");
    $ambientesSetorB = readAll(database(), "ambientes", "setor_id = 2");
    $metas = readAll(database(), "metas");
    $somaA = 0;
    $somaB = 0;
    $somaLista = [$somaA, $somaB];
    $somaListaReais = [];
    foreach($somaLista as $soma){
        $somaM = $soma * 0.8;
        $somaListaReais[] = $somaM;
    }
    $somaAreais = $somaA / 0.8;
    $somaBreais = $somaB / 0.8;
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
    if ($somaA > $somaB) {
        $setorMaisVerde = $nomeSetores[0];
    } else {
        $setorMaisVerde = $nomeSetores[1];
    }

?>

<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="./css/styleEngajaAvisos.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title class="tituloE">Engajamento e avisos</title>
</head>

<body>
    <div class="menu-conf">
        <?php require_once __DIR__ . "/menuLateral.php" ?>
        <div class="conteudo">
            
        <h2>Engajamento e Avisos</h2>
            
        <div class="supremo"><div class="card">
                
                <h2>Setor Mais Verde do Mês</h2>
                <br>
                <center>
                <p><b><?= $setorMaisVerde?></b></p>
                </center>
                <br>
                <p>Dentro da Meta</p>
                <br>
                <canvas id="grafico"></canvas>
                <br>
                <center>
                <p><b>Consumo Atual</b></p>
                <p><b><?php echo print($somaB); ?> KWh de <?php  print($somaB * 0.8); ?> KWh</b></p>
            </center>
                <br>
                <p><h3>Dicas para esta sala:</h3></p>
                <p>° Desligue a Capela ao encerramento</p>
                <p>° Apague as luzes ao sair da sala</p>
                <p>° Mantenha o ar condicionado em uma única temperatura</p>
            </div>
            <br>
            <br>
            <div class="card2-3">
           
            <div class="card2">
            <form action="" method="post">
                <center><h1>Relatar Problemas nas Sala</h1></center>

                <br>
                <p>Seu Setor de Trabalho</p>
                <input type="text">
                <br>
                <br>
                <p>Seu Bloco - Andar e Sala</p>
                <input type="text">
                <br>
                <br>
                <p>Qual o Problema Relatado</p>
                <input type="text">
                <br>
                <br>
                <button class="botao" type="submit">Enviar</button>
                 <?php if(isset($mensagem)): ?>
                    <p><?php print($mensagem); ?></p>
                <?php endif; ?>  
            </form></div>


            <div class="card3">
                <center><h2>Frase do dia</h2></center>
            <br>
            <center><p>Cuidar do planeta começa no nosso interruptor. Ao apagar uma luz ou tirar um aparelho da tomada, você economiza dinheiro e preserva os recursos naturais.<br><br>
        Economizar energia é um gesto simples que gera um futuro mais sustentável para todos.</p></div></center>
    </div>
    </div>
    <div class="ranking"><center>
    <table>
    <h2>Ranking de Consumo do Setor</h2>
    <tr>
        <th>Pos.</th>
        <th>Ambiente/Sala</th>
        <th>Área</th>
        <th>Status de Meta</th>
    </tr>
    <?php foreach($ambientesSetorB as $ambiente): ?>
    <tr>
        <td class="num"><?= $ambiente['id'] ?></td>
        <td class="num"><?= $ambiente['nome'] ?></td>
        <td class="num"><?= $ambiente['area_m2'] ?> m2</td>
        <td class="num">Dentro da Meta</td>
    </tr>
    <?php endforeach ?>

</table>
</div>
</center>

</div>

</div>
<script>
    const ctx = document.getElementById('grafico').getContext('2d');
    let nomesetor = <?php echo json_encode($setorMaisVerde); ?>;
    let metakwh = <?php echo json_encode($somaB); ?>;
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [nomesetor],
        datasets: [
          {
            label: 'GASTO',
            data: [metakwh* 0.8],
            backgroundColor: '#fde068',
            borderRadius: 4,
            barPercentage: 0.85,
            categoryPercentage: 0.65
          },
          {
            label: 'META',
            data: [metakwh],
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