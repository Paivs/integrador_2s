<?php

// dashboard com o que precisa ser feito no dia(suas demandas)

?><!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Dashboard</title>
    <link rel="stylesheet" href="styleIndexAdmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="layout-principal">
        <aside class="barra-menu">
            <a href="index.php" class="logo.png" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item active">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item">
                    <i></i>
                    <span>Novo Eletricista</span>
                </a>
                <a href="infoEle.php" class="nav-item">
                    <i></i>
                    <span>Informações dos Eletricistas</span>
                </a>
            </nav>
        </aside>

        <div class="conteudo">

            <!-- 1) BEM-VINDO -->
            <header class="caixa-bem-vindo">
                <div class="bem-vindo-texto">
                    <h2>Bem-vindo, Administrador!</h2>
                    <p>Veja o que precisa ser feito hoje e acompanhe suas demandas.</p>
                </div>
                <a href="acompanhamento.php" class="botao-principal">Ver acompanhamento</a>
            </header>

            <!-- 2) TRÊS CAIXAS PRINCIPAIS -->
            <section class="principais-info">
                <a href="acompanhamento.php" class="caixa-principal">
                    <div class="caixa-dados">
                        <strong>6</strong>
                        <span>Demandas de hoje</span>
                    </div>
                    <i class="seta"></i>
                </a>
                <a href="acompanhamento.php" class="caixa-principal">
                    <div class="caixa-dados">
                        <strong>18</strong>
                        <span>Em acompanhamento</span>
                    </div>
                    <i class="seta"></i>
                </a>
                <a href="indicacao.php" class="caixa-principal">
                    <div class="caixa-dados">
                        <strong>3</strong>
                        <span>Relatos</span>
                    </div>
                    <i class="seta"></i>
                </a>
            </section>

            <!-- 3) PRÓXIMAS AULAS / DEMANDAS -->
            <section class="caixa-lista">
                <div class="lista-topo">
                    <h3>Próximas demandas</h3>
                </div>

                <div class="lista-itens">
                    <a href="#" class="item-lista">
                        <div class="item-texto">
                            <strong>Lorem ipsum dolor</strong>
                            <span>Sit amet consectetur</span>
                        </div>
                        <i class="seta"></i>
                    </a>
                    <a href="#" class="item-lista">
                        <div class="item-texto">
                            <strong>Lorem ipsum dolor</strong>
                            <span>Sit amet consectetur</span>
                        </div>
                        <i class="seta"></i>
                    </a>
                    <a href="#" class="item-lista">
                        <div class="item-texto">
                            <strong>Lorem ipsum dolor</strong>
                            <span>Sit amet consectetur</span>
                        </div>
                        <i class="seta"></i>
                    </a>
                </div>
            </section>

        </div>
    </div>
</body>
</html>
