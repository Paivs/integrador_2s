<?php   
    require_once __DIR__ . "/init.php";

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

   
    $bancadaAtual = [];
    
    if(!isset( $_GET['id']) || $_GET['id'] == null){
        print("<p>Bancada não reconhecida</p>");
        }
        

    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
        $idBancada = $_GET['id'];  
        $bancadaAtual = read(database(), "Bancadas", "id_bancada={$idBancada}");
        if ($bancadaAtual == null){
            print("<p>Bancada não reconhecida</p>");
            exit;
        }
    }  
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])){
        $idBancada = $_POST['id'];  
        update(database(), "Bancadas", ["status_bancada" => "indisponivel"],"id_bancada={$idBancada}");
        header("Location: dashboard.php");
    }


    

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Bancada</title>
    <link rel="stylesheet" href="css/navAdm.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body style="left: 50px;">
    <header>    
        
        <nav class="sidebar">
            <div class="sidebar-content">
                
                <div class="logo">
                    <a href="index.php"><img src="img/cabecalho/logo.png" alt=""></a>
                </div>
                
                <a href="./dashboard.php" class="item">
                    <img src="./img/icons/pen_branco.png" alt="" class="icone">
                    <span>Dashboard</span>
                </a>
                
                <a href="./adicionarFerramenta.php" class="item">
                    <img src="./img/icons/plus_branco.png" alt="" class="icone">
                    <span>Ferramenta</span>
                </a>
                
                <a href="./adicionarBancada.php" class="item ativo">
                    <img src="./img/icons/plus_roxo.png" alt="" class="icone">
                    <span>Bancada</span>
                </a>
                
                <a href="./historicoReservas.php" class="item">
                    <img src="./img/icons/folder_branco.png" alt="" class="icone">
                    <span>Reservas</span>
                </a>
            </div>
        </nav>
    </header>

    <main class="conteudo">
    <form action="" method="POST">
        <input type="text" name="id" value="<?= $idBancada?>" hidden>
        <?php //foreach($bancadaAtual as $chave => $chave): ?>

            <label>Nome da bancada:</label>
            <br>
            <input value="<?= $bancadaAtual['nome_bancada'] ?>" readonly>
            <br>

            <label for="descricao">Descrição:</label>
            <br>
            <textarea readonly><?= $bancadaAtual['descricao_bancada'] ?></textarea>
            <br>
            <label>Quantidade de pessoas:</label>
            <br>
            <input value="<?= $bancadaAtual['quantidade_bancada'] ?>" readonly>
            <br>
            <p>vantagens da bancada:</p>
            <ol>
                <li><input value="<?= $bancadaAtual['primeira_vantagem'] ?>" readonly></li>
                <li><input value="<?= $bancadaAtual['segunda_vantagem'] ?>" readonly></li>
            </ol>
            <label for="valorHora">R$:</label>
            <input value="<?= $bancadaAtual['preco_bancada'] ?>" readonly>
            <br>
            <label>Área da bancada:</label>
            <br>
            <input value="<?= $bancadaAtual['area_bancada'] ?>" readonly>
            <br>
            <p>EU NAO SEI COMO VAI FICAR A IMAGEM</p>
        <?php //endforeach;?>
        <button type="submit">Deletar Bancada</button>
    </form>
</main>   
</body>
</html>
