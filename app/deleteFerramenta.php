<?php

    require_once __DIR__ . "/init.php";

    $bancadas = readAll($pdo, "Bancadas");

    if (isset($_SESSION['id'])) {
            $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
            if($userAtual['perfil'] != "admin" || !isset($userAtual)){
                header("Location: index.php");
                exit;
            }
        }else{
            header("Location: index.php");
            exit;
        };

    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
        $ferramentaSelecionada = readAll($pdo, "Ferramentas", "id_ferramenta = {$_GET['id']}");
        $idFerramenta = $_GET['id'];

        if ($ferramentaSelecionada == false) {
            print("<p>Bancada não reconhecida</p>");
            exit;
        }

    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $idFerramenta = $_POST['idFerramenta'];  
        update(database(), "Ferramentas", ["status_ferramenta" => "indisponivel"],"id_ferramenta={$idFerramenta}");
        header("Location: dashboard.php");
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


    <?php if (!empty($erros)): ?>
        <div class="erros">
            <p>Corrija os campos abaixo:</p>
            <ul>
                <?php foreach ($erros as $mensagem): ?>
                    <li><?= ($mensagem) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="" method="POST">

        <?php foreach($ferramentaSelecionada as $campoDaFerramenta): ?>

            <input type="hidden" name="idFerramenta" value="<?= $idFerramenta ?>">

            <label for="nome">Nome da ferramenta:</label>
            <br>
            <input type="text" name="nomeFerramenta" id="nomeFerramenta" value="<?= $campoDaFerramenta['nome_ferramenta']?>" readonly>
            <br>
        
            <label for="area">Escreva a área da bancada:</label>
            <br>
            <input type="text" name="area" id="area" value="<?= $campoDaFerramenta['area']?>" readonly>
            
            <br>
        
            <label for="valorEstoque">Quantos temos em estoque?:</label>
            <br>
            <input type="number" name="valorEstoque" id="valorEstoque" step="1" value="<?= $campoDaFerramenta['estoque']?>" readonly>
            
            <br>
            
            <p>De qual bancada ela pertence?</p>
        
            <select name="bancada" disabled>

            <?php foreach ($bancadas as $b): ?>

                <option value="<?= $b['id_bancada'] ?>"
                    <?= $campoDaFerramenta['id_bancada'] == $b['id_bancada'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($b['nome_bancada']) ?>
                </option>

            <?php endforeach; ?>

            </select>

                
            <br>
            <br>
        
            <button type="submit">Deletar</button>

        <?php endforeach ?>


    </form>



    
</body>
</html>
    
