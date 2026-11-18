<?php
    require_once __DIR__ . "/banco/crud.php"; 
    require_once __DIR__ . "/banco/database.php"; 
    require_once __DIR__ . "/locais.php";

    $user = $_GET['user'] ?? $_POST['user'] ?? '';
    $materias = readAll(database(), "materias");
    $area = readAll(database(), "area_conhecimento");
    $grupo = readAll(database(), "grupos_estudos");

    $dadosUser = database()->prepare('
    SELECT * FROM usuarios WHERE nome_usuario = :user');
    $dadosUser->execute(['user' => $user]);

    $usuario = $dadosUser->fetch(PDO::FETCH_ASSOC);

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $area = $_POST['area'];
        $materia = $_POST['materias'];
        $ambiente = $_POST['ambiente'];
        $nome_sala = $_POST['nome_sala'];
        $status = $_POST['status'];
        $senha = $_POST['senha'];
        $criador = $_POST['criador'];
        $data = $_POST['data'];

        $materiasPorArea = [
        "Exatas"            => ["Matemática", "Física", "Química"],
        "Ciências Naturais" => ["Biologia", "Geologia", "Astronomia", "Ecologia"],
        "Ciências Humanas"  => ["História", "Geografia", "Filosofia", "Sociologia"],
        "Linguagens"        => ["Língua Português", "Língua Estrangeiras", "Literatura"]
        ];

        if(!isset($_POST['ambiente']) || $_POST['ambiente'] == "" ||
        !isset($_POST['nome_sala']) || $_POST['nome_sala'] == "" ||
        !isset($_POST['area']) || $_POST['area'] == "" ||
        !isset($_POST['materias']) || $_POST['materias'] == "" ||
        !isset($_POST['status']) || $_POST['status'] == ""){
            header("Location: criarsala.php?user=" . urlencode($user) . "&erro=" . urlencode("Espaço vazio"));
            exit;
        }

        if($_POST['status'] == "privado" && $_POST['senha'] == ""){
            header("Location: criarsala.php?user=" . urlencode($user) . "&erro=" . urlencode("Espaço vazio"));
            exit;
        }

        if(strlen($_POST['senha']) > 20){
            header("Location: criarsala.php?user=" . urlencode($user) . "&erro=" . urlencode("Senha grande demais (máx. 20)"));
            exit;
        }

        if (!empty($materia) && !in_array($materia, $materiasPorArea[$area] ?? [], true)){
            header("Location: criarsala.php?user=" . urlencode($user) . "&erro=" . urlencode("A máteria selecionada não faz parte dessa área de conhecimento"));
            exit;
        }

        if($_POST['status'] == "publico" && $_POST['senha'] != ""){
            header("Location: criarsala.php?user=" . urlencode($user) . "&erro=" . urlencode("Só é possível cadastrar uma senha caso o grupo seja privado"));
            exit;
        }

        create(database(), "grupos_estudos", [
            "nome_grupo" => $nome_sala,
            "data_criacao" => $data,
            "nome_area" => $area,
            "nome_materia" => $materia,
            "senha" => $senha,
            "status_grupo" => $status,
            "id_imagem" => $ambiente,
            "criador" => $criador,
        ]);
        header("selecionar-sala.php?user=<?= $user ?>");
        exit;
    }


?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudyMatch</title>
    <link rel="stylesheet" href="css/criarsala.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arima:wght@100..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="cabecalho">
        <div class="img-cabecalho"><a href="homeperfil.php?user=<?= $user ?>"><img src="imgs/logo.png" alt=""></a></div>
        <nav>
            <ul>
                <li><a href="selecionar-sala.php?user=<?= $user ?>">
                        <p>Grupos de Estudo</p>
                    </a></li>
                <li><a href="login.php">
                        <p>Social</p>
                    </a></li>
                <li><a href="login.php">
                        <p>Progresso</p>
                    </a></li>
            </ul>
        </nav>
        <a href="perfil.php?user=<?= $user ?>"><div class="fotoConta"></div></a>
        </div>
    </div>

    <div class="bloco1">
    <p>Crie sua própria sala de estudos!</p>
    </div>


<div class="principal">
    <div class="form">

<form class="form2" method="post">
    <input type="hidden" name="user" value="<?= htmlspecialchars($user) ?>">
        <p>Escolha um ambiente:</p>

        <div class="caixa1">

            <div class="card">
            <img src="<?= $locais['1']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="1">
            </div>

            <div class="card">
            <img src="<?= $locais['2']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="2">
            </div>

            <div class="card">
            <img src="<?= $locais['3']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="3">
            </div>

        </div>
  

        <div class="caixa2">

            <div class="card">
            <img src="<?= $locais['4']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="4">
            </div>

            <div class="card">
            <img src="<?= $locais['5']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="5">
            </div>

            <div class="card">
            <img src="<?= $locais['6']?>" alt="Imagem" width="400">
            <input type="radio" class="checkbox" name="ambiente" value="6">
            </div>

       </div>

    <p>Preencha as informações a seguir:</p>

        <div class="campos">
    
            <input type="text" name="nome_sala" placeholder="Nome da sala">
            <input type="text" name="criador" value="<?= htmlspecialchars($usuario['nome_usuario'] ?? '') ?>" readonly> 
            <input type="date" name="data" value="<?= date('Y-m-d') ?>" readonly>
            <select name="area">
                <option value="">Área de conhecimento</option>
                <?php foreach($area as $a): ?>
                    <option value="<?= $a['nome_area'] ?>">
                    <?= $a['nome_area'] ?>
                </option>
                <?php endforeach; ?>
            </select>
            <select name="materias">
                <option value="">Matérias</option>
                <?php foreach($materias as $m): ?>
                <option value="<?= $m['nome_materia'] ?>">
                <?= $m['nome_materia'] ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
            <div class="status">
            <label><input type="radio" class="checkbox" name="status" value="privado">Privado</label>
            <label><input type="radio" class="checkbox" name="status" value="publico">Público</label>
            </div>
            <div class="campos">
            <input type="password" name="senha" placeholder="Senha da sala (Privado)"></div>
    </div>
            <div class="erro">
                <?php
                if(isset($_GET['erro']) && $_GET['erro'] != ""){
                    echo "<p>{$_GET['erro']}</p>";
                }
                ?>
            </div>

            <button type="submit" class="button">Criar Sala</button>
</form>


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