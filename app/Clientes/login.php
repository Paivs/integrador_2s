 <?php

require_once __DIR__ . "/init.php";

$erro = '';

//Recebe o que foi inserido no formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emailInserido = trim($_POST['email'] ?? '');
    $senhaInserida = $_POST['senha'] ?? '';

    $usuario = read($pdo, 'usuarios', 'email = ?', [$emailInserido]);

    // Compara com o banco de dados o que foi digitado
    if ($usuario && password_verify($senhaInserida, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        header('Location: index.php');
        exit;
    }

    // Mensagem de erro exibida quando e-mail ou senha não conferem
    $erro = "Tente novamente, E-mail ou Senha incorretos.";
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ElectroSafe</title>
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
        <h2 class="titulo-form">Login</h2>
        <form action="" method="POST">
            <?php if ($erro !== ''): ?>
                <p class="mensagem erro" role="alert"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <div class="campo-grupo">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" placeholder="email@gmail.com" required>
            </div>

            <div class="campo-grupo">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="xxxxxxx" required>
            </div>

            <button type="submit" class="btn-enviar">Login</button>

            <p class="link-alternativo">Não possui login? <a href="cadastro.php">Clique aqui</a> para fazer seu cadastro!</p>
        </form>
    </div>
</body>
</html>