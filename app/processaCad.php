<?php

declare(strict_types=1);

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/banco/crud.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastrarConta.php');
    exit;
}

$nome  = trim($_POST['nome'] ?? '');
$tel   = trim($_POST['tel'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha']) ?? '';

$erros = [];

if (empty($nome)) {
    $erros[] = 'O Campo "Nome" está vazio';
    header('Location: cadastrarConta.php?erro=O Campo Nome está vazio.');
    exit;
}

if (empty($tel)) {
    $erros[] = 'O Campo "Telefone" está vazio';
    header('Location: cadastrarConta.php?erro=O Campo Telefone está vazio.');
    exit;
}

if (empty($email)) {
    $erros[] = 'O Campo "E-mail" está vazio';
    header('Location: cadastrarConta.php?erro=O Campo E-mail está vazio.');
    exit;
} 

elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = 'O E-mail informado é inválido.';
    header('Location: cadastrarConta.php?erro=O E-mail informado é inválido.');
    exit;
}

if (empty($senha)) {
    $erros[] = 'O Campo "Senha" está vazio';
    header('Location: cadastrarConta.php?erro=O Campo Senha está vazio.');
    exit;
}

if (!empty($erros)) {
    echo "<h3> Ocorreram os Seguintes erros:</h3>";
    echo "<ul>";
    foreach ($erros as $erro) {
        echo "<li>" . htmlspecialchars($erro) . "</li>";
    }
    echo "</ul>";
    echo '<a href="cadastrarConta.php">Voltar ao cadastro</a>';
    exit;
}

try 
{
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $dadosUsuario = [
        'nome'     => $nome,
        'telefone' => $tel,
        'email'    => $email,
        'senha'    => $senhaHash
    ];
    if (empty($erros)) 
    {
        $create = create($pdo, 'usuario', $dadosUsuario);
        header('Location: login.php?status=sucesso');
        exit;
    }
} 

catch (PDOException $e) 
{
    if($e->getCode() == '23000')
        {
            echo 'Erro! Registro Duplicado: ' . htmlspecialchars($e->getMessage());
            echo '<br><a href="cadastrarConta.php">Tentar novamente</a>';
            exit;
        }
    else
        {
            echo 'Erro ao realizar o cadastro: ' . htmlspecialchars($e->getMessage());
            echo '<br><a href="cadastrarConta.php">Tentar novamente</a>';
            exit;
        }
   
}
catch (Exception $e) 
{
    echo 'Erro inesperado: ' . htmlspecialchars($e->getMessage());
    echo '<br><a href="cadastrarConta.php">Tentar novamente</a>';
    exit;
}
