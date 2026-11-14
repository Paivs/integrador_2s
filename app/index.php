<?php

require_once __DIR__ . "/init.php";

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
            <a href="./contato.php">Contato</a>
            <a href="./cadastraObj.php" class="btn-cadastrar"><button>+ Cadastrar item</button></a>
        </nav>
    </header>

    <main>
        <div class="topo">
            <h1>O seu rastreador de TODOS os objetos! (sim, todos)</h1>
        </div>

        <div class="demonstracao">
            <img src="./imagens/tela-painel.png" alt="Tela do Painel de Objetos" width="900px">
        </div>

        <div class="conta">
            <a href="./login.php" class="fazerLogin">fazer Login</a>
            <a href="./cadastraConta.php" class="criarConta">Criar Conta</a>
        </div>

        <h2>Como funciona?</h2>
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

        <h2>Avaliações</h2>

        <div class="avaliacoes">
            <div class="bloco">
                <p>Juliana Pires</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Esqueci meu Notebook na mesa do escritório. Uma menina achou, postou, e em 10 minutos a gente já estava indo busca. Salvou demais!</p>
                </div>
            </div>

            <div class="bloco">
                <p>Mariana</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Sempre que o pessoal deixa chaves, capacetes ou guarda-chuvas jogados nos corredores, eu cadestro no sistema pra galera achar rápido. Ficou muito mais organizado do que aquela caixa de papelão no balcão.</p>
                </div>
            </div>

            <div class="bloco">
                <p>José Britto</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Esqueci meu Notebook na mesa do escritório. Uma menina achou, postou, e em 10 minutos a gente já estava indo buscar. Salvou demais!</p>
                </div>
            </div>

            <div class="bloco">
                <p>Vincenzo</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Faço caminhada na pista do campus de manhã e achei um molho de chaves de carro perto do portão. Um menino da faculdade me ajudou a publicar no site e no mesmo dia o dono apareceu. Fiquei muito feliz em ajudar!</p>
                </div>
            </div>

            <div class="bloco">
                <p>Paulo César</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Perdi minha joelheira no ginásio depois do treino. Como a busca por palavra-chave funciona certinho, só digitei 'joelheira' e lá estava o aviso. Ferramenta indispensável!</p>
                </div>
            </div>

            <div class="bloco">
                <p>Yasmin</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Achei um fone sem fio no banco perto da biblioteca. Cliquei no botão 'Encontrei!' no card e compartilhei direto no grupo da minha sala no Zap. O dono me chamou na hora. O sistema funciona de verdade.</p>
                </div>
            </div>

            <div class="bloco">
                <p>Daniel Oliveira</p>
                <p>⭐⭐⭐⭐⭐</p>
                <div class="comentario">
                    <p>Chego correndo do trabalho pra aula e acabei deixando meu Bilhete Único com a carteira de estudante no pátio. Achei no dia seguinte pesquisando na categoria 'Documentos'. Muito simples de mexer.</p>
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