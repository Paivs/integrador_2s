<?php

require_once __DIR__ . "/init.php";

$usuario = null;
if (isset($_SESSION['id_usuario'])) {
    $usuario = read($pdo, 'usuario', 'idUsuario = ?', [$_SESSION['id_usuario']]);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/contato.css">
    <link rel="icon" type="image/png" href="./imagens/finditDesenho.png">
    <title>Contato</title>
</head>

<body>
    <header>
        <div class="logo">
            <a href="./index.php"><img src="imagens/findit-white.png"></a>
        </div>

        <nav class="menu">
            <a href="perfil.php" class="btn-perfil">
                <img src="imagens/perfil.jpg" alt="Perfil">
            </a>
            <a href="./sobre.php">Sobre</a>
            <a href="./painelObjetos.php">Objetos guardados</a>
            <a href="./faq.php">Dúvidas</a>
            <a href="./FormContato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>
        <h1>Contato</h1>
        <h2>Algum problema ou dúvida, entre em contato com nosso suporte</h2>

        <form action="processaContato.php" method="post">
            <label>Nome:
                <input type="text" name="nome" placeholder="exemplo: Marcio Henrique" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
            </label>

            <label>Telefone:
                <input type="tel" name="telefone" placeholder="exemplo:123456789" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" required>
            </label>

            <label>Email:
                <input type="email" name="email" placeholder="exemplo: emailcliente@gmail.com" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
            </label>

            <fieldset>
                <legend>Assunto:</legend>
                <label class="opcao"><input type="radio" name="assunto" value="suporte"> Suporte</label>
                <label class="opcao"><input type="radio" name="assunto" value="sugestao"> Sugestão</label>
                <label class="opcao"><input type="radio" name="assunto" value="reclamacao"> Reclamação</label>
            </fieldset>

            <label>Mensagem:
                <textarea name="mensagem" placeholder="Insira a sua mensagem aqui" required></textarea>
            </label>

            <button type="submit">Enviar</button>
        </form>
    </main>
    
    <footer>
        <div class="rodape-coluna">
            <p>Sistema de achados e perdidos. Devolvendo pertences de forma rápida e simples.</p>
        </div>

        <div class="direitos">
            <p>&copy; 2026 Celeste System. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>

</html>