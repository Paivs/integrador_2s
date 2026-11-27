<?php ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styleSite.css">
    <title>ElectroSafe - Home</title>
</head>
<body>
    <header>
        <h2><span class="corElectro">Electro</span><span class="corSafe">Safe</span></h2>
        <!-- Cada link leva para a seção que tem o mesmo id (#home, #servicos...) -->
        <nav class="navegacao">
            <a href="#home">Home</a>
            <a href="#servicos">Serviços</a>
            <a href="#quem-somos">Quem Somos?</a>
            <a href="#por-que-nos">Por Que Nós</a>
            <a href="#faq">FAQ</a>
            <a href="../Clientes/login.php" class="botao-entrar">Entrar</a>
        </nav>
    </header>

    <main>
        <!-- Início do site com vídeo de fundo e um botão para redirecionar para a parte de login ou cadastro -->
        <section class="home" id="home">
            <div class="fundo-video" aria-hidden="true">
                <video autoplay muted loop playsinline preload="metadata">
                    <source src="imagens/fundo-Index-Site.mp4" type="video/mp4">
                </video>
                <div class="fundo-overlay"></div>
            </div>
            <div class="home-conteudo">
                <h1>Praticidade e segurança na palma da sua mão!</h1>
                <p class="texto-grande">Através dos recursos de fácil acesso e usabilidade, sua segurança é tratada com cuidados especiais pela nossa equipe, garantindo o bom lazer e conforto aos consumidores.</p>
                <div class="linha"></div>
                <p>Registre os locais que precisam de melhorias na estrutura elétrica e acompanhe tudo em um só lugar.</p>
                <a href="../Clientes/login.php" class="botao">Fazer login</a>
                <a href="../Clientes/cadastro.php" class="botao-contorno">Criar conta</a>
            </div>
        </section>

        <!-- serviços -->
        <section class="secao" id="servicos">
            <h2>Serviços</h2>
            <h3 class="subtitulo">Recursos do sistema</h3>
            <div class="cards">
                <div class="card">
                    <h3>Registro de não conformidades</h3>
                    <p>Informe problemas encontrados na estrutura elétrica.</p>
                </div>
                <div class="card">
                    <h3>Análise técnica e inspeção</h3>
                    <p>Avaliação dos pedidos para definir a melhor solução.</p>
                </div>
                <div class="card">
                    <h3>Checklist</h3>
                    <p>Lista de verificação para conferir o ambiente.</p>
                </div>
                <div class="card">
                    <h3>Acompanhamento</h3>
                    <p>Consulte o andamento de cada pedido.</p>
                </div>
                <div class="card">
                    <h3>Indicação</h3>
                    <p>Indique o ElectroSafe para outras pessoas.</p>
                </div>
            </div>
            <h3 class="subtitulo">Tipos de serviço</h3>
            <div class="cards">
                <div class="card">
                    <h3>Tomadas e pontos de energia</h3>
                    <p>Problemas em tomadas e pontos de energia.</p>
                </div>
                <div class="card">
                    <h3>Iluminação</h3>
                    <p>Ajustes e melhorias na iluminação.</p>
                </div>
                <div class="card">
                    <h3>Disjuntores e quadro elétrico</h3>
                    <p>Verificação de disjuntores e do quadro.</p>
                </div>
                <div class="card">
                    <h3>Instalação elétrica</h3>
                    <p>Melhorias na instalação elétrica em geral.</p>
                </div>
            </div>
            <a href="../Clientes/login.php" class="botao">Solicitar um serviço</a>
        </section>

        <!-- quem somos -->
        <section class="secao secao-escura" id="quem-somos">
            <h2>Quem somos?</h2>
            <div class="texto-secao">
                <p>O ElectroSafe é um sistema criado para facilitar o registro e o acompanhamento de melhorias em instalações elétricas. A ideia é simples: quem identifica um problema consegue informar de forma rápida, e a equipe consegue organizar e acompanhar cada pedido.</p>
                <p>Atendemos diferentes tipos de ambiente, como condomínios, indústrias, locais de grande circulação de público e áreas classificadas.</p>
            </div>
            <div class="cards">
                <div class="card">
                    <h3>Missão</h3>
                    <p>Tornar a segurança elétrica mais simples e acessível.</p>
                </div>
                <div class="card">
                    <h3>Visão</h3>
                    <p>Ser referência em praticidade no cuidado com instalações elétricas.</p>
                </div>
                <div class="card">
                    <h3>Valores</h3>
                    <p>Segurança, clareza, responsabilidade e respeito ao cliente.</p>
                </div>
            </div>
        </section>

        <!-- por que nós? -->
        <section class="secao" id="por-que-nos">
            <h2>Por que nos escolher?</h2>
            <div class="cards">
                <div class="card">
                    <h3>Fácil de usar</h3>
                    <p>Registre um pedido em poucos passos, direto do computador ou do celular.</p>
                </div>
                <div class="card">
                    <h3>Tudo em um só lugar</h3>
                    <p>Registro, checklist e acompanhamento reunidos no mesmo sistema.</p>
                </div>
                <div class="card">
                    <h3>Foco em segurança</h3>
                    <p>Nosso objetivo é reduzir riscos em instalações elétricas.</p>
                </div>
                <div class="card">
                    <h3>Dados protegidos</h3>
                    <p>Suas senhas são guardadas de forma criptografada.</p>
                </div>
            </div>
            <a href="../Clientes/cadastro.php" class="botao">Criar minha conta</a>
        </section>

        <!-- FAQ -->
        <section class="secao secao-escura" id="faq">
            <h2>Perguntas frequentes</h2>
            <div class="faq-lista">
                <details>
                    <summary>Preciso criar uma conta para usar?</summary>
                    <p>Sim. Basta fazer o cadastro com nome, e-mail, CPF, telefone, data de nascimento e uma senha. Depois é só entrar com seu e-mail e senha.</p>
                </details>
                <details>
                    <summary>Como registro um local que precisa de melhorias?</summary>
                    <p>Na página inicial do sistema, escolha o tipo de ambiente, preencha seus dados de contato, selecione o tipo de serviço e descreva o problema elétrico.</p>
                </details>
                <details>
                    <summary>Quais tipos de serviço posso solicitar?</summary>
                    <p>Tomadas e pontos de energia, iluminação, disjuntores e quadro elétrico, e instalação elétrica.</p>
                </details>
                <details>
                    <summary>Como acompanho o meu pedido?</summary>
                    <p>Depois de enviado, o pedido fica com o status "Aguardando". Você pode consultar o andamento na área de acompanhamento do sistema.</p>
                </details>
                <details>
                    <summary>Minha senha fica segura?</summary>
                    <p>Sim. As senhas são guardadas de forma criptografada, e ninguém consegue ler a senha original.</p>
                </details>
            </div>
        </section>
    </main>

    <footer>
        <h3><span class="corElectro">Electro</span><span class="corSafe">Safe</span></h3>
        <p>Segurança e praticidade para instalações elétricas.</p>
        <div class="links-rodape">
            <a href="#home">Home</a>
            <a href="#servicos">Serviços</a>
            <a href="#quem-somos">Quem Somos?</a>
            <a href="#por-que-nos">Por Que Nós</a>
            <a href="#faq">FAQ</a>
        </div>
        <p>&copy; 2026 ElectroSafe. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
