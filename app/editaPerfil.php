<?php

session_start();

require_once __DIR__ . "/init.php";

$idUsuario = (int) ($_SESSION['id_usuario'] ?? 1);   // TEMPORÁRIO: tirar o ?? 1 quando o login existir
$usuario   = read($pdo, 'usuario', 'idUsuario = ?', [$idUsuario]);

if (!$usuario) {
    header('Location: login.php');
    exit;
}

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome     = trim($_POST['nome'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
    $senha    = $_POST['senha'] ?? '';

    if ($nome === '') {
        $erros[] = 'Informe o seu nome.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = 'E-mail inválido.';
    }
    if (strlen($telefone) < 10 || strlen($telefone) > 11) {
        $erros[] = 'Telefone inválido. Informe o DDD e o número.';
    }

    if (!$erros) {
        $dados = ['nome' => $nome, 'telefone' => $telefone, 'email' => $email];

        if ($senha !== '') {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }

        try {
            update($pdo, 'usuario', $dados, 'idUsuario = ?', [$idUsuario]);
            header('Location: perfil.php');
            exit;
        } catch (PDOException $e) {
            if ((int) ($e->errorInfo[1] ?? 0) === 1062) {   // 1062 = valor repetido (e-mail UNIQUE)
                $erros[] = 'Esse e-mail já está em uso.';
            } else {
                error_log($e->getMessage());
                $erros[] = 'Não foi possível salvar agora. Tente novamente.';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edita Perfil</title>
    <link rel="stylesheet" href="./css/editaPerfil.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.png" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>
        <?php foreach ($erros as $erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endforeach; ?>
        <form action="" method="post">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" required>

            <label for="senha">Nova senha (deixe vazio para não mudar)</label>
            <input type="password" id="senha" name="senha">

            <button type="submit">Salvar</button>
        </form>
    </main>
</body>

</html>