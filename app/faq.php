<?php


?>


<!DOCTYPE html>
<html lang="pt-BR">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIt - Perguntas Frequentes</title>
    <link rel="stylesheet" href="./css/faq.css">
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
            <a href="./CadastrarItem.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <div class="container">
        <main>

            <div class="faq-block">
                <h2>1.Qual o prazo máximo para retirar um objeto?</h2>
                <p>O prazo máximo para a retirada de um objeto é de até 30 dias após seu cadastro no sistema.</p>
            </div>

            <div class="faq-block">
                <h2>2. É possível cadastrar um objeto sem especificar a categoria?</h2>
                <p>É obrigatório selecionar a categoria do objeto.</p>
            </div>

            <div class="faq-block">
                <h2>3. E se não tiver um stand por perto?</h2>
                <p>Após encontrarmos o seu objeto, enviaremos para o nosso stand mais perto.</p>
            </div>

            <div class="faq-block">
                <h2>4. E se passar dos 30 dias e eu quiser pegar o meu produto?</h2>
                <p>Após o prazo máximo ser atingido, enviaremos um e-mail avisando que o objeto será encaminhado para doação.</p>
            </div>

        </main>
    </div>

</body>


</html>