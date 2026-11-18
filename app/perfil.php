<?php

require_once __DIR__ . '/init.php';

if (empty($_SESSION['id'])) {
    header("Location: loginUsuario.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])) {

    update(database(), "Usuarios", [
        "nome_usuario" => "{$_POST['nome_usuario']}",
        "telefone" => "{$_POST['telefone']}",
        "email" => "{$_POST['email']}",
        "instituicao" => "{$_POST['instituicao']}"
    ], "id_usuario = ?", [$_SESSION['id']]);

    $_SESSION['user'] = $_POST['nome_usuario'];
    header("Location: perfil.php");
    exit;
}

$usuario = read(database(), "Usuarios", "id_usuario = ?", [$_SESSION['id']]);

if (!$usuario) {
    header("Location: logout.php");
    exit;
}

$reservaUsuario = readAll(database(), "Reservas", "id_usuario = ?", [$_SESSION['id']]);
$bancada = readAll(database(), "Bancadas", "id_bancada", []);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu perfil</title>
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
                <img class="perfil-foto" src="./img/cabecalho/usuario.png" alt="Foto do usuário">
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
                    <div class="caixa-tabela">
                        <?php if (!empty($reservaUsuario)): ?>
                            <?php foreach ($reservaUsuario as $reserva): ?>
                                <tr>
                                    <td><?= $reserva['data_reserva'] ?></td>
                                    <td><?= $reserva['horas_reservadas'] ?></td>
                                    <td>R$ <?= number_format($reserva['preco_total'], 2, ',', '.') ?></td>
                                    <td><?php $bancadaUser = read(database(), "Bancadas", "id_bancada = ?", [$reserva['id_bancada']]);
                                        echo $bancadaUser['nome_bancada'];
                                        ?></td>
                                    <td><?php $projetoUser = read(database(), "Projetos", "id_projeto = ?", [$reserva['id_projeto']]);
                                        echo $projetoUser['nome_projeto'];
                                        ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Você ainda não possui reservas.</td>
                            </tr>
                        <?php endif; ?>
                    </div>

                </tbody>
            </table>

        </div>
    </main>

    <?php require_once __DIR__ . '/footer.php' ?>
</body>

</html>