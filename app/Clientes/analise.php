<?php
declare(strict_types=1);

$databaseStatus = 'Conectado';

try {
    require_once __DIR__ . '/init.php';
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $databaseStatus = 'Indisponível';
}

$mensagem = "";
$estadoBotao = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $acesso_disjuntor = $_POST['acesso_disjuntor'] ?? null;
    $fumo_agua        = $_POST['fumo_agua'] ?? null;
    $servico          = trim((string)($_POST['servicos'] ?? ''));
    $problema         = trim((string)($_POST['problema'] ?? ''));

$servicosEnum = [
    'conserto'     => 'CONSERTO',
    'montagem'     => 'MONTAGEM',
    'avalicacao'   => 'AVALIAÇÃO',
    'manutencao'   => 'MANUTENÇÃO',
    'modificacao'  => 'MODIFICAÇÃO',
];

    if ($acesso_disjuntor === "nao" || $fumo_agua === "sim") {
        $mensagem = "
        <div id='fundo'>
            <div id='perigo'>
                <h2> ATENÇÃO: RISCO ELEVADO DETETADO</h2>
                <p>Por motivos de segurança, este problema não pode ser orientado à distância.</p>
                <p>Recomendamos desligar a chave geral e contactar um profissional presencial.</p>
                <br>
                <a href='indicacao.php' id='btn-fechar-alerta'>Ir para os indicados</a>
            </div>
        </div>";

        $estadoBotao = "disabled";
    }

elseif ($acesso_disjuntor === "sim" && $fumo_agua === "nao") {
    if (!isset($servicosEnum[$servico]) || $problema === '') {
        $mensagem = "<p>Preencha o serviço e descreva o problema.</p>";
    } else {
        try {
            create($pdo, 'analise_tecnica', [
                'servicos'        => $servicosEnum[$servico],
                'relatoProblema'  => $problema,
            ]);

            $mensagem = "
            <div id='fundo'>
                <div id='sucesso'>
                    <h2>ENVIADO COM SUCESSO!</h2>
                    <p>SEU FORMULÁRIO FOI MANDADO PARA A GENTE, AGUARDE POR ALGUNS INSTANTES.</p>
                    <br>
                    <p>CASO VOCÊ QUEIRA ESCOLHER SEUS PRODUTOS CLIQUE ABAIXO</p>
                    <br>
                    <a href='analise.php' id='btn-sucesso'>Ok</a>
                    <a href='checklist.php' id='btn-sucesso'>Produtos</a>
                </div>
            </div>";
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $mensagem = "<p>Não foi possível salvar. Tente novamente.</p>";
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
    <link rel="stylesheet" href="stylesClientes/styleAnalise.css">
    <title>Análise e Inspeção | ElectroSafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


</head>
<body>
    <aside class="barra-menu">
           <img src="imagens/logo.png" alt="Logo">
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span>
                        <span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong>
                    </span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item ">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="registro.php" class="nav-item">
                    <i></i>
                    <span>Registro de não conformidades</span>
                </a>
                <a href="analise.php" class="nav-item active">
                    <i></i>
                    <span>Análise técnica e inspeção</span>
                </a>
                <a href="checklist.php" class="nav-item">
                    <i></i>
                    <span>Checklist</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item">
                    <i></i>
                    <span>Indicação</span>
                </a>
            </nav>
        </aside>


        <main>
            <header>
                <h1>SOLICITAR ANÁLISE TÉCNICA E INSPEÇÃO </h1>
            </header>
            


            <div id="formulario">
                <?php echo $mensagem; ?>
            <form action="" method="POST" id="formAnalise">
                    <!-- PASSO UM DO FORMULARIO-->
                <h2>PASSO 1: <br>
                O SEU PROBLEMA E CONTATO</h2>
                <br>
                <label for="servicos" class="passo-um">Serviços:</label>
                <select id="servicos" name="servicos">
                    <option value="conserto">Conserto / Reparo</option>
                    <option value="montagem">Montagem / Instalção</option>
                    <option value="avalicacao">Avaliação / Diagnóstico</option>
                    <option value="manutencao">Manutenção Preventiva</option>
                    <option value="modificacao">Modificação / Upgrade</option>
                </select>
                <br>
                <label for="problema" class="passo-um">Relate seu Problema:</label>
                <textarea
                id="problema"
                name="problema"
                rows="5"
                cols="40"
                ></textarea>
                <br>

                    <!-- PASSO DOIS DO FORMULARIO-->
                <h2>PASSO 2:<br> 
                CHECAGEM RÁPIDA DE SEGURANÇA</h2>
                <br>
                    <!-- PRIMEIRA PERGUNTA DO PASSO 2-->
                <h3 class="perguntas">Você tem acesso livre ao disjuntor / chave geral para desligar a energia?</h3>
                <div class="selecao">
                    <input type="radio"
                    id="disjuntor_sim"
                    name="acesso_disjuntor"
                    value="sim"
                    class="escolha" required>
                    <label for="disjuntor_sim" class="resp">Sim, consigo desligar o local com segurança</label>
                </div>
                <br>

                <div class="selecao">
                    <input type="radio"
                    id="disjuntor_nao"
                    name="acesso_disjuntor"
                    value="nao"
                    class="escolha" required>
                    <label for="disjuntor_nao" class="resp">Não sei onde fica / Não tenho acesso</label>
                </div>

                    <!-- SEGUNDA PERGUNTA DO PASSO 2-->

                <h3 class="perguntas">Existe fumo, faíscas visíveis ou água em contacto com a fiação no local?</h3>
                <div class="selecao">
                    <input type="radio"
                    id="fumo_sim"
                    name="fumo_agua"
                    value="sim"
                    class="escolha" required>
                    <label for="fumo_sim" class="resp">Sim, há fumo, faíscas ou humidade/água no local</label>
                </div>
                <br>

                <div class="selecao">
                    <input type="radio"
                    id="fumo_nao"
                    name="fumo_agua"
                    value="nao"
                    class="escolha" required>
                    <label for="fumo_nao" class="resp">Não, o local está seco e sem sinais de fogo/faíscas</label>
                </div>

                <!-- TERCEIRA PERGUNTA DO PASSO 2-->

                <h3 class="perguntas">Tens ferramentas básicas ou equipamento de proteção?</h3>
                <div class="selecao">
                    <input type="radio"
                    id="ferramenta_chaves"
                    name="ferramentas"
                    value="chaves"
                    class="escolha" required>
                    <label for="ferramenta_chaves" class="resp">Chaves manuais ou de teste</label>
                </div>
                <br>

                <div class="selecao">
                    <input type="radio"
                    id="ferramenta_epi"
                    name="ferramentas"
                    value="epi"
                    class="escolha" required>
                    <label for="ferramenta_epi" class="resp">Calçado de borracha e luvas</label>
                </div>
                <br>

                <div class="selecao">
                    <input type="radio"
                    id="ferramenta_nenhuma"
                    name="ferramentas"
                    value="nenhuma"
                    class="escolha" required>
                    <label for="ferramenta_nenhuma" class="resp">Nenhuma ferramenta</label>
                </div>
                <br>
                <!-- BOTAO-->
                <button type="submit" <?php echo $estadoBotao; ?>>Enviar</button>
            </form>
        </main>
    </div>

        
</body>
</html>