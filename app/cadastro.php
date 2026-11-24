<?php

require_once __DIR__ . '/banco/database.php';   
require_once __DIR__ . '/banco/crud.php';   

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$email = $_POST['email'];
$senha = $_POST['senha'];
$nome = $_POST['nome'];

$pdo = database(); 

    if (!empty($email) && !empty($senha) && !empty($nome)) {
        try {
       
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $senha]);
            header('Location: login.php');
            exit;

            
        } catch (PDOException $e) {
            $mensagem_erro = "Erro no banco de dados: " . $e->getMessage();
        }
    }
}

?>  

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarControl</title>
    <link rel="stylesheet" href="CSS/cadastro.css">
</head>

<body>
    <main class="conteudo-principal">

        <section class="secao-inicial" id="login">

            <div class="texto-introducao">

                <h1 class="titulo-secao">
                    Controle<br>
                    <span class="destaque-verde">
                        inteligente<br>Energia sustentável
                    </span>
                </h1>

                <h2>
                    Monitore sua produção de energia solar,<br>
                    acompanhe seu consumo e<br>
                    tenha controle total do seu sistema em um só lugar.
                </h2>
            </div>

            <div class="painel-login">
                <div class="logo">SolarControl</div>


                <h2>Cadastrar-se</h2>

                <p class="texto-auxiliar">
                    Bem-vindo de volta. Acesse o painel da sua usina.
                </p>

                <form method="POST" class="formulario-login">
                    
                    <label for="nome">Nome</label>

                    <input class="campos" type="text" id="nome" name="nome" placeholder="nome" required>

                    <label for="email">E-mail</label>

                    <input class="campos" type="email" id="email" name="email" placeholder="nome@empresa.com" required>

                    <label for="senha">Senha</label>

                    <input class="campos" type="password" id="senha" name="senha" placeholder="••••••••" minlength="6"
                        required>

                    <button class="entrar" type="submit">Criar</button>

                </form>

                <p class="texto-auxiliar texto-centralizado">
                    <a class="botao-navegacao" href="login.php">Voltar</a>
                </p>

                <p><?php echo $mensagem_erro; ?> </p>

            </div>

        </section>

        <footer class="rodape">


            <div class="rodape-marca">
                <span class="destaque-verde">SolarControl</span>
                <span class="destaque-verde">© 2026 by Solar Control</span>

            </div>

        </footer>

    </main>
</body>

</html>