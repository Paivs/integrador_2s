<?php
declare(strict_types=1);

$databaseStatus = 'Conectado';

try {
    require_once __DIR__ . '/init.php';
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $databaseStatus = 'Indisponível';
}

$porDepartamento = [];

if ($databaseStatus === 'Conectado') {
    $sql = "SELECT u.nome,
                   TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) AS idade,
                   f.especializacao, f.foto, d.nome AS departamento
            FROM funcionarios f
            INNER JOIN usuarios u ON u.id = f.idUsuario
            INNER JOIN funcionario_departamentos fd ON fd.idFuncionario = f.idUsuario
            INNER JOIN departamentos d ON d.id = fd.idDepartamento
            ORDER BY d.nome, u.nome";

    foreach ($pdo->query($sql)->fetchAll() as $linha) {
        $porDepartamento[$linha['departamento']][] = $linha;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesClientes/styleIndicacao.css">
    <title>Indicação | ElectroSafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

</head>
<body>
     <aside class="barra-menu">
           <img src="imagens/logo.png" alt="Logo">
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span>
                        <span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong>
                    </span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item ">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="registro.php" class="nav-item">
                    <i></i>
                    <span>Registro de não conformidades</span>
                </a>
                <a href="analise.php" class="nav-item ">
                    <i></i>
                    <span>Análise técnica e inspeção</span>
                </a>
                <a href="checklist.php" class="nav-item">
                    <i></i>
                    <span>Checklist</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item active ">
                    <i></i>
                    <span>Indicação</span>
                </a>
            </nav>
        </aside>

    


    <main>
        <header>
        <h1>Nossos Melhores Profissionais ao seu dispor!</h1>
        </header>
    <div id="principal">
        <div class="areas">
                <h2>Eletricistas Residenciais disponiveis</h2>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele1.png" alt="" class="foto-ele">
                </div>
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele2.png" alt="" class="foto-ele">
                </div>  
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele3.png" alt="" class="foto-ele">
                </div>
            </div>

             <div class="areas">
                <h2>Eletricistas Comerciais disponiveis</h2>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele4.png" alt="" class="foto-ele">
                </div>
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele5.png" alt="" class="foto-ele">
                </div>  
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele6.png" alt="" class="foto-ele">
                </div>
            </div>


             <div class="areas">
                <h2>Eletricistas Industriais disponiveis</h2>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele7.png" alt="" class="foto-ele">
                </div>
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele8.png" alt="" class="foto-ele">
                </div>  
                    <hr>
                <div class="info-ele">
                    <div class="texto-ele">
                        <p>Nome</p>
                        <p>Idade</p>
                        <p>especializacao</p>
                    </div>
                    <img src="imagens/foto-ele9.png" alt="" class="foto-ele">
                </div>
            </div>
        </div>  
    </main>
    </div> 
    
    
</body>
</html>