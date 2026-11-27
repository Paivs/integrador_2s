<?php

// Cadastrar novos funcionarios e ver suas avaliações

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Novo Eletricista</title>
    <link rel="stylesheet" href="styleIndicacaoAdmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="layout-principal">
        <aside class="barra-menu">
            <a href="index.php" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeca">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item active">
                    <i></i>
                    <span>Novo Eletricista</span>
                </a>
                <a href="infoEle.php" class="nav-item">
                    <i></i>
                    <span>Informações dos Eletricistas</span>
                </a>
            </nav>
        </aside>

        <main>
            <header>
                <h1>CADASTRAR NOVO ELETRICISTA</h1>
            </header>

            <div id="formulario">
                <form action="" method="POST" id="formCadastro">

                    <h2>DADOS DO ELETRICISTA</h2>

                    <label for="nome" class="passo-um">Nome:</label>
                    <input type="text" name="nome" id="nome" placeholder="Nome completo" required>

                    <label for="idade" class="passo-um">Idade:</label>
                    <input type="number" name="idade" id="idade" min="18" max="100" placeholder="Ex.: 30" required>

                    <label for="especializacao" class="passo-um">Especialização:</label>
                    <input type="text" name="especializacao" id="especializacao" placeholder="Ex.: Instalações residenciais" required>

                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>