<?php
// Mensagem de status pós-envio
$mensagem = '';
$sucesso = false;

// 1. Lógica PHP para processar e salvar os dados do formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'salvar_local') {
    $ambiente    = filter_input(INPUT_POST, 'ambiente', FILTER_SANITIZE_SPECIAL_CHARS);
    $responsavel = filter_input(INPUT_POST, 'responsavel', FILTER_SANITIZE_SPECIAL_CHARS);
    $contato     = filter_input(INPUT_POST, 'contato', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao   = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($ambiente) && !empty($responsavel) && !empty($contato)) {
        /*
         * AQUI ENTRA O SALVAMENTO NO SEU BANCO DE DADOS (PDO/MySQL):
         * $stmt = $pdo->prepare("INSERT INTO chamados (ambiente, responsavel, contato, descricao) VALUES (?, ?, ?, ?)");
         * $stmt->execute([$ambiente, $responsavel, $contato, $descricao]);
        */

        $mensagem = "Informações registradas com sucesso para: " . htmlspecialchars($ambiente);
        $sucesso = true;
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}

// 2. Leitura da URL (GET) para saber qual ambiente foi clicado
$ambiente_selecionado = filter_input(INPUT_GET, 'abrir_form', FILTER_SANITIZE_SPECIAL_CHARS);
$exibir_formulario = !empty($ambiente_selecionado);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe</title>
    <link rel="stylesheet" href="stylesClientes/styleIndex.css">
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="layout-principal">
    
        <aside class="barra-menu">
           <img src="imagens/logo.png" alt="Logo">
            <div class="barra-menu-cabeça">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item active">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="registro.php" class="nav-item">
                    <i></i>
                    <span>Registro de não conformidades</span>
                </a>
                <a href="analise.php" class="nav-item">
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

        <main class="content">
<img class="imagem1"src="imagens/imagem1.png" alt="Imagem">
            <section class="info-section">
                <h2>
                    Através dos recursos de fácil acesso e usabilidade, sua segurança é tratada com cuidados especiais pela nossa equipe, garantindo o bom lazer e conforto aos consumidores.
</h2>
                <br><br>    
                
                <h1 class="main-title">Praticidade e segurança na palma da sua mão!</h1>
                <br>
                <hr class="linha">
                
                <p class="texto-menor">
                    Adicione os locais que exigem melhorias em sua estrutura elétrica, de acordo com os ambientes abaixo.
                </p>

                <!-- Feedback do PHP após envio -->
                <?php if (!empty($mensagem)): ?>
                    <div class="mensagem-status <?= $sucesso ? 'sucesso' : 'erro' ?>">
                        <?= $mensagem ?>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Quadros de Seleção de Ambiente (Links em PHP) -->
            <section class="cards-section">
                <div class="cards-container">
                    
                    <a href="index.php?abrir_form=Edifícios+residenciais+e+condomínios" class="card-button">
                        <span>Edifícios residenciais e condomínios</span>
                        <i class="seta-inferior"></i>
                    </a>

                    <a href="index.php?abrir_form=Indústrias+e+galpões+fabris" class="card-button">
                        <span>Indústrias e galpões fabris</span>
                        <i class="seta-inferior"></i>
                    </a>

                    <a href="index.php?abrir_form=Locais+de+grande+circulação+de+público" class="card-button">
                        <span>Locais de grande circulação de público</span>
                        <i class="seta-inferior"></i>
                    </a>

                    <a href="index.php?abrir_form=Áreas+classificadas+com+atmosferas+explosivas" class="card-button">
                        <span>Áreas classificadas com atmosferas explosivas</span>
                        <i class="seta-inferior"></i>
                    </a>

                </div>
            </section>

        </main>
    </div>

    <!-- 3. Condicional PHP para renderizar o Formulário apenas quando houver um clique -->
    <?php if ($exibir_formulario): ?>
        
        <!-- Fundo de sobreposição com link PHP para fechar -->
        <a href="index.php" class="overlay ativo"></a>

        <div class="form-drawer ativo">
            <div class="form-drawer-content">
                <!-- Botão de Fechar rodando via link PHP -->
                <a href="index.php" class="btn-fechar">&times;</a>

                <div class="form-cabecalho">
                    <h3>Novo Registro: <?= htmlspecialchars($ambiente_selecionado) ?></h3>
                    <p>Preencha os detalhes da estrutura elétrica abaixo:</p>
                </div>

                <form action="index.php" method="POST">
                    <input type="hidden" name="action" value="salvar_local">
                    <input type="hidden" name="ambiente" value="<?= htmlspecialchars($ambiente_selecionado) ?>">

                    <div class="campo-grupo">
                        <label for="responsavel">Nome do Solicitante / Responsável:</label>
                        <input type="text" id="responsavel" name="responsavel" placeholder="Ex: Thiago Navarro" required>
                    </div>

                    <div class="campo-grupo">
                        <label for="contato">Telefone / WhatsApp:</label>
                        <input type="text" id="contato" name="contato" placeholder="(11) 12345-6789" required>
                    </div>

                    <div class="campo-grupo">
                        <label for="descricao">Descrição da necessidade de melhoria:</label>
                        <textarea id="descricao" name="descricao" rows="3" placeholder="Descreva o problema ou ajuste elétrico necessário..." required></textarea>
                    </div>

                    <button type="submit" class="btn-enviar">Salvar Informações</button>
                </form>
            </div>
        </div>

    <?php endif; ?>

</body>
</html>