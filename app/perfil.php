<?php

require_once __DIR__ . '/init.php';

if (empty($_SESSION['id'])) {
    header("Location: loginUsuario.php");
    exit;
}

$pdo = database();
$usuario = read($pdo, "Usuarios", "id_usuario = ?", [$_SESSION['id']]);

if (!$usuario) {
    header("Location: logout.php");
    exit;
}

$imagemPerfil = glob(__DIR__ . "/img/pfp/*.{png,jpg,jpeg}", GLOB_BRACE) ?: [];

if ($usuario['imagens_usuario'] == "padrao") {
    $usuario['imagens_usuario'] = "img/cabecalho/usuario.png";
}
$_SESSION['imagem'] = $usuario['imagens_usuario'];

// 1. Atualiza dados pessoais do perfil
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id'])) {

    if (!isset($_POST['imagem_selecionada']) || $_POST['imagem_selecionada'] === "") {
        $_POST['imagem_selecionada'] = $usuario['imagens_usuario'];
    }

    update($pdo, "Usuarios", [
        "nome_usuario"    => $_POST['nome_usuario'],
        "telefone"        => $_POST['telefone'],
        "email"           => $_POST['email'],
        "instituicao"     => $_POST['instituicao'],
        "imagens_usuario" => $_POST['imagem_selecionada']
    ], "id_usuario = ?", [$_SESSION['id']]);

    $_SESSION['user'] = $_POST['nome_usuario'];
    $_SESSION['imagem'] = $_POST['imagem_selecionada'];
    header("Location: perfil.php");
    exit;
}

// 2. Vincula um projeto criado pelo usuário a uma reserva sem projeto
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['id_reserva_vincular'], $_POST['id_projeto_vincular'])) {
    $idReservaVincular = $_POST['id_reserva_vincular'];
    $idProjetoVincular = $_POST['id_projeto_vincular'];

    if (!empty($idReservaVincular) && !empty($idProjetoVincular)) {
        $projetoCriado = read(
            $pdo,
            "Projetos",
            "id_projeto = ? AND id_criador = ?",
            [$idProjetoVincular, $_SESSION['id']]
        );

        if ($projetoCriado) {
            update(
                $pdo,
                "Reservas",
                ["id_projeto" => $idProjetoVincular],
                "id_reserva = ? AND id_usuario = ?",
                [$idReservaVincular, $_SESSION['id']]
            );
        }
    }

    header("Location: perfil.php");
    exit;
}

$_SESSION['reservaUsuario'] = readAll($pdo, "Reservas", "id_usuario = ?", [$_SESSION['id']]);
$meusProjetos = readAll($pdo, "Projetos", "id_criador = ?", [$_SESSION['id']]);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MakerLab - Meu Perfil</title>
    <link rel="stylesheet" href="./css/perfil.css">
</head>

