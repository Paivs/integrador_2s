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
    <title>MakerLab - Deletar Bancada</title>
    <link rel="stylesheet" href="css/navAdm.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
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

    <main class="conteudo pagina-formulario">

        <h1 class="titulo-formulario">Deletar Bancada</h1>

        <form class="formulario" action="" method="POST">
            <input type="hidden" name="id" value="<?= $idBancada ?>">

            <div class="coluna">
                <label class="rotulo">Nome da bancada:</label>
                <input class="campo" value="<?= $bancadaAtual['nome_bancada'] ?>" readonly>

                <label class="rotulo">Quantidade de pessoas:</label>
                <input class="campo campo-numero" value="<?= $bancadaAtual['quantidade_bancada'] ?>" readonly>

                <p class="rotulo">Vantagens da bancada:</p>
                <ol class="lista-vantagens">
                    <li><input class="campo" value="<?= $bancadaAtual['primeira_vantagem'] ?>" readonly></li>
                    <li><input class="campo" value="<?= $bancadaAtual['segunda_vantagem'] ?>" readonly></li>
                </ol>

                <label class="rotulo">Área da bancada:</label>
                <input class="campo" value="<?= $bancadaAtual['area_bancada'] ?>" readonly>
            </div>

            <div class="coluna">
                <label class="rotulo">Descrição:</label>
                <textarea class="campo campo-descricao" readonly><?= $bancadaAtual['descricao_bancada'] ?></textarea>

                <p class="rotulo">Valor por hora:</p>
                <div class="linha-valor">
                    <label class="rotulo-valor">R$:</label>
                    <input class="campo campo-numero" value="<?= $bancadaAtual['preco_bancada'] ?>" readonly>
                </div>

                <label class="rotulo">Status da bancada:</label>
                <input class="campo" value="<?= $bancadaAtual['status_bancada'] ?>" readonly>

                <label class="rotulo">Link da imagem:</label>
                <input class="campo campo-imagem" value="<?= $bancadaAtual['imagens_bancada'] ?>" readonly>

                <button class="botao-registrar botao-deletar" type="submit">Deletar Bancada</button>
            </div>

        </form>
    </main>  
</body>
</html>
