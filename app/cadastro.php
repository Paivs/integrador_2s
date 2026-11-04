<?php
    
    require_once __DIR__ . '/init.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form action="" method="POST">
        <label for="nome">Nome da bancada:</label>
        <br>
        <input type="text" name="nome" id="nome" required>
        <br>


        <label for="descricao">Escreva uma descrição da bancada</label>
        <br>
        <textarea name="descricao" id="descricao" required></textarea>
        <br>
        <label for="nome">Será para quantas pessoas?</label>
        <br>
        <input type="number" name="quantidade" id="quantidade">
        <br>


        <p>Digite em forma listada as vantagens para aparecer no card:</p>


        <ol>
            <li><input type="text" name="vantagem2" placeholder="Ex: Arduino e sensores..."></li>
            <li><input type="text" name="vantagem3" placeholder="Ex: Pc's e notebooks..."></li>
        </ol>


        <p>Digite o valor por hora:</p>


        <label for="valorHora">R$:</label>
        <input type="number" name="valorHora" id="valorHora" step="0.50" placeholder="Use virgula ao digitar"required>
        
        <br>
        <br>


        <label for="imagem">Escolha uma imagem:</label>
        <input type="file" id="imagem" name="imagem" accept="image/*">


        <button type="submit">Registrar</button>


    </form>


</body>
</html>