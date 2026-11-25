<?php


?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GameHub</title>

  
  <link rel="stylesheet" href="./css/criarTorneio.css">
</head>
<body>

    <?php require_once __DIR__ . '/cabecalho.php' ?>

  <main class="pagina">

   
    <section class="intro">
      <h2>Crie seu <span>torneio</span></h2>
      <p>As equipes podem se inscrever assim que você publicar.</p>
    </section>

    <form class="formulario" action="criar_torneio.php" method="post" enctype="multipart/form-data">

     
      <fieldset class="bloco">
        <legend>Informações</legend>

        <div class="campo">
          <label for="nome">Nome do torneio</label>
          <input type="text" id="nome" name="nome" placeholder="Ex.: Meu torneio" maxlength="60" required>
        </div>

        <div class="campo">
          <label for="descricao">Descrição</label>
          <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o seu campeonato!" maxlength="400"></textarea>
        </div>
      </fieldset>

      
      <fieldset class="bloco bloco--jogos">
        <legend>Jogo</legend>

        <div class="jogos">
          <input type="radio" name="jogo" id="jogo-valorant" value="valorant" required>
          <label for="jogo-valorant" class="jogo jogo--valorant">Valorant</label>

          <input type="radio" name="jogo" id="jogo-rocket" value="rocket-league">
          <label for="jogo-rocket" class="jogo jogo--rocket">Rocket League</label>

          <input type="radio" name="jogo" id="jogo-cs2" value="cs2">
          <label for="jogo-cs2" class="jogo jogo--cs2">Counter-Strike 2</label>

          <input type="radio" name="jogo" id="jogo-fc27" value="fc27">
          <label for="jogo-fc27" class="jogo jogo--fc">EA FC 27</label>

          <input type="radio" name="jogo" id="jogo-fortnite" value="fortnite">
          <label for="jogo-fortnite" class="jogo jogo--fortnite">Fortnite</label>

          <input type="radio" name="jogo" id="jogo-siege" value="r6-siege">
          <label for="jogo-siege" class="jogo jogo--siege">Rainbow Six Siege</label>

          <input type="radio" name="jogo" id="jogo-lol" value="lol">
          <label for="jogo-lol" class="jogo jogo--lol">League of Legends</label>
        </div>
      </fieldset>

      <fieldset class="bloco">
        <legend>Formato de equipe</legend>

        <div class="formatos">
          <input type="radio" name="formato" id="formato-eliminatoria" value="eliminatoria" checked>
          <label for="formato-eliminatoria" class="formato">
            <strong>Eliminatória</strong>
            <span>Quem perde está fora, chaveamento até a final.</span>
          </label>

          <input type="radio" name="formato" id="formato-pontos" value="pontos-corridos">
          <label for="formato-pontos" class="formato">
            <strong>Pontos corridos</strong>
            <span>Todos jogam contra todos, vence quem somar mais pontos.</span>
          </label>
        </div>

        <div class="grade grade--2">
          <div class="campo">
            <label for="equipes">Número de equipes</label>
            <select id="equipes" name="equipes" required>
              <option value="" disabled selected>Selecione</option>
              <option value="4">4 equipes</option>
              <option value="8">8 equipes</option>
              <option value="16">16 equipes</option>
              <option value="32">32 equipes</option>
            </select>
          </div>

          <div class="campo">
            <label for="jogadores">Jogadores por equipe</label>
            <input type="number" id="jogadores" name="jogadores" min="1" max="10" value="5" required>
          </div>
        </div>
      </fieldset>

      
      <fieldset class="bloco">
        <legend>Data e premiação</legend>

        <div class="grade grade--3">
          <div class="campo">
            <label for="data">Data</label>
            <input type="date" id="data" name="data" required>
          </div>

          <div class="campo">
            <label for="hora">Início</label>
            <input type="time" id="hora" name="hora" required>
          </div>

          <div class="campo">
            <label for="premio">Premiação (R$)</label>
            <input type="number" id="premio" name="premio" min="0" step="50" placeholder="10000">
          </div>
        </div>

        <div class="campo">
          <label for="inscricao">Inscrições até</label>
          <input type="date" id="inscricao" name="inscricao_ate">
        </div>
      </fieldset>

      
      <fieldset class="bloco">
        <legend>Regras</legend>

        <div class="campo">
          <label for="regras">Regulamento</label>
          <textarea id="regras" name="regras" rows="6" placeholder="Escreva as regras, critérios de desempate e proibições."></textarea>
        </div>
      </fieldset>

      <fieldset class="bloco">
        <legend>Capa do torneio</legend>

        <div class="campo">
          <label for="capa">Imagem de capa</label>
          <label for="capa" class="upload">
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 16V4m0 0L7 9m5-5l5 5M4 20h16"/>
            </svg>
            <span>Escolha uma imagem</span>
            <small></small>
          </label>
          <input type="file" id="capa" name="capa" accept="image/png, image/jpeg">
        </div>

        <div class="visibilidade">
          <input type="radio" name="visibilidade" id="vis-publico" value="publico" checked>
          <label for="vis-publico">Público</label>

          <input type="radio" name="visibilidade" id="vis-privado" value="privado">
          <label for="vis-privado">Somente com convite</label>
        </div>
      </fieldset>

      <div class="acoes">
        <a class="botao botao--secundario" href="torneios.php">Cancelar</a>
        <button class="botao" type="submit">Publicar torneio</button>
      </div>

    </form>
</main>

<?php require_once __DIR__ . '/rodape.php' ?>

</body>
</html>