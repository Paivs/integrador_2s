<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/init.php';

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/banco/database.php';   
require_once __DIR__ . '/banco/crud.php';   

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$novo_email = $_POST['novo_email'];
$novo_nome = $_POST['novo_nome'];
$email_atual = $_SESSION['email'];

$pdo = database(); 

    if (!empty($novo_email) && !empty($novo_nome) && !empty($email_atual)) {
        try {
       
            $sql = "UPDATE usuarios SET nome = :novo_nome, email = :novo_email WHERE email = :email_atual";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':novo_nome' => $novo_nome, ':novo_email' => $novo_email, ':email_atual' => $email_atual]);
            $_SESSION['email_usuario'] = $novo_email;

            header('Location: login.php');
            exit;

            
        } catch (PDOException $e) {
            $mensagem_erro = "Erro: " . $e->getMessage();
        }
    }
}

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Configurações — Solar Control</title>
  <link rel="stylesheet" href="CSS/config.css">
</head>

<body>
  <!-- MENU LATERAL -->
<body>
  <?php include __DIR__ . '/menu.php'; ?>


  <!-- CONTEÚDO -->
  <main class="conteudo">
    <header class="topo">
      <div>
        <span class="crumb">Ajustar</span>
        <h1>Configurações</h1>
      </div>

      <div class="topo-acoes">
        <a class="link-alertas" href="alerts.php">Alertas</a>

        <a class="avatar-topo" href="profile.php" aria-label="Abrir meu perfil">
          BB
        </a>
      </div>
    </header>

    <form method= "POST" class="cfg" aria-label="Configurações da plataforma">
      <!-- NAVEGAÇÃO DAS CONFIGURAÇÕES -->
      <nav class="cfg-nav card" aria-label="Seções das configurações">
        <a href="#perfil" class="aba-perfil">Perfil</a>
        <a href="#notificacoes" class="aba-notif">Notificações</a>
      </nav>

      <div class="cfg-conteudo">
        <!-- PERFIL -->
        <section id="perfil" class="cfg-sec card" aria-labelledby="titulo-perfil">
          <h2 id="titulo-perfil">Perfil</h2>
          <p class="desc">Como você aparece no Solar Control.</p>

          <div class="duas">
            <div>
              <label for="novo_nome">Nome</label>
              <input
                id="novo_nome"
                name="novo_nome"
                value="<?php echo $_SESSION['nome']; ?>"
                autocomplete="name"
              >
            </div>

            <div>
              <label for="novo_email">E-mail</label>
              <input
                id="novo_email"
                name="novo_email"
                type="email"
                value="<?php echo $_SESSION['email'];?>"
                autocomplete="email"
              >
            </div>
          </div>
        </section>  

        <!-- NOTIFICAÇÕES -->
        <section id="notificacoes" class="cfg-sec card" aria-labelledby="titulo-notificacoes">
          <h2 id="titulo-notificacoes">Notificações</h2>
          <p class="desc">Escolha como quer ser avisado.</p>

          <label class="opcao">
            <span>
              Alertas críticos por e-mail
              <small>Painel offline, falha de inversor</small>
            </span>

            <input type="checkbox" class="switch" name="alerta_email" checked>
          </label>

          <label class="opcao">
            <span>
              Notificações push
              <small>No navegador e no celular</small>
            </span>

            <input type="checkbox" class="switch" name="push" checked>
          </label>

          <label class="opcao">
            <span>
              Resumo semanal
              <small>Toda segunda, às 08:00</small>
            </span>

            <input type="checkbox" class="switch" name="resumo">
          </label>

          <label class="opcao">
            <span>
              Lembrete de limpeza
              <small>Quando a eficiência cair mais de 10%</small>
            </span>

            <input type="checkbox" class="switch" name="limpeza">
          </label>
        </section>

        <!-- BOTÕES -->
        <div class="acoes">
          <button type="reset" class="btn-ghost">
            Cancelar
          </button>

          <button type="submit" class="btn-verde" aria-describedby="aviso-salvar">
            Salvar alterações
          </button>
        </div>

        <p class="aviso" id="aviso-salvar">
          <?php echo $mensagem_erro ?>
        </p>
      </div>
    </form>
  </main>
</body>

</html>