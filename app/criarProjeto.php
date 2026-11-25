<?php

declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "/init.php";

$idUsuario = $_SESSION['id'] ?? $_SESSION['id_usuario'] ?? null;

if (empty($idUsuario)) {
    header("Location: loginUsuario.php");
    exit;
}

$idReserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProjeto = trim($_POST['nomeProjeto'] ?? '');
    $descricao   = trim($_POST['descricao'] ?? '');
    $imagem      = trim($_POST['imagem'] ?? '');

    if ($nomeProjeto === '' || $descricao === '' || $imagem === '') {
        $erro = "Preencha todos os campos obrigatórios.";
    } elseif (strlen($imagem) > 255) {
        $erro = "O link da imagem deve ter no máximo 255 caracteres.";
    } else {
        $pdo = database();

        try {
            $pdo->beginTransaction();

            // 1. Cria o projeto
            $idProjetoCriado = create($pdo, 'Projetos', [
                'nome_projeto'      => $nomeProjeto,
                'descricao_projeto' => $descricao,
                'imagem_projeto'    => $imagem,
                'id_criador'        => $idUsuario,
            ]);

            create($pdo, 'Projetos_Usuarios', [
                'id_projeto' => $idProjetoCriado,
                'id_usuario' => $idUsuario,
            ]);

            if (!empty($idReserva)) {
                $reserva = read(
                    $pdo,
                    'Reservas',
                    'id_reserva = ? AND id_usuario = ?',
                    [$idReserva, $idUsuario]
                );

                if ($reserva) {
                    update(
                        $pdo,
                        'Reservas',
                        ['id_projeto' => $idProjetoCriado],
                        'id_reserva = ? AND id_usuario = ?',
                        [$idReserva, $idUsuario]
                    );
                }
            }

            $pdo->commit();

            header('Location: perfil.php');
            exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $erro = "Erro ao cadastrar projeto: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Projeto</title>
</head>

<body>

    <h1 class="titulo-formulario">Adicionar Projeto</h1>

    <?php if ($erro !== null): ?>
        <p class="mensagem-erro" style="color: red; font-weight: bold;">
            <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form class="formulario" action="" method="POST">

        <?php if (!empty($idReserva)): ?>
            <input
                type="hidden"
                name="id_reserva"
                value="<?= htmlspecialchars((string) $idReserva, ENT_QUOTES, 'UTF-8') ?>">
        <?php endif; ?>

        <div class="coluna">
            <label class="rotulo" for="nomeProjeto">Nome do projeto:</label>
            <input
                class="campo"
                type="text"
                name="nomeProjeto"
                id="nomeProjeto"
                maxlength="100"
                value="<?= htmlspecialchars($_POST['nomeProjeto'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required>
        </div>

        <div class="coluna">
            <label class="rotulo" for="descricao">Escreva uma descrição para o projeto:</label>
            <textarea
                class="campo campo-descricao"
                name="descricao"
                id="descricao"
                required><?= htmlspecialchars($_POST['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

            <label class="rotulo" for="imagem">Cole o link da imagem:</label>
            <input
                class="campo campo-imagem"
                type="text"
                name="imagem"
                id="imagem"
                maxlength="255"
                value="<?= htmlspecialchars($_POST['imagem'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                required>

            <button class="botao-registrar" type="submit">Registrar</button>
        </div>

    </form>

</body>

</html>