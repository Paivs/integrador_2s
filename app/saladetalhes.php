<?php
    require_once __DIR__ . "/banco/crud.php"; 
    require_once __DIR__ . "/banco/database.php";
    require_once __DIR__ . "/locais.php";

    $user = $_GET['user'];
    

    $grupos = readAll(database(), "grupos_estudos");
    $areaConhecimento = readAll(database(), "area_conhecimento");
    $materias = readAll(database(), "materias");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $gruposelecionado = $_POST['id'];
        $grupo = database()->prepare('
        SELECT * FROM grupos_estudos WHERE id_grupo = :id');
        $grupo->execute(['id' => $gruposelecionado]);
        $grupo = $grupo->fetch(PDO::FETCH_ASSOC);
    }

    //if($grupo['status_grupo'] == "privado"){
    //    if(empty($_POST['senha'])){
    //        header("Location: saladetalhes.php?user=" . urlencode($user) . "&erro=" . urlencode("Este grupo é privado, só é possível acessar com senha"));
    //        exit;
    //    }
    //    if($_POST['senha'] != $grupo['senha']){
    //        header("Location: saladetalhes.php?user=" . urlencode($user) . "&erro=" . urlencode("Senha incorreta"));
    //        exit;
    //    }
    //}
?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>StudyMatch</title>
        <link rel="stylesheet" href="css/saladetalhes.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Arima:wght@100..700&display=swap" rel="stylesheet">
    </head>
    <body>

        <div class="cabecalho">
        <div class="img-cabecalho"><a href="homeperfil.php"><img src="imgs/logo.png" alt=""></a></div>
        <nav>
            <ul>
                <li><a href="login.php">
                        <p>Matérias</p>
                    </a></li>
                <li><a href="login.php">
                        <p>Social</p>
                    </a></li>
                <li><a href="login.php">
                        <p>Progresso</p>
                    </a></li>
            </ul>
        </nav>
        <div class="fotoConta"><a href="perfil.php">
            </a></div>
    </div>






        <div class="titulo">
        <p>Você acessou o <?= $grupo['nome_grupo'] ?>!</p>
        <p>Confire as informações a seguir antes de entrar na sala.</p>
        </div>


    <div class="principal">
        <div class="bloco1">
            <img src="<?= $locais[$grupo['id_imagem']]?>" alt="Imagem" width="700" height="440">
            <div class="quebra">
                <div class="titulo2">
                <p><?= $grupo['nome_grupo'] ?></p>
                </div>
                <div class="info">
                <p>Área de conhecimento: <?= $grupo['nome_area'] ?></p>
                <p>Matéria: <?= $grupo['nome_materia'] ?></p>
                <p>Criador(a): <?= $grupo['criador'] ?></p>
                <p>Data de criação: <?= $grupo['data_criacao'] ?></p>
                <div class="status">
                    <label>
                        <input 
                            type="radio" 
                            name="status" 
                            value="privado"
                            disabled
                            <?= strtolower($grupo['status_grupo']) == 'privado' ? 'checked' : '' ?>
                        >
                        Privado
                    </label>

                    <label>
                        <input 
                            type="radio" 
                            name="status" 
                            value="publico"
                            disabled
                            <?= strtolower($grupo['status_grupo']) == 'publico' ? 'checked' : '' ?>
                        >
                        Público
                    </label>
                </div>
                </div>
            </div>
        </div>
        <div class="form">
            <form action="">
            <input type="password" name="senha" placeholder="Digite a senha fornecida pelo(a) criador(a):">
            <div class="erro">
                <?php
                if(isset($_GET['erro']) && $_GET['erro'] != ""){
                    echo "<p>{$_GET['erro']}</p>";
                }
                ?>
            </div>
            <button type="submit" class="button"><p>Entrar</p></button>
            </form>
        </div>
    </div>




    <div class="rodape">
        <div class="img-rodape"><a href="homelogin.php"><img src="/img-yasmin/logo.png" alt=""></a></div>
        <table cellpadding="3">
            <tr>
                <td><a href="materias.php"><p>Matérias</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="social.php"><p>Social</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="progresso.php"><p>Progresso</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="suporte.php"><p>Suporte</p></a></td>
            </tr>
            <tr>
                <td><a href="termos.php"><p>Termos</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="contato.php"><p>Contato</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="customizacao.php"><p>Customização</p></a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><a href="configuracao.php"><p>Configuração</p></a></td>
            </tr>
        </table>
        <div class="redesSociais">
            <nav>
                <ul>
                    <li><a href=""><img src="/img-yasmin/git.png" alt=""></a></li>
                    <li><a href=""><img src="/img-yasmin/insta.png" alt=""></a></li>
                </ul>
            </nav>
        </div>
        <p class="direitos">© 2026 StudyMatch - Todos os direitos reservados</p>
    </div>
</body>
</html>