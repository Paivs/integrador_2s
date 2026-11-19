<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de não conformidade | ELECTROSAFE</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Saira:wght@400;500;600;700&family=Saira+Condensed:wght@600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="stylesClientes/styleRegistro.css">
</head>
<body>
<aside class="barralateral">

<div class="cabecabarra">
    <div class="logo">
        <span>Electro<strong>Safe</strong></span>
    </div>
</div>

<nav class="nav">

    <a href="index.php" class="nav-item">
        <i></i>
        <span>Início</span>
    </a>

    <a href="registro.html" class="nav-item">
        <i></i>
        <span>Registro de não conformidades</span>
    </a>

    <a href="analise.php" class="nav-item">
        <i></i>
        <span>Análise técnica e inspeção</span>
    </a>

<a href="checklist.html" class="nav-item active">
        <i></i>
        <span>Checklist</span>
    </a>

<a href="acompanhamento.php" class="nav-item">
        <i></i>
        <span>Acompanhamento</span>
    </a>

<a href="indicacao.php" class="nav-item">
        <i></i>
        <span>Indicação</span>
    </a>

</nav>

</aside>

  <header class="topo">
    <div class="topo__marca">
      <h1 class="logo">ELECTROSAFE</h1>
      <p class="topo__sub">Sistema de inspeção elétrica</p>
    </div>
    <div class="topo__registro">
      <span class="topo__registro-rotulo">Registro nº</span>
      <span class="topo__registro-valor">Gerado ao salvar</span>
    </div>
  </header>

  <main class="conteudo">

    <section class="titulo-pagina">
      <h2>Registro de não conformidade</h2>
      <p>Preencha as informações abaixo para registrar uma ocorrência. Campos com <span class="obrigatorio" aria-hidden="true">*</span> são obrigatórios.</p>
    </section>

    <form class="formulario" action="registrar.php" method="post" enctype="multipart/form-data">

      <!-- Identificação -->
      <fieldset class="bloco">
        <legend>Identificação</legend>

        <div class="campo">
          <label for="data_ocorrencia">Data da ocorrência <span class="obrigatorio" aria-hidden="true">*</span></label>
          <input type="date" id="data_ocorrencia" name="data_ocorrencia" required>
        </div>

        <div class="campo">
          <label for="hora_ocorrencia">Hora aproximada</label>
          <input type="time" id="hora_ocorrencia" name="hora_ocorrencia">
        </div>

        <div class="campo campo--largo">
          <label for="responsavel">Responsável pelo registro <span class="obrigatorio" aria-hidden="true">*</span></label>
          <input type="text" id="responsavel" name="responsavel" placeholder="Nome completo" autocomplete="name" required>
        </div>
      </fieldset>

      <!-- Localização -->
      <fieldset class="bloco">
        <legend>Local e equipamento</legend>

        <div class="campo">
          <label for="local">Local da ocorrência <span class="obrigatorio" aria-hidden="true">*</span></label>
          <input type="text" id="local" name="local" placeholder="Ex.: Sala de máquinas, 2º andar" required>
        </div>

        <div class="campo">
          <label for="equipamento">Equipamento ou instalação <span class="obrigatorio" aria-hidden="true">*</span></label>
          <input type="text" id="equipamento" name="equipamento" placeholder="Ex.: Quadro elétrico QD-03" required>
        </div>
      </fieldset>

      <!-- Classificação -->
      <fieldset class="bloco">
        <legend>Classificação</legend>

        <div class="campo">
          <label for="tipo">Tipo de não conformidade <span class="obrigatorio" aria-hidden="true">*</span></label>
          <select id="tipo" name="tipo" required>
            <option value="" selected disabled>Selecione uma opção</option>
            <option value="aterramento">Aterramento e equipotencialização</option>
            <option value="condutores">Condutores e cabeamento</option>
            <option value="protecao">Dispositivos de proteção (disjuntores, DR, DPS)</option>
            <option value="quadro">Quadro de distribuição</option>
            <option value="conexoes">Conexões e terminais</option>
            <option value="sobrecarga">Sobrecarga ou aquecimento</option>
            <option value="iluminacao">Iluminação e tomadas</option>
            <option value="sinalizacao">Sinalização e identificação</option>
            <option value="epi">EPI, EPC e procedimentos de segurança</option>
            <option value="documentacao">Documentação e laudos</option>
            <option value="outro">Outro</option>
          </select>
        </div>

        <div class="campo">
          <label for="requisito">Norma ou requisito violado</label>
          <input type="text" id="requisito" name="requisito" placeholder="Ex.: ABNT NBR 5410, NR-10">
        </div>

        <fieldset class="campo campo--cheio grupo-risco">
          <legend>Nível de risco <span class="obrigatorio" aria-hidden="true">*</span></legend>
          <div class="opcoes-risco">
            <input type="radio" id="risco_baixo" name="risco" value="baixo" required>
            <label for="risco_baixo" class="chip chip--baixo">Baixo</label>

            <input type="radio" id="risco_medio" name="risco" value="medio">
            <label for="risco_medio" class="chip chip--medio">Médio</label>

            <input type="radio" id="risco_alto" name="risco" value="alto">
            <label for="risco_alto" class="chip chip--alto">Alto</label>

            <input type="radio" id="risco_critico" name="risco" value="critico">
            <label for="risco_critico" class="chip chip--critico">Crítico</label>
          </div>
          <p class="dica">Risco crítico: perigo iminente de choque, arco elétrico ou incêndio. Isole a área antes de registrar.</p>
        </fieldset>

        <div class="campo">
          <label for="status">Status inicial <span class="obrigatorio" aria-hidden="true">*</span></label>
          <select id="status" name="status" required>
            <option value="" selected disabled>Selecione o status</option>
            <option value="aberta">Aberta</option>
            <option value="analise">Em análise</option>
            <option value="tratamento">Em tratamento</option>
            <option value="aguardando">Aguardando material ou peça</option>
          </select>
        </div>
      </fieldset>

      <!-- Descrição -->
      <fieldset class="bloco">
        <legend>Descrição</legend>

        <div class="campo campo--cheio">
          <label for="descricao">Descrição da ocorrência <span class="obrigatorio" aria-hidden="true">*</span></label>
          <textarea id="descricao" name="descricao" rows="5" placeholder="Descreva o que foi encontrado, onde e em que condição." required></textarea>
        </div>

        <div class="campo campo--cheio">
          <label for="evidencias">Evidências (fotos)</label>
          <input type="file" id="evidencias" name="evidencias[]" accept="image/*" multiple>
        </div>
      </fieldset>

      <!-- Tratativa -->
      <fieldset class="bloco">
        <legend>Tratativa</legend>

        <div class="campo campo--cheio">
          <label for="contencao">Ação imediata de contenção</label>
          <textarea id="contencao" name="contencao" rows="3" placeholder="Ex.: circuito desenergizado e sinalizado."></textarea>
        </div>

        <div class="campo campo--cheio">
          <label for="acao">Ação recomendada / observações</label>
          <textarea id="acao" name="acao" rows="4" placeholder="Informe as ações recomendadas para corrigir a causa."></textarea>
        </div>

        <div class="campo">
          <label for="responsavel_acao">Responsável pela ação</label>
          <input type="text" id="responsavel_acao" name="responsavel_acao" placeholder="Nome ou equipe">
        </div>

        <div class="campo">
          <label for="prazo">Prazo para correção</label>
          <input type="date" id="prazo" name="prazo">
        </div>
      </fieldset>

      <div class="acoes">
        <button type="reset" class="botao botao--secundario">Limpar formulário</button>
        <button type="submit" class="botao botao--primario">Registrar ocorrência</button>
      </div>

    </form>
  </main>

  <footer class="rodape">
    <p>ELECTROSAFE &copy; 2026 &ndash; Segurança e confiabilidade</p>
  </footer>

</body>
</html>