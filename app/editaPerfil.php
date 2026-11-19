<?php

session_start();

require_once __DIR__ . "/init.php";

$idUsuario = (int) ($_SESSION['id_usuario'] ?? 1);   // TEMPORÁRIO: tirar o ?? 1 quando o login existir
$usuario   = read($pdo, 'usuario', 'idUsuario = ?', [$idUsuario]);

if (!$usuario) {
    header('Location: login.php');
    exit;
}

// Identifica qual campo foi clicado na URL (ex: editaPerfil.php?campo=nome)
$camposPermitidos = ['nome', 'email', 'telefone', 'senha', 'tema'];
$campo = $_GET['campo'] ?? 'todos';

if (!in_array($campo, $camposPermitidos, true)) {
    $campo = 'todos';
}

// Títulos dinâmicos para a página
$titulos = [
    'nome'     => 'Editar Nome',
    'email'    => 'Editar E-mail',
    'telefone' => 'Editar Telefone',
    'senha'    => 'Alterar Senha',
    'tema'     => 'Alterar Tema',
    'todos'    => 'Editar Perfil'
];

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [];

    // Valida e prepara apenas o(s) campo(s) exibido(s)
    if ($campo === 'nome' || $campo === 'todos') {
        $nome = trim($_POST['nome'] ?? '');
        if ($nome === '') {
            $erros[] = 'Informe o seu nome.';
        } else {
            $dados['nome'] = $nome;
        }
    }

    if ($campo === 'email' || $campo === 'todos') {
        $email = trim($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'E-mail inválido.';
        } else {
            $dados['email'] = $email;
        }
    }

    if ($campo === 'telefone' || $campo === 'todos') {
        $telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');
        if (strlen($telefone) < 10 || strlen($telefone) > 11) {
            $erros[] = 'Telefone inválido. Informe o DDD e o número.';
        } else {
            $dados['telefone'] = $telefone;
        }
    }

    if ($campo === 'senha' || $campo === 'todos') {
        $senha = $_POST['senha'] ?? '';
        if ($campo === 'senha' && strlen($senha) < 6) {
            $erros[] = 'A nova senha deve ter pelo menos 6 caracteres.';
        } elseif ($senha !== '') {
            $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
        }
    }

    if ($campo === 'tema' || $campo === 'todos') {
        $tema = $_POST['tema'] ?? 'claro';
        $dados['tema'] = in_array($tema, ['claro', 'escuro'], true) ? $tema : 'claro';
    }

    if (!$erros && !empty($dados)) {
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
    <title>findIt - <?= $titulos[$campo] ?></title>
    <link rel="stylesheet" href="./css/editaPerfil.css">
</head>

<body class="pagina-edita">
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png" alt="findIt."></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.jpg" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button type="button">+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>
        <h1><?= $titulos[$campo] ?></h1>

        <?php if ($erros): ?>
            <div class="caixa-erros">
                <?php foreach ($erros as $erro): ?>
                    <p class="texto-erro"><?= htmlspecialchars($erro) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">

            <?php if ($campo === 'nome' || $campo === 'todos'): ?>
                <label for="nome">
                    Nome
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </label>
            <?php endif; ?>

            <?php if ($campo === 'email' || $campo === 'todos'): ?>
                <label for="email">
                    E-mail
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </label>
            <?php endif; ?>

            <?php if ($campo === 'telefone' || $campo === 'todos'): ?>
                <label for="telefone">
                    Telefone
                    <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" required>
                </label>
            <?php endif; ?>

            <?php if ($campo === 'senha' || $campo === 'todos'): ?>
                <label for="senha">
                    <?= $campo === 'senha' ? 'Nova senha' : 'Nova senha (deixe vazio para não mudar)' ?>
                    <input type="password" id="senha" name="senha" <?= $campo === 'senha' ? 'required' : '' ?>>
                </label>
            <?php endif; ?>

            <?php if ($campo === 'tema' || $campo === 'todos'): ?>
                <fieldset>
                    <legend>Tema do sistema</legend>
                    <label class="opcao">
                        <input type="radio" name="tema" value="claro" <?= ($usuario['tema'] ?? 'claro') === 'claro' ? 'checked' : '' ?>>
                        Claro
                    </label>
                    <label class="opcao">
                        <input type="radio" name="tema" value="escuro" <?= ($usuario['tema'] ?? '') === 'escuro' ? 'checked' : '' ?>>
                        Escuro
                    </label>
                </fieldset>
            <?php endif; ?>

            <div class="botoes-form">
                <a href="perfil.php" class="btn-cancelar">Cancelar</a>
                <button type="submit">Salvar</button>
            </div>
        </form>
    </main>
</body>

</html>