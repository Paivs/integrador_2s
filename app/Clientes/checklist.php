<?php
session_start();

$materiais = [
    "Alicate Universal",
    "Chave Phillips",
    "Multímetro",
    "Alicate Amperímetro",
    "Fita Isolante",
    "Óculos de Proteção",
    "Luvas de Proteção",
];

$total = count($materiais);
$marcados = [];
$mensagem = "";
$classeMensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enviados = $_POST["materiais"] ?? [];
    foreach ($enviados as $indice) {
        if (ctype_digit((string) $indice) && (int) $indice < $total) {
            $marcados[] = (int) $indice;
        }
    }
    $marcados = array_unique($marcados);

    if (count($marcados) === $total) {
        $_SESSION["flash"] = [
            "texto"  => "Checklist concluída com sucesso!",
            "classe" => "sucesso",
        ];
        header("Location: checklist.php");
        exit;
    }

    $mensagem = "Ainda existem materiais que precisam ser conferidos!";
    $classeMensagem = "erro";
} elseif (isset($_SESSION["flash"])) {
    $mensagem = $_SESSION["flash"]["texto"];
    $classeMensagem = $_SESSION["flash"]["classe"];
    unset($_SESSION["flash"]);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Checklist</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="stylesClientes/styleChecklist.css">
</head>

<body>

    <div class="fundo-video" aria-hidden="true">
        <video autoplay muted loop playsinline preload="metadata">
            <source src="imagens/video.mp4" type="video/mp4">
        </video>
        <div class="fundo-overlay"></div>
    </div>

    <div class="layout-principal">

        <aside class="barra-menu">
            <a href="index.php" class="logo-link" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeca">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav" aria-label="Navegação principal">
                <a href="index.php" class="nav-item"><i></i><span>Início</span></a>
                <a href="registro.php" class="nav-item"><i></i><span>Registro de não conformidades</span></a>
                <a href="analise.php" class="nav-item"><i></i><span>Análise técnica e inspeção</span></a>
                <a href="checklist.php" class="nav-item active" aria-current="page"><i></i><span>Checklist</span></a>
                <a href="acompanhamento.php" class="nav-item"><i></i><span>Acompanhamento</span></a>
                <a href="indicacao.php" class="nav-item"><i></i><span>Indicações</span></a>
            </nav>
        </aside>

        <div class="area-direita">

            <header class="topo">
                <div class="topo__marca">
                    <h1 class="logo">ELECTROSAFE</h1>
                    <p class="topo__sub">Sistema de Inspeção e Segurança Elétrica</p>
                </div>
            </header>

            <main class="content">
                <div class="painel-checklist">
                    <div class="painel-header">
                        <h1>CHECKLIST DE MATERIAIS</h1>
                        <p>Marque os equipamentos que já foram conferidos.</p>
                    </div>

                    <div class="painel-body">
                        <form method="post" action="checklist.php">
                            <div class="lista">
                                <?php foreach ($materiais as $indice => $nome): ?>
                                    <label class="item">
                                        <input type="checkbox"
                                               class="material"
                                               name="materiais[]"
                                               value="<?= $indice ?>"
                                               <?= in_array($indice, $marcados, true) ? "checked" : "" ?>>
                                        <span><?= htmlspecialchars($nome) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" class="btn-finalizar">
                                FINALIZAR CHECKLIST
                            </button>
                        </form>

                        <?php if ($mensagem !== ""): ?>
                            <div class="mensagem-status <?= $classeMensagem ?>" role="status">
                                <?= htmlspecialchars($mensagem) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </main>

            <footer class="rodape">
                <p>ELECTROSAFE © 2026 - SEGURANÇA E CONFIABILIDADE</p>
            </footer>

        </div>
    </div>

</body>
</html>