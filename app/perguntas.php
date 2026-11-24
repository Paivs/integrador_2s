<?php
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['usuario_logado']) \vert{}\vert{}$_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

$categorias = [
    'geral' => [
        'titulo' => 'Geral',
        'itens' => [
            [
                'p' => 'O que é energia fotovoltaica?',
                'r' => 'É a eletricidade gerada a partir da luz do sol através de células fotovoltaicas presentes nos painéis solares. Quando a luz incide sobre essas células, cria um fluxo de eletrões que produz energia limpa e renovável.'
            ],
            [
                'p' => 'Qual a diferença entre energia solar fotovoltaica e térmica?',
                'r' => 'A energia fotovoltaica converte a luz solar diretamente em eletricidade para alimentar eletrodomésticos e lâmpadas. A energia térmica utiliza o calor do sol apenas para aquecer água (como nos banhos e piscinas).'
            ],
            [
                'p' => 'O sistema funciona em dias nublados ou de chuva?',
                'r' => 'Sim. Embora a produção diminua devido à menor incidência directa de radiação, os painéis continuam a gerar energia através da radiação difusa presente na atmosfera.'
            ],
            [
                'p' => 'O que acontece à noite quando não há sol?',
                'r' => 'À noite o sistema entra em repouso. O teu imóvel passa a consumir automaticamente a energia fornecida pela rede elétrica tradicional (ou de baterias, caso tenhas um sistema com armazenamento).'
            ],
            [
                'p' => 'Qual a diferença entre o sistema On-Grid e Off-Grid?',
                'r' => 'O sistema On-Grid funciona ligado à rede elétrica pública (permitindo gerar créditos de energia). O sistema Off-Grid é totalmente isolado e armazena a energia excedente em baterias para uso posterior.'
            ],
        ]
    ],
    'instalacao' => [
        'titulo' => 'Instalação e Requisitos',
        'itens' => [
            [
                'p' => 'Qualquer telhado pode receber painéis solares?',
                'r' => 'A grande maioria dos telhados pode receber a instalação, desde que a estrutura de suporte esteja em bom estado e o local não tenha sombreamento excessivo. Fazemos uma avaliação técnica prévia para garantir a viabilidade.'
            ],
            [
                'p' => 'Quanto tempo demora a instalação física do sistema?',
                'r' => 'Para a maioria dos projetos residenciais, a instalação dos painéis e do inversor demora entre 1 e 3 dias úteis.'
            ],
            [
                'p' => 'Preciso de autorização da distribuidora para instalar?',
                'r' => 'Sim. Todo o sistema ligado à rede precisa de ser homologado junto da distribuidora de energia local. A equipa da Solar Control trata de todo este processo burocrático por ti.'
            ],
            [
                'p' => 'O que acontece se houver um corte de energia na rede pública?',
                'r' => 'Em sistemas On-Grid normais, o inversor desliga-se automaticamente por motivos de segurança (sistema anti-ilhamento), evitando eletrocutar os técnicos que trabalham na manutenção da rede pública.'
            ],
        ]
    ],
    'economia' => [
        'titulo' => 'Economia e Financeiro',
        'itens' => [
            [
                'p' => 'Quanto posso poupar na minha fatura de eletricidade?',
                'r' => 'É possível reduzir até 95% do valor da tua fatura de energia, ficando responsável apenas pelo pagamento das taxas mínimas de disponibilidade e impostos obrigatórios da rede.'
            ],
            [
                'p' => 'Qual é o tempo médio de retorno do investimento?',
                'r' => 'O retorno financeiro ocorre geralmente entre 3 e 6 anos, dependendo do valor da tarifa local e do consumo do imóvel.'
            ],
            [
                'p' => 'O que são os créditos de energia solar?',
                'r' => 'Quando o teu sistema produz mais energia do que aquela que consomes durante o dia, o excesso é injetado na rede elétrica e transformado em créditos que podes abater no consumo noturno ou em meses futuros.'
            ],
            [
                'p' => 'Posso transferir os meus créditos de energia para outro imóvel?',
                'r' => 'Sim, desde que o outro imóvel esteja registado sob o mesmo titular (CPF/CNPJ) e dentro da área de cobertura da mesma distribuidora de energia.'
            ],
            [
                'p' => 'A instalação do sistema solar valoriza o imóvel?',
                'r' => 'Sim. Estudos do setor imobiliário indicam que imóveis com produção própria de energia limpa valorizam em média entre 10% e 15% no mercado.'
            ],
        ]
    ],
    'manutencao' => [
        'titulo' => 'Manutenção e Garantia',
        'itens' => [
            [
                'p' => 'Qual é a vida útil dos painéis solares?',
                'r' => 'Os painéis solares têm uma vida útil superior a 25 a 30 anos, mantendo mais de 80% da sua eficiência de geração original ao fim desse período.'
            ],
            [
                'p' => 'Que tipo de manutenção o sistema exige?',
                'r' => 'A manutenção é simples e reduzida. Consiste maioritariamente na limpeza periódica das placas com água (duas vezes por ano ou conforme a acumulação de poeiras/folhas) e numa inspeção elétrica anual.'
            ],
            [
                'p' => 'Qual é a garantia dos equipamentos?',
                'r' => 'Os painéis solares contam com garantia de eficiência de 25 anos. Os inversores possuem garantia de fabrico que varia entre 5 e 10 anos (com possibilidade de extensão).'
            ],
            [
                'p' => 'O que acontece se houver tempestades fortes ou granizo?',
                'r' => 'Os painéis solares são fabricados com vidro temperado de alta resistência, projetados e testados para suportar tempestades, ventos fortes e impactos de granizo severos.'
            ],
        ]
    ],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FAQ - SolarControl</title>
  <link rel="stylesheet" href="CSS/perguntas.css">
</head>
<body>
  <?php include __DIR__ . '/menu.php'; ?>

  <main class="conteudo">
    <div class="container">
      <header class="cabecalho">
        <h1>Perguntas Frequentes</h1>
        <p>Encontre respostas rápidas sobre energia solar, instalação, economia e manutenção.</p>
      </header>

      <!-- Barra de busca e filtros -->
      <section class="painel-box controles-faq">
        <div class="busca-wrapper">
          <input
            type="search"
            id="buscaFaq"
            placeholder="Buscar dúvida (ex: chuva, créditos, garantia, telhado...)"
            aria-label="Buscar perguntas frequentes"
          >
          <button type="button" id="btnExpandir" class="btn-secundario">Expandir todas</button>
        </div>

        <div class="filtros" role="tablist" aria-label="Filtrar por categoria">
          <button type="button" class="filtro ativo" data-categoria="todas">Todas</button>
          <?php foreach ($categorias as $chave =>$cat): ?>
            <button type="button" class="filtro" data-categoria="<?php echo htmlspecialchars($chave); ?>">
              <?php echo htmlspecialchars($cat['titulo']); ?>
            </button>
          <?php endforeach; ?>
        </div>

        <p class="contador-resultados" id="contadorResultados"></p>
      </section>

      <!-- Lista de categorias e perguntas -->
      <div id="listaFaq">
        <?php foreach ($categorias as $chave =>$cat): ?>
          <section class="painel-box card-categoria" data-categoria="<?php echo htmlspecialchars($chave); ?>">
            <div class="categoria-topo">
              <h2><?php echo htmlspecialchars($cat['titulo']); ?></h2>
              <span class="badge"><?php echo count($cat['itens']); ?> perguntas</span>
            </div>

            <div class="lista-perguntas">
              <?php foreach ($cat['itens'] as$item): ?>
                <details class="faq-item">
                  <summary><?php echo htmlspecialchars($item['p']); ?></summary>
                  <div class="faq-resposta">
                    <p><?php echo htmlspecialchars($item['r']); ?></p>
                    <div class="feedback">
                      <span>Esta resposta foi útil?</span>
                      <button type="button" class="btn-feedback" data-voto="sim">Sim</button>
                      <button type="button" class="btn-feedback" data-voto="nao">Não</button>
                    </div>
                  </div>
                </details>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endforeach; ?>
      </div>

      <!-- Mensagem quando a busca não encontra resultados -->
      <div class="painel-box vazio-box" id="semResultados" hidden>
        <p>Nenhuma pergunta encontrada para a sua busca.</p>
        <button type="button" id="btnLimparBusca" class="btn-secundario">Limpar filtros</button>
      </div>
    </div>
  </main>

  <script>
    const inputBusca = document.getElementById('buscaFaq');
    const botoesFiltro = document.querySelectorAll('.filtro');
    const secoes = document.querySelectorAll('.card-categoria');
    const todosItens = document.querySelectorAll('.faq-item');
    const contador = document.getElementById('contadorResultados');
    const semResultados = document.getElementById('semResultados');
    const btnExpandir = document.getElementById('btnExpandir');
    const btnLimparBusca = document.getElementById('btnLimparBusca');

    let categoriaAtiva = 'todas';
    let tudoExpandido = false;

    function normalizar(texto) {
      return texto.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function aplicarFiltros() {
      const termo = normalizar(inputBusca.value.trim());
      let visiveisTotal = 0;

      secoes.forEach((secao) => {
        const catSecao = secao.dataset.categoria;
        const correspondeCategoria = categoriaAtiva === 'todas' || catSecao === categoriaAtiva;
        let visiveisSecao = 0;

        secao.querySelectorAll('.faq-item').forEach((item) => {
          const texto = normalizar(item.textContent);
          const mostrar = correspondeCategoria && (termo === '' || texto.includes(termo));
          item.hidden = !mostrar;

          if (mostrar) {
            visiveisSecao++;
            visiveisTotal++;
            if (termo !== '') item.open = true;
          }
        });

        secao.hidden = visiveisSecao === 0;
      });

      semResultados.hidden = visiveisTotal > 0;
      contador.textContent = visiveisTotal === 1
        ? '1 pergunta encontrada'
        : `${visiveisTotal} perguntas encontradas`;
    }

    inputBusca.addEventListener('input', aplicarFiltros);

    botoesFiltro.forEach((btn) => {
      btn.addEventListener('click', () => {
        botoesFiltro.forEach((b) => b.classList.remove('ativo'));
        btn.classList.add('ativo');
        categoriaAtiva = btn.dataset.categoria;
        aplicarFiltros();
      });
    });

    btnExpandir.addEventListener('click', () => {
      tudoExpandido = !tudoExpandido;
      todosItens.forEach((item) => {
        if (!item.hidden) item.open = tudoExpandido;
      });
      btnExpandir.textContent = tudoExpandido ? 'Recolher todas' : 'Expandir todas';
    });

    btnLimparBusca.addEventListener('click', () => {
      inputBusca.value = '';
      categoriaAtiva = 'todas';
      botoesFiltro.forEach((b) => b.classList.toggle('ativo', b.dataset.categoria === 'todas'));
      todosItens.forEach((item) => (item.open = false));
      tudoExpandido = false;
      btnExpandir.textContent = 'Expandir todas';
      aplicarFiltros();
    });

    document.querySelectorAll('.btn-feedback').forEach((btn) => {
      btn.addEventListener('click', () => {
        const box = btn.closest('.feedback');
        const msg = btn.dataset.voto === 'sim'
          ? 'Obrigado pelo feedback!'
          : 'Obrigado! Vamos melhorar esta resposta.';
        box.innerHTML = `<span class="feedback-obrigado">${msg}</span>`;
      });
    });

    aplicarFiltros();
  </script>
</body>
</html>
