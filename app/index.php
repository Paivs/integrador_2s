<?php

declare(strict_types=1);

$databaseStatus = 'Conectado';

try {
    require_once __DIR__ . '/init.php';
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    $databaseStatus = 'Indisponível';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Makerlab</title>
  <link rel="stylesheet" href="./css/index.css">
</head>
<body>
  <?php require_once __DIR__ . '/nav.php' ?>
  <section class="hero">
    <div class="hero-conteudo">
      <div class="hero-texto">
        <h1>Transforme Suas Ideias<br>em <span>Realidade</span></h1>
        <p>
          Um espaço maker completo com prototipagem 3D, corte a laser,
          usinagem CNC e bancadas de eletrônica. Tudo isso na palma da sua mão.
        </p>
        <a href="#" class="botao">Reserve conosco →</a>
      </div>
    </div>
    <span class="marca"><img src="./img/cabecalho/logo.png" alt=""></span>
  </section>
  <br>
  <br>
  <br>
  <br>
  
</body><section class="sobre">
  <div class="sobre-conteudo">

    <div class="sobre-imagem">
      <img src="https://placehold.co/620x462" alt="Laboratório Makerlab">
    </div>

    <div class="sobre-lado">
      <p class="sobre-texto">
        Um ecossistema completo onde ideias abstratas ganham forma.
        Nosso MakerLab foi projetado para impulsionar a criatividade,
        acelerar a prototipagem e transformar projetos em soluções reais.
      </p>

      <div class="areas">
        <div class="area">
          <img src="https://placehold.co/90x90" alt="Eletrônica e Robótica">
          <p>Eletrônica &amp;<br>Robótica</p>
        </div>
        <div class="area">
          <img src="https://placehold.co/90x90" alt="Prototipagem 3D">
          <p>Prototipagem<br>3D</p>
        </div>
        <div class="area">
          <img src="https://placehold.co/90x90" alt="Corte e Usinagem">
          <p>Corte &amp;<br>Usinagem</p>
        </div>
        <div class="area">
          <img src="https://placehold.co/90x90" alt="Bancadas Multiuso">
          <p>Bancadas<br>Multiuso</p>
        </div>
      </div>
    </div>

  </div>
</section>
<br>
<br>
<br>
<section class="reservar">
  <div class="reservar-conteudo">
    <h2 class="reservar-titulo">COMO RESERVAR?</h2>

    <div class="passos">

  <div class="passo-intro">
    <h3>Reserve em 3 passos!</h3>
    <p>É simples, rápido, seguro e em poucos passos você reserva seu espaço.</p>
  </div>

  <div class="passo">
    <img src="https://placehold.co/57x57" alt="Passo 1" class="icone-passo">
    <h3>Busque o espaço</h3>
    <p>Encontre a bancada ou equipamento perfeito para seu projeto</p>
  </div>

  <div class="passo">
    <img src="https://placehold.co/57x57" alt="Passo 2" class="icone-passo">
    <h3>Escolha os horários disponíveis</h3>
    <p>Verifique a disponibilidade e confirme a reserva.</p>
  </div>

  <div class="passo">
    <img src="https://placehold.co/57x57" alt="Passo 3" class="icone-passo">
    <h3>Pronto!</h3>
    <p>Receba a confirmação e aproveite o seu espaço</p>
  </div>
</div>
  </div>
</section>
<?php require_once __DIR__ . '/footer.php' ?>
</html>