<body>
    <?php require_once __DIR__ . '/nav.php' ?>
    <br>
    <br>
    <main class="perfil-pagina">
        <div class="perfil-card">

            <header class="perfil-cabecalho">
                <h1>Meu Perfil</h1>
                <p>Gerencie suas informações pessoais e preferências.</p>
            </header>

            <section class="perfil-usuario">
                <img class="perfil-foto" src="<?= $usuario['imagens_usuario'] ?>" alt="Foto do usuário">
                <div class="perfil-dados">
                    <b>User:</b>
                    <span><?= $usuario['nome_usuario'] ?></span>
                    <b>Email:</b>
                    <span><?= $usuario['email'] ?></span>
                </div>
            </section>

            <section class="perfil-secao">
                <h2>Informações pessoais</h2>
                <form class="perfil-form" action="" method="post">
                    <input type="text" name="id" value="<?= $_SESSION['id'] ?>" hidden>

                    <div class="campo">
                        <label for="nome">Nome de usuário:</label>
                        <input type="text" id="nome" name="nome_usuario" value="<?= $usuario['nome_usuario'] ?>">
                    </div>

                    <div class="campo">
                        <label for="telefone">Telefone</label>
                        <input type="tel" id="telefone" name="telefone" value="<?= $usuario['telefone'] ?? '' ?>">
                    </div>

                    <div class="campo">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?= $usuario['email'] ?>">
                    </div>

                    <div class="campo">
                        <label for="instituicao">Instituição</label>
                        <input type="text" id="instituicao" name="instituicao" value="<?= $usuario['instituicao'] ?? '' ?>">
                    </div>

                    <details class='trocarImagem'>
                        <summary>Imagem de perfil</summary>
                        <?php foreach ($imagemPerfil as $imagem): ?>
                            <button type="submit" class="menuImagem" name="imagem_selecionada" value="img/pfp/<?php echo basename($imagem) ?>">
                                <img src="img/pfp/<?php echo basename($imagem) ?>" alt="">
                            </button>
                        <?php endforeach; ?>
                    </details>
                    <button type="submit" class="botao-salvar">Salvar alterações</button>
                </form>
            </section>

            <br>

            <header class="perfil-cabecalho">
                <h1>Minhas reservas:</h1>
                <p>Veja suas bancadas reservadas e suas informações.</p>
            </header>

            <table class="tabelaReservas">
                <thead>
                    <tr>
                        <th>Data Reserva:</th>
                        <th>Horas Reservadas:</th>
                        <th>Preço Total:</th>
                        <th>Bancada:</th>
                        <th>Projeto:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($_SESSION['reservaUsuario'])): ?>
                        <?php foreach ($_SESSION['reservaUsuario'] as $reserva): ?>
                            <tr>
                                <td><?= $reserva['data_reserva'] ?></td>
                                <td><?= $reserva['horas_reservadas'] ?></td>
                                <td>R$ <?= number_format($reserva['preco_total'], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $bancadaUser = read($pdo, "Bancadas", "id_bancada = ?", [$reserva['id_bancada']]);
                                    echo $bancadaUser['nome_bancada'] ?? '';
                                    ?>
                                </td>
                                <td>
                                    <?php if (!empty($reserva['id_projeto'])): ?>
                                        <?php $projetoUser = read($pdo, "Projetos", "id_projeto = ?", [$reserva['id_projeto']]); ?>
                                        <?= htmlspecialchars($projetoUser['nome_projeto'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                    <?php else: ?>
                                        <span>Sem projetos.</span>

                                        <?php if (!empty($meusProjetos)): ?>
                                            <form action="" method="POST" style="margin-top: 4px;">
                                                <input type="hidden" name="id_reserva_vincular" value="<?= $reserva['id_reserva'] ?>">
                                                <select name="id_projeto_vincular" required>
                                                    <option value="">Selecionar projeto...</option>
                                                    <?php foreach ($meusProjetos as $projOpcao): ?>
                                                        <option value="<?= $projOpcao['id_projeto'] ?>">
                                                            <?= htmlspecialchars($projOpcao['nome_projeto'], ENT_QUOTES, 'UTF-8') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit">Vincular</button>
                                            </form>
                                        <?php endif; ?>

                                        <div style="margin-top: 4px;">
                                            <a href="criarProjeto.php?id_reserva=<?= $reserva['id_reserva'] ?>">
                                                <button type="button">Criar novo projeto</button>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Você ainda não possui reservas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <br>

            <header class="perfil-cabecalho">
                <h1>Meus projetos:</h1>
                <p>Projetos criados por você.</p>
            </header>

            <table class="tabelaReservas">
                <thead>
                    <tr>
                        <th>Nome do Projeto:</th>
                        <th>Descrição:</th>
                        <th>Imagem:</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($meusProjetos)): ?>
                        <?php foreach ($meusProjetos as $proj): ?>
                            <tr>
                                <td><?= htmlspecialchars($proj['nome_projeto'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($proj['descricao_projeto'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td>
                                    <?php if (!empty($proj['imagem_projeto'])): ?>
                                        <img src="<?= htmlspecialchars($proj['imagem_projeto'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($proj['nome_projeto'], ENT_QUOTES, 'UTF-8') ?>" style="max-width: 80px;">
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Você ainda não criou nenhum projeto.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </main>

    <?php require_once __DIR__ . '/footer.php' ?>
</body>

</html>