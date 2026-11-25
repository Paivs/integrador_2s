<?php

require_once __DIR__ . "/init.php";

$idUsuario = $_SESSION['id'] ?? $_SESSION['id_usuario'] ?? null;
$erro = null;     

if (empty($idUsuario)) {
    header("Location: loginUsuario.php");
    exit;
}

$idReserva = $_POST['id_reserva'] ?? $_GET['id_reserva'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nomeProjeto = trim($_POST['nomeProjeto'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $imagem = trim($_POST['imagem'] ?? '');

    if ($nomeProjeto === '' || $descricao === '' || $imagem === '') {
        $erro = "Preencha todos os campos obrigatórios.";
    } elseif (strlen($imagem) > 255) {
        $erro = "O link da imagem deve ter no máximo 255 caracteres.";
    } else {

        $idProjetoCriado = create(database(), 'Projetos', [
            'nome_projeto' => $nomeProjeto,
            'descricao_projeto' => $descricao,
            'imagem_projeto' => $imagem,
            'id_criador' => $idUsuario,
        ]);

        create(database(), 'Projetos_Usuarios', [
            'id_projeto' => $idProjetoCriado,
            'id_usuario' => $idUsuario,
        ]);

        if (isset($idReserva)) {
            $reserva = read(database(),'Reservas','id_reserva = ? AND id_usuario = ?',[$idReserva, $idUsuario]);

            if ($reserva) {update(database(),'Reservas',[
                'id_projeto' => $idProjetoCriado],
                'id_reserva = ? AND id_usuario = ?', [$idReserva, $idUsuario]
                );
            }
        }

  

        header('Location: perfil.php');
        exit;
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
        <h1>Adicionar Projeto</h1>
        <?php if ($erro !== null): ?>
            <p>
                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST">
            <?php if (isset($idReserva)): ?>
                <input type="hidden" name="id_reserva" value="<?= htmlspecialchars((string) $idReserva, ENT_QUOTES, 'UTF-8') ?>">
            <?php endif; ?>

                <label for="nomeProjeto">Nome do projeto:</label>
                <input type="text" name="nomeProjeto" id="nomeProjeto" value="<?= htmlspecialchars($_POST['nomeProjeto'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

                <label class="rotulo" for="descricao">Escreva uma descrição para o projeto:</label>
                <textarea name="descricao" id="descricao" required><?= htmlspecialchars($_POST['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

                <label for="imagem">Cole o link da imagem:</label>
                <input type="text" name="imagem" id="imagem "value="<?= htmlspecialchars($_POST['imagem'] ?? '', ENT_QUOTES, 'UTF-8') ?>"required>

                <button class="botao-registrar" type="submit">Registrar</button>
            </div>
        </form>
    </body>
</html>