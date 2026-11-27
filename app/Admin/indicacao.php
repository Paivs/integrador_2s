<?php
declare(strict_types=1);

$databaseStatus = 'Conectado';

try {
    require_once __DIR__ . '../banco/database.php';
    require_once __DIR__ . '../banco/crud.php';

    $pdo = database();
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $databaseStatus = 'Indisponível';
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome           = trim((string)($_POST['nome'] ?? ''));
    $especializacao = trim((string)($_POST['especializacao'] ?? ''));
    $nascimento     = (string)($_POST['data_nascimento'] ?? '');

    $dataValida = DateTime::createFromFormat('Y-m-d', $nascimento);
    $maior18    = $dataValida && $dataValida <= new DateTime('-18 years');

    if ($databaseStatus !== 'Conectado') {
        $mensagem = 'Banco de dados indisponível. Tente novamente mais tarde.';
    } elseif ($nome === '' || $especializacao === '' || !$dataValida) {
        $mensagem = 'Preencha todos os campos.';
    } elseif (!$maior18) {
        $mensagem = 'O eletricista precisa ter 18 anos ou mais.';
    } else {
        try {
            $pdo->beginTransaction();

            $unico = bin2hex(random_bytes(5));

            $idUsuario = (int)create($pdo, 'usuarios', [
                'nome'            => $nome,
                'data_nascimento' => $nascimento,
                'email'           => $unico . '@electrosafe.local',
                'cpf'             => substr((string)hexdec(substr($unico, 0, 8)) . '00000000000', 0, 11),
                'senha'           => password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT),
            ]);

            create($pdo, 'funcionarios', [
                'idUsuario'      => $idUsuario,
                'especializacao' => $especializacao,
            ]);

            $pdo->commit();

            header('Location: infoEle.php');
            exit;
        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log($e->getMessage());
            $mensagem = 'Não foi possível salvar. Tente novamente.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ElectroSafe - Novo Eletricista</title>
    <link rel="stylesheet" href="styleIndicacaoAdmin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="layout-principal">
        <aside class="barra-menu">
            <a href="index.php" title="Ir para a página inicial">
                <img src="imagens/logo.png" alt="Logo ElectroSafe">
            </a>
            <div class="barra-menu-cabeca">
                <i></i>
                <div class="logo">
                    <span><span class="corElectro">Electro</span><strong><span class="corSafe">Safe</span></strong></span>
                </div>
            </div>

            <nav class="nav">
                <a href="index.php" class="nav-item">
                    <i></i>
                    <span>Início</span>
                </a>
                <a href="acompanhamento.php" class="nav-item">
                    <i></i>
                    <span>Acompanhamento</span>
                </a>
                <a href="indicacao.php" class="nav-item active">
                    <i></i>
                    <span>Novo Eletricista</span>
                </a>
                <a href="infoEle.php" class="nav-item">
                    <i></i>
                    <span>Informações dos Eletricistas</span>
                </a>
            </nav>
        </aside>

        <main>
            <header>
                <h1>CADASTRAR NOVO ELETRICISTA</h1>
            </header>

            <div id="formulario">
                <form action="" method="POST" id="formCadastro">

                    <h2>DADOS DO ELETRICISTA</h2>

                    <?php if ($mensagem !== ''): ?>
                        <p><?= htmlspecialchars($mensagem) ?></p>
                    <?php endif; ?>


                    <label for="nome" class="passo-um">Nome:</label>
                    <input type="text" name="nome" id="nome" placeholder="Nome completo" required>

                    <label for="data_nascimento" class="passo-um">Data de nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required>

                    <label for="especializacao" class="passo-um">Especialização:</label>
                    <input type="text" name="especializacao" id="especializacao" placeholder="Ex.: Instalações residenciais" required>

                    <button type="submit">Cadastrar</button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>


