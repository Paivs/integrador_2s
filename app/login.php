<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SolarControl</title>
  <link rel="stylesheet" href="CSS/login.css">
</head>


<body>


  <main class="conteudo">


    <!-- Sol com os planetas -->
    <div class="sistema-solar" aria-hidden="true">
      <div class="anel"></div>
      <div class="anel media"></div>
      <div class="anel interna"></div>


      <div class="trajeto externo"><span></span></div>
      <div class="trajeto media"><span></span></div>
      <div class="trajeto interna"><span></span></div>


      <div class="sol"></div>
    </div>


    <!-- Formulário -->
    <div class="posicaoforms">
      <div class="logo">🪐 Solar<span>Control</span></div>
      <h2>Entrar</h2>
      <p class="sub">Bem-vindo de volta. Acesse o painel da sua usina.</p>


      <form method="post" class="formulario">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="nome@empresa.com" required>


        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" placeholder="••••••••" minlength="6" required>


        <div class="linha">
          <label><input type="checkbox" name="lembrar" checked> Lembrar-me</label>
          <a href="esqueci-senha.php">Esqueci a senha</a>
        </div>


        <button type="submit">Entrar</button>
      </form>


      <p class="sub centro">Não tem conta? <a href="cadastro.php">Criar conta</a></p>
    </div>


  </main>


</body>
</html>



