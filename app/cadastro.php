<?php
    
    require_once __DIR__ . '/init.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $nomeBancadaPost = trim($_POST['nomeBancada'] ?? '');
        $descricaoBancadaPost = trim($_POST['descricao'] ?? '');
        $numeroPessoasPost = trim($_POST['quantidade'] ?? '');
        $primeiraVantagem = trim($_POST['vantagem1'] ?? '');
        $segundaVantagem = trim($_POST['vantagem2'] ?? '');

        if (empty($nomeBancadaPost) || empty($descricaoBancadaPost) || empty($numeroPessoasPost) || empty($primeiraVantagem) || empty($segundaVantagem)) {
            header("Location: cadastro.php?erro=preenchimentoInvalido");
            exit;
        }

        if (!is_numeric($numeroPessoasPost) || $numeroPessoasPost <= 0) {
            header("Location: cadastro.php?erro=bancadaInvalida");
            exit;
        }



    }


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
        <input type="text" name="nomeBancada" id="nomeBancada" required>
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
            <li><input type="text" name="vantagem1" placeholder="Ex: Arduino e sensores..."></li>
            <li><input type="text" name="vantagem2" placeholder="Ex: Pc's e notebooks..."></li>
        </ol>


        <p>Digite o valor por hora:</p>


        <label for="valorHora">R$:</label>
        <input type="number" name="valorHora" id="valorHora" step="0.50" placeholder="Use virgula ao digitar"required>
        
        <br>
        <br>


        <label for="imagem">Escolha uma imagem:</label>
        <input type="file" id="imagem" name="imagem" accept="image/png, image/jpeg" required>


        <button type="submit">Registrar</button>

        <?php
        
            if (isset($_GET['erro'])) {
                $erros = ['preenchimentoInvalido', 'bancadaInvalida'];

                foreach ($erros as $erro) {
                    if ($_GET['erro'] === $erro) {
                        echo "<p>Erro: $erro</p>";
                    }
                }

            }
        
        ?>


    </form>


</body>
</html>