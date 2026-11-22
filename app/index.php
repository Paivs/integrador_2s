<?php

require_once __DIR__ . "/init.php";

$mostrarIntro = true;

$objetos = readAll($pdo, 'objetos');

$i = 0;
$cont = 0;

foreach ($objetos as $o) {
    $i++;
    if ($o['status_objeto'] == 'Encontrado') {
        $cont++;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIt</title>

    <link rel="stylesheet" href="./css/style-index.css">
    <link rel="icon" type="image/png" href="./imagens/finditDesenho.png">
</head>

<body class="<?= $mostrarIntro ? 'com-intro' : '' ?>">
    <?php if ($mostrarIntro): ?>
        <div class="intro" aria-hidden="true">
            <img src="imagens/findit.png" alt="">
        </div>
    <?php endif; ?>
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
        <div class="topo">
            <h1>O seu rastreador de TODOS os objetos! (sim, todos)</h1>
        </div>

        <div class="demonstracao">
            <video width="900" height="500" autoplay muted loop>
                <source src="./imagens/video-findIt.mp4" type="video/mp4">
                O teu navegador não suporta a etiqueta de vídeo.
            </video>
        </div>

        <div class="conta">
            <a href="./login.php" class="fazerLogin">fazer Login</a>
            <a href="./cadastrarConta.php" class="criarConta">Criar Conta</a>
        </div>

        <h2 class="subtitulo">Como funciona?</h2>
        <div class="passos">
            <div class="quadro">
                <h3>1. Cadastro</h3>
                <p>Você cria uma conta gratuita em nosso sistema e cadastre o objeto perdido (tanto que vc perdeu ou achou)</p>
            </div>
            <div class="quadro">
                <h3>2. Busca</h3>
                <p>A partir daí o seu objeto estará cadastrado no nosso sistema, aparecerá no nosso Painel de Objetos e se achado irá para analise</p>
            </div>
            <div class="quadro">
                <h3>3. Entrega</h3>
                <p>Veremos se o objeto é seu, e se for, enviaremos para o nosso stand mais próximo de você e te entregaremos bonitinho para você</p>
            </div>
        </div>

        <div class="dados">
            <p>Já são <u><?= $i ?></u> objetos cadastrados</p>
            <p> <u><?= $cont ?></u> objetos encontados</p>
        </div>

        <h2 class="subtitulo">O que dizem sobre o Findit</h2>

        <div class="avaliacoes">

            <div class="carrossel-container">
                <div class="carrossel-trilha">

                    <!-- === BLOCO ORIGINAL (7 AVALIAÇÕES) === -->

                    <!-- 1. 5 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">📱</div>
                            <div>
                                <h4>Carlos Eduardo</h4>
                                <span class="selo selo-encontrado">Celular Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span>
                        </div>
                        <p>"Achei que tinha perdido meu celular para sempre na biblioteca. Cadastraram no Findit e recuperei no mesmo dia!"</p>
                    </div>

                    <!-- 2. 4 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🔑</div>
                            <div>
                                <h4>Mariana Silva</h4>
                                <span class="selo selo-encontrado">Chaves Encontradas</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span>
                        </div>
                        <p>"Recuperei a chave do carro que deixei no refeitório! Só demorei um pouquinho para achar a categoria certa, mas funciona muito bem."</p>
                    </div>

                    <!-- 3. 5 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🎒</div>
                            <div>
                                <h4>Lucas Mendes</h4>
                                <span class="selo selo-encontrado">Mochila Encontrada</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span>
                        </div>
                        <p>"Recuperei minha mochila com todos os cadernos e notebook intactos. Ainda existe muita gente honesta por aqui!"</p>
                    </div>

                    <!-- 4. 3 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🎧</div>
                            <div>
                                <h4>Beatriz Costa</h4>
                                <span class="selo selo-encontrado">Fone Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span><span class="vazia">★</span>
                        </div>
                        <p>"Peguei meu fone de volta na secretaria graças ao site. Seria legal se mandasse uma notificação no WhatsApp quando cadastrassem algo parecido."</p>
                    </div>

                    <!-- 5. 5 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">💳</div>
                            <div>
                                <h4>Rafael Oliveira</h4>
                                <span class="selo selo-encontrado">Carteira Encontrada</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span>
                        </div>
                        <p>"Perdi minha carteira com todos os documentos. Em menos de 3 horas já estava com ela em mãos novamente. Nota 10!"</p>
                    </div>

                    <!-- 6. 4 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">⌚</div>
                            <div>
                                <h4>Fernanda Lima</h4>
                                <span class="selo selo-encontrado">Relógio Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span>
                        </div>
                        <p>"Muito prático poder compartilhar o link do item perdido direto no WhatsApp. Me ajudou demais a divulgar nos grupos."</p>
                    </div>

                    <!-- 7. 5 Estrelas -->
                    <div class="card-avaliacao">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">👓</div>
                            <div>
                                <h4>Thiago Santos</h4>
                                <span class="selo selo-encontrado">Óculos Encontrados</span>
                            </div>
                        </div>
                        <div class="estrelas">
                            <span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span>
                        </div>
                        <p>"Sem meus óculos eu não enxergo nada kkk. Ainda bem que encontraram na sala de aula e postaram rápido aqui no sistema."</p>
                    </div>

                    <!-- === CÓPIA EXATA PARA O LOOP INFINITO (NÃO REMOVER) === -->
                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">📱</div>
                            <div>
                                <h4>Carlos Eduardo</h4><span class="selo selo-encontrado">Celular Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span></div>
                        <p>"Achei que tinha perdido meu celular para sempre na biblioteca. Cadastraram no Findit e recuperei no mesmo dia!"</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🔑</div>
                            <div>
                                <h4>Mariana Silva</h4><span class="selo selo-encontrado">Chaves Encontradas</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span></div>
                        <p>"Recuperei a chave do carro que deixei no refeitório! Só demorei um pouquinho para achar a categoria certa, mas funciona muito bem."</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🎒</div>
                            <div>
                                <h4>Lucas Mendes</h4><span class="selo selo-encontrado">Mochila Encontrada</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span></div>
                        <p>"Recuperei minha mochila com todos os cadernos e notebook intactos. Ainda existe muita gente honesta por aqui!"</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">🎧</div>
                            <div>
                                <h4>Beatriz Costa</h4><span class="selo selo-encontrado">Fone Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span><span class="vazia">★</span></div>
                        <p>"Peguei meu fone de volta na secretaria graças ao site. Seria legal se mandasse uma notificação no WhatsApp quando cadastrassem algo parecido."</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">💳</div>
                            <div>
                                <h4>Rafael Oliveira</h4><span class="selo selo-encontrado">Carteira Encontrada</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span></div>
                        <p>"Perdi minha carteira com todos os documentos. Em menos de 3 horas já estava com ela em mãos novamente. Nota 10!"</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">⌚</div>
                            <div>
                                <h4>Fernanda Lima</h4><span class="selo selo-encontrado">Relógio Encontrado</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="vazia">★</span></div>
                        <p>"Muito prático poder compartilhar o link do item perdido direto no WhatsApp. Me ajudou demais a divulgar nos grupos."</p>
                    </div>

                    <div class="card-avaliacao" aria-hidden="true">
                        <div class="cabecalho-avaliacao">
                            <div class="emoji-mini">👓</div>
                            <div>
                                <h4>Thiago Santos</h4><span class="selo selo-encontrado">Óculos Encontrados</span>
                            </div>
                        </div>
                        <div class="estrelas"><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span><span class="cheia">★</span></div>
                        <p>"Sem meus óculos eu não enxergo nada kkk. Ainda bem que encontraram na sala de aula e postaram rápido aqui no sistema."</p>
                    </div>

                </div>
            </div>
        </div>
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