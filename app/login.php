<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/banco/database.php';
require_once __DIR__ . '/banco/crud.php';

$mensagem_erro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha =$_POST['senha'] ?? '';

    $pdo = database();

    if ($email !== '' &&$senha !== '') {
        try {
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['email' =>$email]);
            $usuario =$stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario &&$usuario['senha'] == $senha) {$_SESSION['usuario_logado'] = true;
                $_SESSION['email'] =$email;
                $_SESSION['nome'] =$usuario['nome'];
                header('Location: index.php');
                exit;
            } else {
                $mensagem_erro = "E-mail ou senha inválidos.";
            }
        } catch (PDOException $e) {$mensagem_erro = "Erro no banco de dados: " . $e->getMessage();
        }
    } else {
        $mensagem_erro = "Preencha e-mail e senha.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolarControl — Monitoramento Solar Inteligente</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
    <header class="topo-fixo">
        <nav class="navegacao" aria-label="Navegação principal">
            <a href="#login" class="marca-nav">Solar<span>Control</span></a>
            <div class="links-navegacao">
                <a href="#login" class="link-nav ativo">Login</a>
                <a href="#Sobre" class="link-nav">Sobre</a>
                <a href="#Preferencia" class="link-nav">Preferência</a>
                <a href="#Equipe" class="link-nav">Equipe</a>
                <a href="#Objetivos" class="link-nav">Objetivos</a>
            </div>
        </nav>
    </header>

    <main>
        <!-- HERO + LOGIN -->
        <section class="secao-inicial" id="login">
            <div class="container hero-grid">
                <div class="texto-introducao">
                    <span class="tag-destaque">Energia limpa sob controle</span>
                    <h1 class="titulo-hero">
                        Controle <span class="destaque-claro">inteligente</span><br>
                        Energia sustentável
                    </h1>
                    <p class="subtitulo-hero">
                        Monitore sua produção de energia solar, acompanhe seu consumo e
                        tenha controle total do seu sistema em um só lugar.
                    </p>
                    <div class="hero-metricas">
                        <div>
                            <strong>Até 95%</strong>
                            <span>de economia na fatura</span>
                        </div>
                        <div>
                            <strong>24/7</strong>
                            <span>controle do sistema</span>
                        </div>
                        <div>
                            <strong>100%</strong>
                            <span>energia renovável</span>
                        </div>
                    </div>
                </div>

                <div class="painel-login">
                    <div class="logo-login">Solar<span>Control</span></div>
                    <h2>Entrar</h2>
                    <p class="texto-auxiliar">
                        Bem-vindo de volta. Acesse o painel da sua usina.
                    </p>

                    <?php if ($mensagem_erro !== ''): ?>
                        <div class="alerta-erro" role="alert">
                            <?php echo htmlspecialchars($mensagem_erro); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="formulario-login">
                        <div class="campo-grupo">
                            <label for="email">E-mail</label>
                            <input
                                class="campos"
                                type="email"
                                id="email"
                                name="email"
                                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                placeholder="nome@empresa.com"
                                required
                            >
                        </div>

                        <div class="campo-grupo">
                            <label for="senha">Senha</label>
                            <div class="senha-wrapper">
                                <input
                                    class="campos"
                                    type="password"
                                    id="senha"
                                    name="senha"
                                    placeholder="••••••••"
                                    minlength="6"
                                    required
                                >
                                <button type="button" id="toggleSenha" class="btn-olho" aria-label="Mostrar senha">
                                    Mostrar
                                </button>
                            </div>
                        </div>

                        <button class="entrar" type="submit">Entrar</button>
                    </form>

                    <p class="texto-auxiliar texto-centralizado">
                        Não tem conta?
                        <a href="cadastro.php">Criar conta</a>
                    </p>
                </div>
            </div>
        </section>

        <!-- SOBRE -->
        <section class="secao secao-sobre revelar" id="Sobre">
            <div class="container sobre-grid">
                <div class="textos-secao-sobre">
                    <span class="etiqueta">Sobre nós</span>
                    <h2 class="titulo-secao">
                        O que é a <span class="destaque-verde">SolarControl?</span>
                    </h2>
                    <p class="frase-impacto">
                        Mais controle para um <span class="destaque-verde">futuro sustentável.</span>
                    </p>
                    <p class="texto-corpo">
                        O SolarControl reúne as informações mais importantes do seu sistema fotovoltaico
                        em uma experiência simples e intuitiva. Acompanhe a geração, entenda o consumo
                        e veja como sua energia está performando.
                    </p>
                </div>

                <div class="secao-sobre-img">
                    <img src="imagens/painelsolar.png" alt="Painel Solar">
                </div>
            </div>
        </section>

        <!-- PREFERÊNCIA / DESTAQUE -->
        <section class="secao secao-destaque revelar" id="Preferencia">
            <div class="container destaque-grid">
                <div class="img-secao-destaque">
                    <img src="imagens/porqueasolar.png" alt="Energia solar inteligente">
                    <div class="legenda-destaque">
                        <h3>Transformamos dados em <span class="destaque-verde">decisões inteligentes</span></h3>
                        <p>Ajudando você a aproveitar melhor sua energia solar.</p>
                    </div>
                </div>

                <div class="pilares-destaque">
                    <span class="pilar p1">Clean,</span>
                    <span class="pilar p2">Energy,</span>
                    <span class="pilar p3">Smart &amp;</span>
                    <span class="pilar p4">Saving</span>
                </div>
            </div>
        </section>

        <!-- EQUIPE -->
        <section class="secao secao-equipe revelar" id="Equipe">
            <div class="container">
                <div class="cabecalho-secao">
                    <span class="etiqueta">Quem faz acontecer</span>
                    <h2 class="titulo-secao">
                        Nossa <span class="destaque-verde">Equipe</span>
                    </h2>
                    <p class="subtitulo-secao">Pessoas que impulsionam o futuro da energia.</p>
                </div>

                <div class="cards-equipe">
                    <article class="card-equipe">
                        <img src="imagens/pessoa1.png" alt="Integrante da equipe">
                        <h3>Nome do integrante</h3>
                        <p>Desenvolvedor</p>
                    </article>

                    <article class="card-equipe">
                        <img src="imagens/pessoa2.png" alt="Integrante da equipe">
                        <h3>Nome do integrante</h3>
                        <p>Designer</p>
                    </article>

                    <article class="card-equipe">
                        <img src="imagens/pessoa3.png" alt="Integrante da equipe">
                        <h3>Nome do integrante</h3>
                        <p>Analista</p>
                    </article>

                    <article class="card-equipe">
                        <img src="imagens/pessoa4.png" alt="Integrante da equipe">
                        <h3>Nome do integrante</h3>
                        <p>Gestor de projetos</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- OBJETIVOS -->
        <section class="secao secao-objetivos revelar" id="Objetivos">
            <div class="container">
                <div class="cabecalho-secao escuro">
                    <span class="etiqueta-clara">Nosso propósito</span>
                    <h2 class="titulo-secao claro">
                        Nossos <span class="destaque-claro">Objetivos</span>
                    </h2>
                    <p class="subtitulo-secao claro">
                        Tecnologia e sustentabilidade trabalhando juntas para transformar o futuro.
                    </p>
                </div>

                <div class="cards-objetivos">
                    <article class="card-objetivo">
                        <span class="num-objetivo">01</span>
                        <h3>Energia Sustentável</h3>
                        <p>Incentivar o uso de energia limpa, contribuindo para um futuro mais sustentável.</p>
                    </article>

                    <article class="card-objetivo">
                        <span class="num-objetivo">02</span>
                        <h3>Economia Inteligente</h3>
                        <p>Reduzir gastos com energia elétrica por meio de soluções fotovoltaicas.</p>
                    </article>

                    <article class="card-objetivo">
                        <span class="num-objetivo">03</span>
                        <h3>Monitoramento Eficiente</h3>
                        <p>Facilitar o acompanhamento da produção e do desempenho energético.</p>
                    </article>

                    <article class="card-objetivo">
                        <span class="num-objetivo">04</span>
                        <h3>Inovação Tecnológica</h3>
                        <p>Desenvolver soluções modernas que aproximem as pessoas da energia renovável.</p>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <footer class="rodape">
        <div class="container rodape-conteudo">
            <strong class="marca-rodape">Solar<span>Control</span></strong>
            <span>© 2026 by SolarControl</span>
        </div>
    </footer>

    <script src="javascript/login.js"></script>
</body>

</html>
