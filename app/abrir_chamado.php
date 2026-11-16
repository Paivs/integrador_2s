<?php
require_once __DIR__ . "/init.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit;
}

// Busca os ambientes cadastrados no banco
$ambientes = readAll($pdo, "ambiente");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo     = trim($_POST["titulo"]);
    $tipo       = $_POST["tipo"] ?? "";
    $categoria  = $_POST["categoria"] ?? "";
    $idAmbiente = (int) ($_POST["id_ambiente"] ?? 0);
    $patrimonio = trim($_POST["patrimonio"] ?? "");
    $prioridade = $_POST["prioridade"] ?? "media";

    // Monta a descrição com os detalhes do formulário
    $descricao = "Tipo: $tipo | Categoria: $categoria | Prioridade: $prioridade";
    if ($patrimonio !== "") {
        $descricao .= " | Patrimônio: $patrimonio";
    }
    $descricao .= "\n\n" . trim($_POST["descricao"]);

    // Descobre o id_cliente válido para não dar erro de chave estrangeira
    $idCliente = $_SESSION["id_cliente"] ?? null;
    if (!$idCliente) {
        $stmtCli = $pdo->prepare("SELECT id FROM cliente WHERE id_usuario = ? LIMIT 1");
        $stmtCli->execute([$_SESSION["id_usuario"]]);
        $cli = $stmtCli->fetch(PDO::FETCH_ASSOC);

        if ($cli) {
            $idCliente = $cli["id"];
        } else {
            $primeiroCli = $pdo->query("SELECT id FROM cliente LIMIT 1")->fetch(PDO::FETCH_ASSOC);
            $idCliente = $primeiroCli ? $primeiroCli["id"] : null;
        }
    }

    // Verifica quais colunas existem na tabela chamado para evitar erro de coluna inexistente
    $colunas = $pdo->query("DESCRIBE chamado")->fetchAll(PDO::FETCH_COLUMN);

    $campos  = ["titulo", "descricao", "status_chamado", "data_chamado", "id_ambiente", "id_cliente"];
    $valores = [":titulo", ":descricao", "'aguardando'", "NOW()", ":id_ambiente", ":id_cliente"];
    $params  = [
        ":titulo"      => $titulo,
        ":descricao"   => $descricao,
        ":id_ambiente" => $idAmbiente,
        ":id_cliente"  => $idCliente,
    ];

    if (in_array("prioridade", $colunas)) {
        $campos[]  = "prioridade";
        $valores[] = ":prioridade";
        $params[":prioridade"] = $prioridade;
    }

    $sql = "INSERT INTO chamado (" . implode(", ", $campos) . ") VALUES (" . implode(", ", $valores) . ")";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: chamado.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir chamado - SchoolHelpDesk</title>
    <link rel="stylesheet" href="css/abrir_chamado.css">
</head>
<body>

    <aside class="menu">
        <div class="logo">
            <img src="imagem/logo_schoolhelpdesk.png" alt="SchoolHelpDesk">
        </div>

        <nav>
            <a href="painel.php">Início</a>
            <a href="abrir_chamado.php" class="ativo">Abrir chamado</a>
            <a href="chamado.php">Meus chamados</a>
            <a href="historico.php">Histórico</a>

            <p class="grupo">CONTA</p>
            <a href="meu_perfil.php">Meu perfil</a>
        </nav>

        <a href="logout.php" class="sair">Sair</a>
    </aside>

    <main class="conteudo">
        <header class="topo">
            <span class="caminho">Início / <strong>Abrir chamado</strong></span>
            <span class="nome-topo"><?= htmlspecialchars($_SESSION["nome"] ?? "", ENT_QUOTES, "UTF-8") ?></span>
        </header>

        <section class="titulo">
            <h1>Abrir novo chamado</h1>
            <p class="subtitulo">Descreva o problema com o máximo de detalhes para agilizar o atendimento</p>
        </section>

        <form method="post" enctype="multipart/form-data" class="cartao">

            <label class="rotulo">Tipo de solicitação <span class="obrigatorio">*</span></label>
            <div class="linha-2">
                <label class="opcao-tipo">
                    <input type="radio" name="tipo" value="Manutenção" checked>
                    <div>
                        <strong>Manutenção</strong>
                        <span>Elétrica, hidráulica, mobiliário, climatização</span>
                    </div>
                </label>

                <label class="opcao-tipo">
                    <input type="radio" name="tipo" value="Suporte técnico">
                    <div>
                        <strong>Suporte técnico</strong>
                        <span>Computadores, projetores, rede, sistemas</span>
                    </div>
                </label>
            </div>

            <div class="linha-2">
                <div>
                    <label class="rotulo">Título <span class="obrigatorio">*</span></label>
                    <input type="text" name="titulo" placeholder="Ex.: Projetor não liga / Vazamento no ar" required>
                </div>

                <div>
                    <label class="rotulo">Categoria <span class="obrigatorio">*</span></label>
                    <select name="categoria" required>
                        <option value="Hardware">Hardware (Computadores, Projetores, Periféricos)</option>
                        <option value="Software">Software (Sistemas, Programas, Login)</option>
                        <option value="Rede">Rede (Wi-Fi, Internet, Cabos)</option>
                        <option value="Climatização">Climatização (Ar-condicionado, Ventilador)</option>
                        <option value="Elétrica">Elétrica (Tomadas, Lâmpadas, Quadro de energia)</option>
                        <option value="Hidráulica">Hidráulica (Vazamentos, Torneiras, Banheiros)</option>
                        <option value="Mobiliário">Mobiliário (Carteiras, Cadeiras, Portas, Quadros)</option>
                    </select>
                </div>
            </div>

            <div class="linha-2">
                <div>
                    <label class="rotulo">Ambiente / Local <span class="obrigatorio">*</span></label>
                    <select name="id_ambiente" required>
                        <option value="">Selecione o local...</option>
                        <?php foreach ($ambientes as $amb): ?>
                            <option value="<?= $amb["id"] ?>">
                                <?= htmlspecialchars($amb["nome"], ENT_QUOTES, "UTF-8") ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="rotulo">Patrimônio (opcional)</label>
                    <input type="text" name="patrimonio" placeholder="Ex.: PAT-00231">
                </div>
            </div>

            <div>
                <label class="rotulo">Descrição do problema <span class="obrigatorio">*</span></label>
                <textarea name="descricao" rows="4" placeholder="Explique o que está acontecendo no local..." required></textarea>
            </div>

            <div class="linha-2">
                <div>
                    <label class="rotulo">Prioridade sugerida</label>
                    <div class="prioridades">
                        <label><input type="radio" name="prioridade" value="baixa"><span>Baixa</span></label>
                        <label><input type="radio" name="prioridade" value="media" checked><span>Média</span></label>
                        <label><input type="radio" name="prioridade" value="alta"><span>Alta</span></label>
                        <label><input type="radio" name="prioridade" value="urgente"><span>Urgente</span></label>
                    </div>
                    <small class="dica">A equipe responsável confirma a prioridade final</small>
                </div>

                <div>
                    <label class="rotulo">Anexar evidências</label>
                    <input type="file" name="evidencia" class="campo-arquivo" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>

            <div class="rodape">
                <a href="chamado.php" class="botao-claro">Cancelar</a>
                <button type="submit">Enviar chamado</button>
            </div>

        </form>
    </main>

</body>
</html>