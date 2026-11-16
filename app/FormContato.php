<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/contato.css">
    <title>Contato</title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="imagens/logo.png">
        </div>
        
        <div class="menu">
                <a href="perfil.html" class="btn-perfil">
    <img src="imagens/perfil.png" alt="Perfil">
</a>
                <a href="sobre.html">Sobre</a>
                <a href=".html">Objetos guardados</a>
                <a href="faq.html">Dúvidas</a>
                <a href="contato.html">Contato</a>
                <a href="CadastrarItem.html" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </div>
    </header>

    <main>
        <h1>Contato</h1>
        <h2>Algum problema ou dúvida, entre em contato com nosso suporte</h2>

        <form action="processaContato.php" method="post">
            <label>Telefone:
                <input type="tel" name="telefone" placeholder="exemplo: (11) 12345-6789" required>
            </label>

            <label>Nome:
                <input type="text" name="Nome" placeholder="exemplo: Maria José" required>
            </label>

            <label>Email:
                <input type="email" name="email" placeholder="exemplo: emailcliente@gmail.com" required>
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
        <div>
            <h3>Nosso contato:</h3>
            <p><strong>Email:</strong> findit@gmail.com</p>
            <p><strong>Telefone:</strong> (11) 12345-6789</p>
        </div>

        <div>
            <h3>Atendimento:</h3>
            <p>Segunda - Sexta feira: 08:00 às 20:00</p>
            <p>Sábados: 10:00 às 18:00</p>
            <p>Domingos: 10:00 às 16:00</p>
        </div>
    </footer>
</body>
</html>
