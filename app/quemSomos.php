<?php

require_once __DIR__ . '/init.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Makerlab - Quem Somos</title>
    <link rel="stylesheet" href="./css/quemSomos.css">
</head>

<body>
    <?php require_once __DIR__ . '/nav.php' ?>

    <section class="hero-sobre">
        <div class="hero-conteudo">
            <div class="hero-texto">
                <h1>Quem <span>Somos</span></h1>
                <p>
                    Somos um espaço maker aberto a estudantes, pesquisadores e criadores
                    que querem tirar suas ideias do papel.
                </p>
            </div>
        </div>
    </section>

    <section class="historia">
        <div class="historia-conteudo">
            <div class="historia-imagem">
                <img src="./img/index/logoAZUL.png" alt="Laboratório Makerlab">
            </div>

            <div class="historia-lado">
                <h2>Nossa história</h2>
                <p>
                    O MakerLab nasceu da dificuldade que muitos estudantes enfrentam para
                    prototipar: faltam equipamentos, espaço e lugar para testar. Reunimos
                    em um só ambiente bancadas de eletrônica, impressão 3D, marcenaria,
                    corte a laser e muito mais, com reserva simples e feita por hora.
                </p>
                <p>
                    Hoje o laboratório recebe alunos de diversas instituições de ensino
                    e é um ponto de encontro entre quem quer aprender, construir e
                    compartilhar conhecimento.
                </p>
            </div>
        </div>
    </section>

    <section class="valores">
        <div class="valores-conteudo">
            <h2 class="valores-titulo">NOSSOS PRINCÍPIOS</h2>

            <div class="cards-valores">
                <div class="card-valor">
                    <h3>Missão</h3>
                    <p>Democratizar o acesso a ferramentas de criação, para que qualquer pessoa possa transformar uma ideia em um protótipo real.</p>
                </div>

                <div class="card-valor">
                    <h3>Visão</h3>
                    <p>Ser a principal referência em espaço maker colaborativo, reconhecido pela qualidade da estrutura e pelo estímulo à inovação.</p>
                </div>

                <div class="card-valor">
                    <h3>Valores</h3>
                    <p>Criatividade, colaboração, segurança, sustentabilidade e aprendizado contínuo em cada projeto que passa por aqui.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="numeros">
        <div class="numeros-conteudo">
            <div class="numero">
                <h3>8</h3>
                <p>Bancadas especializadas</p>
            </div>
            <div class="numero">
                <h3>+500</h3>
                <p>Projetos realizados</p>
            </div>
            <div class="numero">
                <h3>+1.200</h3>
                <p>Horas reservadas</p>
            </div>
            <div class="numero">
                <h3>10</h3>
                <p>Instituições parceiras</p>
            </div>
        </div>
    </section>

    <section class="diferenciais">
        <div class="diferenciais-conteudo">
            <h2 class="diferenciais-titulo">O QUE OFERECEMOS</h2>

            <div class="areas">
                <div class="area">
                    <img src="./img/index/arduino.png" alt="Eletrônica e Robótica">
                    <p>Eletrônica &amp;<br>Robótica</p>
                </div>
                <div class="area">
                    <img src="./img/index/impressora.png" alt="Prototipagem 3D">
                    <p>Prototipagem<br>3D</p>
                </div>
                <div class="area">
                    <img src="./img/index/bancada.png" alt="Corte e Usinagem">
                    <p>Corte &amp;<br>Usinagem</p>
                </div>
                <div class="area">
                    <img src="./img/index/bancadaMadeira.png" alt="Bancadas Multiuso">
                    <p>Bancadas<br>Multiuso</p>
                </div>
            </div>
        </div>
    </section>

    <section class="chamada">
        <h2>Pronto para criar o seu projeto?</h2>
        <p>Escolha uma bancada e reserve seu horário em poucos cliques.</p>
        <a href="./reservas.php" class="botao">Reserve conosco →</a>
    </section>

    <?php require_once __DIR__ . '/footer.php' ?>
</body>

</html>