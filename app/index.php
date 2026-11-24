<?php
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
  header('Location: login.php');
  exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Projeto Integrador</title>
  <link rel="stylesheet" href="CSS/index.css">
</head>

<body>
  <?php include __DIR__ . '/menu.php'; ?>

  <main class="conteudo">
    <h1>Visão geral</h1>
    <p>Acompanhe os principais indicadores da sua instalação.</p>

    <section class="indicadores" aria-label="Indicadores principais">
      <article class="indicador card">
        <p class="letrasCard"><span>Geração hoje</span></p>
        <strong>19,5<small>kWh</small></strong>
        <p>Previsto até agora: 21,7 kWh · dia inteiro: 34,0 kWh</p>
      </article>

      <article class="indicador card">
        <p class="letrasCard"><span>Geração no mês</span></p>
        <strong>366<small>kWh</small></strong>
        <p><span class="negativo">-9,1%</span> em relação a 1–13 de outubro</p>
      </article>

      <article class="indicador card">
        <p class="letrasCard"><span>Economia no mês</span></p>
        <strong>R$ 336,71</strong>
        <p class="prescricao"><span>366 kWh × R$ 0,92 · consumo do mês: 283 kWh</span></p>
      </article>

      <article class="indicador card">
        <p class="letrasCard"><span>Desempenho</span></p>
        <strong>89,9<small>%</small></strong>
        <p><span class="negativo">−8,2 p.p.</span> desde a limpeza de 03/10</p>
        <div class="progresso" aria-hidden="true"><i style="width: 89.9%"></i></div>
      </article>
    </section>


    <section class="resumo-simples" aria-label="Informações gerais do sistema">
      <article class="indicador card card-grande">
        <p class="letrasCard"><span>Status do Sistema</span></p>
        <strong class="positivo">Online</strong>
        <p>Inversor sincronizado e operando normalmente com a rede.</p>
      </article>

      <article class="indicador card card-grande">
        <p class="letrasCard"><span>Última Manutenção</span></p>
        <strong>03/10/2026</strong>
        <p>Próxima limpeza preventiva recomendada para 03/01/2027.</p>
      </article>

      <article class="indicador card card-grande">
        <p class="letrasCard"><span>Potência Instalada</span></p>
        <strong>5,4<small>kWp</small></strong>
        <p>12 módulos fotovoltaicos ativos · Tarifa atual: R$ 0,92/kWh.</p>
      </article>

      <article class="indicador card card-grande">
        <p class="letrasCard"><span>Geração nos últimos meses (kWh)</span></p>
        <div class="mini-grafico" role="img" aria-label="Gráfico de geração dos últimos 4 meses">
          <div class="coluna">
            <small>310</small>
            <div class="barra-box">
              <div class="barra" style="height: 75%;"></div>
            </div>
            <span>Jul</span>
          </div>
          <div class="coluna">
            <small>345</small>
            <div class="barra-box">
              <div class="barra" style="height: 85%;"></div>
            </div>
            <span>Ago</span>
          </div>
          <div class="coluna">
            <small>390</small>
            <div class="barra-box">
              <div class="barra" style="height: 95%;"></div>
            </div>
            <span>Set</span>
          </div>
          <div class="coluna">
            <small>366</small>
            <div class="barra-box">
              <div class="barra ativa" style="height: 88%;"></div>
            </div>
            <span>Out</span>
          </div>
        </div>
      </article>
    </section>

  </main>

  <footer class="rodape">
    <div class="rodape-marca">
      <span class="rodape-nome">SolarControl</span>
      <span class="rodape-copy">© 2026 by Solar Control</span>
    </div>

    <div class="rodape-creditos">
      <span>© Copyright 2026</span>
      <span>|</span>
      <span>Desenvolvido por: <strong>Solar Control</strong></span>
    </div>
  </footer>
</body>

</html>