<?php
require_once __DIR__ . "/init.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["excluir"])) {
    $stmt = $pdo->prepare("DELETE FROM chamado WHERE id = ?");
    $stmt->execute([$_POST["excluir"]]);
    header("Location: chamado.php");
    exit;
}

$status = $_GET["status"] ?? "";
$busca  = trim($_GET["busca"] ?? "");

// Busca por título OU pelo número formatado (#0001, 0001 ou 1)
$sql = "SELECT c.*, a.nome AS nome_ambiente 
        FROM chamado c 
        LEFT JOIN ambiente a ON c.id_ambiente = a.id 
        WHERE (c.titulo LIKE ? OR CONCAT('#', LPAD(c.id, 4, '0')) LIKE ?)";
$params = ["%$busca%", "%$busca%"];

if ($status !== "") {
    $sql .= " AND c.status_chamado = ?";
    $params[] = $status;
}

$sql .= " ORDER BY c.data_chamado DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus chamados - SchoolHelpDesk</title>
    <link rel="stylesheet" href="css/chamado.css">
</head>
<body>

    <aside class="menu">
        <div class="logo">
            <img src="imagem/logo_schoolhelpdesk.png" alt="SchoolHelpDesk">
        </div>

        <nav>
            <a href="painel.php">Início</a>
            <a href="abrir_chamado.php">Abrir chamado</a>
            <a href="chamado.php" class="ativo">Meus chamados</a>
            <a href="historico.php">Histórico</a>

            <p class="grupo">CONTA</p>
            <a href="meu_perfil.php">Meu perfil</a>
        </nav>

        <a href="logout.php" class="sair">Sair</a>
    </aside>

    <main class="conteudo">
        <header class="topo">
            <span class="caminho">Início / <strong>Meus chamados</strong></span>
            <span class="nome-topo"><?= htmlspecialchars($_SESSION["nome"] ?? "") ?></span>
        </header>

        <section class="cabecalho-lista">
            <div>
                <h1>Meus chamados</h1>
                <p class="subtitulo"><?= count($chamados) ?> chamados registrados</p>
            </div>
            <a href="abrir_chamado.php" class="botao">+ Abrir novo chamado</a>
        </section>

        <section class="cartao-tabela">
            <div class="abas">
                <a href="chamado.php" class="<?= $status === '' ? 'ativa' : '' ?>">Todos</a>
                <a href="chamado.php?status=aguardando" class="<?= $status === 'aguardando' ? 'ativa' : '' ?>">Aguardando</a>
                <a href="chamado.php?status=em andamento" class="<?= $status === 'em andamento' ? 'ativa' : '' ?>">Em andamento</a>
                <a href="chamado.php?status=concluido" class="<?= $status === 'concluido' ? 'ativa' : '' ?>">Concluídos</a>
                <a href="chamado.php?status=cancelado" class="<?= $status === 'cancelado' ? 'ativa' : '' ?>">Cancelados</a>
            </div>

            <form method="get" class="filtros">
                <?php if ($status !== "") { ?>
                    <input type="hidden" name="status" value="<?= htmlspecialchars($status) ?>">
                <?php } ?>
                <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar chamado por número ou título" class="campo-busca">
                <button type="submit" class="botao">Buscar</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>TÍTULO</th>
                        <th>AMBIENTE</th>
                        <th>PRIORIDADE</th>
                        <th>STATUS</th>
                        <th>ABERTURA</th>
                        <th>AÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($chamados)) { ?>
                        <tr>
                            <td colspan="7" class="vazio">Nenhum chamado encontrado.</td>
                        </tr>
                    <?php } ?>

                    <?php foreach ($chamados as $c) { 
                        $prio = $c["prioridade"] ?? "media";
                        $stat = $c["status_chamado"] ?? "aguardando";
                        $classeStatus = str_replace(" ", "_", $stat);
                    ?>
                        <tr>
                            <td class="codigo">#<?= str_pad((string) $c["id"], 4, "0", STR_PAD_LEFT) ?></td>
                            <td class="col-titulo"><?= htmlspecialchars($c["titulo"]) ?></td>
                            <td><?= htmlspecialchars($c["nome_ambiente"] ?? "Não informado") ?></td>
                            <td>
                                <span class="tag prio-<?= htmlspecialchars($prio) ?>">
                                    <?= htmlspecialchars(ucfirst($prio)) ?>
                                </span>
                            </td>
                            <td>
                                <span class="tag status-<?= htmlspecialchars($classeStatus) ?>">
                                    <?= htmlspecialchars(ucfirst($stat)) ?>
                                </span>
                            </td>
                            <td><?= !empty($c["data_chamado"]) ? date("d/m/Y", strtotime($c["data_chamado"])) : "" ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Deseja excluir este chamado?')">
                                    <button type="submit" class="excluir" name="excluir" value="<?= $c["id"] ?>">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>