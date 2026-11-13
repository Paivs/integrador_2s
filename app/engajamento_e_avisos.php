<?php
    require_once __DIR__ . '/init.php';
    
?>

<html>
<head>
    <link rel="stylesheet" href="./css/styleEngajaAvisos.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title>Engajamento e avisos</title>
</head>

<body>
    <div class="menu-conf">
        <?php require_once __DIR__ . "/menuLateral.php" ?>
        <div class="conteudo">
            
        <h2>Engajamento e Avisos</h2>
            
        <div class="supremo"><div class="card">
                
                <center><h2>Setor Mais Verde do Mês</h2>
                <br>
                <p>Lab. de Química 02</p>
                <p>Bloco C</p>
                <p>1° Andar</p></center>
                <br>
                <p>Dentro da Meta</p>
                <br>
                <p>graphic</p>
                <br>
                <p>Consumo Atual</p>
                <p>200KWH de 300KWH</p>
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
            <form action="">
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
                <button type="button">Enviar</button>    
            </form></div>

            <div class="card3">
                <center><h2>Frase do dia</h2></center>
            <br>
            <center><p>Cuidar do planeta começa no nosso interruptor. Ao apagar uma luz ou tirar um aparelho da tomada, você economiza dinheiro e preserva os recursos naturais.<br><br>
        Economizar energia é um gesto simples que gera um futuro mais sustentável para todos.</p></div></center>
    </div>
    </div>
    <div class="ranking"><center><table>
    <h2>Ranking de Consumo do Setor</h2>
    <tr class="ranking_cabaca">
        <th>Pos.</th>
        <th>Ambiente/Sala</th>
        <th>Consumo</th>
        <th>Status de Meta</th>
    </tr>
    <tr>
        <td class="normal">1</td>
        <td class="normal">Lab. de Química 02</td>
        <td class="normal">2.394.2 KWh</td>
        <td class="status">Excedido -8%</td>
    </tr>
    <tr>
        <td class="normal">2</td>
        <td class="normal">Lab. de Química 01</td>
        <td class="normal">1.424.5 KWh</td>
        <td class="status">Atenção</td>
    </tr> 
    <tr>
        <td class="normal">3</td>
        <td class="normal">Refeitório</td>
        <td class="normal">1.100.2 KWh</td>
        <td class="status">Dentro da Meta</td>
    </tr>
    <tr>
        <td class="normal">4</td>
        <td class="normal">Administração</td>
        <td class="normal">1.036.8 KWh</td>
        <td class="status">Dentro da Meta</td>
    </tr>
</table>
</div>
</center>

</div>

</div>

</body>
</html>