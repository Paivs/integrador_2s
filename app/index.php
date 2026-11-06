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

  <header class="header">
    <div class="header-conteudo">
      <a href="https://placehold.co" alt="" class="logo">LOGO AQ</a>
      <nav>
        <ul class="menu">
          <li><a href="">Início</a></li>

          <li class="tem-submenu">
            <a href="">Reservas ▾</a>
            <ul class="submenu">
              <li><a href="">Impressora 3D</a></li>
              <li><a href="">Corte a laser</a></li>
              <li><a href="">Usinagem CNC</a></li>
              <li><a href="">Bancada de eletrônica</a></li>
            </ul>
          </li>

          <li class="tem-submenu">
            <a href="">Vendas ▾</a>
            <ul class="submenu">
              <li><a href="">Peças impressas</a></li>
              <li><a href="">Componentes</a></li>
              <li><a href="">Kits</a></li>
            </ul>
          </li>

          <li><a href="">Quem Somos</a></li>
          <li><a href="">Tutoriais</a></li>
          <li><a href="">Projetos</a></li>
          <li><a href="">Administrador</a></li>
        </ul>
      </nav>
      <a href="" class="usuario">user</a>
    </div>
  </header>
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
    <span class="marca">Makerlab</span>
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

<footer class="footer">
  <div class="footer-conteudo">

    <div class="footer-marca">
      <img src="./img/cabecalho/logo.png" alt="Makerlab">
      <p>Espaços que impulsionam os seus projetos.</p>
    </div>

    <div class="footer-coluna">
      <h3>Início</h3>
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Salas</a></li>
        <li><a href="">Laboratórios</a></li>
        <li><a href="">Espaços de trabalho</a></li>
        <li><a href="">Sobre nós</a></li>
      </ul>
    </div>

    <div class="footer-coluna">
      <h3>Suporte</h3>
      <ul>
        <li><a href="">Central de Ajuda</a></li>
        <li><a href="">Termos de Uso</a></li>
        <li><a href="">Política de Privacidade</a></li>
        <li><a href="">Fale Conosco</a></li>
      </ul>
    </div>

    <div class="footer-novidades">
      <h3>Receba novidades</h3>
      <p>Cadastre o seu e-mail e fique por dentro de todas as nossas novidades!</p>
      <form class="form-novidades">
        <input type="email" placeholder="exemplo@email.com...">
        <button type="submit">❯</button>
      </form>
    </div>

  </div>

  <div class="footer-linha"></div>

  <div class="footer-baixo">
    <p>© 2026 MakerLab. Todos os direitos reservados.</p>
    <div class="redes">
      <a href=""><img src="https://placehold.co/50x50" alt="LinkedIn"></a>
      <a href=""><img src="https://placehold.co/50x50" alt="WhatsApp"></a>
      <a href=""><img src="https://placehold.co/50x50" alt="Instagram"></a>
    </div>
  </div>
</footer>
</html>