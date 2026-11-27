<?php
    require_once __DIR__ . "/init.php";

    $mensagem = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $dados_usuario =[
            "nome" => $_POST["nome"],
            "email" => $_POST["email"],
            "data_nascimento" => $_POST["data_nascimento"] ?: null,
            "senha" => password_hash($_POST["senha"], PASSWORD_DEFAULT),
            "cpf" => $_POST["cpf"],
            "telefone" => $_POST["telefone"]
        ];
        $id = create($pdo, "usuarios", $dados_usuario);
        
        $mensagem = "Cliente cadastrado com sucesso!";
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $data_nascimento = $_POST["data_nascimento"];

        $senha = $_POST["senha"];
        $senha_confirmada = $_POST["senha_confirmada"];

        if ($senha == $senha_confirmada) {
            header("Location: login.php");
            exit;
        } else {
            echo '<p class="mensagem erro" role="alert">Senha incorreta! Tente novamente.</p>';
        }

    }



?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - ElectroSafe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylesClientes/styleLogin.css">
</head>
<body>
    <div class="fundo-video" aria-hidden="true">
        <video autoplay muted loop playsinline preload="metadata">
            <source src="imagens/fundo-telaLogin.mp4" type="video/mp4">
        </video>
        <div class="fundo-overlay"></div>
    </div>

    <div class="formulario-bloco">
        <img class="logo-img" src="imagens/logo.png" alt="Logo ElectroSafe">
        <div class="logo"><span class="corElectro">Electro</span><span class="corSafe">Safe</span></div>
        <h2 class="titulo-form">Cadastro</h2>

        <form action="" method="POST">

            <?php if ($mensagem !== ''): ?>
                <p class="mensagem sucesso" role="status"><?= htmlspecialchars($mensagem) ?></p>
            <?php endif; ?>

            <div class="campo-grupo">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome"
                       placeholder="Insira seu nome completo" required>
            </div>

            <div class="campo-grupo">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email"
                       placeholder="email@gmail.com" required>
            </div>

            <div class="linha-dupla">
                <div class="campo-grupo">
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf"
                           placeholder="000.000.000-00" required>
                </div>
                <div class="campo-grupo">
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone"
                           placeholder="(11) 12345-6789" required>
                </div>
            </div>

            <div class="campo-grupo">
                <label for="data_nascimento">Data de nascimento:</label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
            </div>

            <div class="linha-dupla">
                <div class="campo-grupo">
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <div class="campo-grupo">
                    <label for="senha_confirmada">Confirme a senha:</label>
                    <input type="password" name="senha_confirmada" id="senha_confirmada" required>
                </div>
            </div>

            <?php if ($mensagem_erro !== ''): ?>
            <p class="mensagem erro" role="alert"><?= htmlspecialchars($mensagem_erro) ?></p>
            <?php endif; ?>
                
            <button type="submit" class="btn-enviar">Cadastrar</button>

            <p class="link-alternativo">Já possui login? <a href="login.php">Clique aqui</a> para entrar!</p>

        </form>
    </div>
</body>
</html>
