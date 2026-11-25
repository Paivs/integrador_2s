<?php

require_once __DIR__ . '/init.php';

$userLogado = $_SESSION['user'] ?? null;

$minDateTime = new DateTime();
if ($minDateTime->format('i') !== '00' || $minDateTime->format('s') !== '00') {
    $minDateTime->modify('+1 hour');
}
$minInput = $minDateTime->format('Y-m-d\TH:00');

if (isset($userLogado)) {
    $bancada = read(database(), 'Bancadas', 'id_bancada = ?', [$_GET['id']]);
    $idUsuario = $_SESSION['id'];

    $projetos = readAll(database(), "Projetos", "id_criador = ?", [$_SESSION['id']]);

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $horas = filter_var($_POST['valorHora'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => 12]]);
        $idBancada = $_GET['id'];
        $erro = null;

        try {
            $inicio = new DateTime($_POST['data_reserva'] ?? '');
        } catch (Exception $e) {
            $inicio = null;
        }

        $idsProjetosDoUsuario = array_column($projetos, 'id_projeto');
        $idProjeto = !empty($_POST['id_projeto']) ? $_POST['id_projeto'] : null;

        if ($horas === false) {
            $erro = "Quantidade de horas inválida.";
        } elseif ($inicio === null || $inicio < new DateTime()) {
            $erro = "Escolha uma data e hora futuras.";
        } elseif ($inicio->format('i') !== '00') {
            $erro = "Escolha uma hora cheia (sem minutos).";
        } elseif ($bancada['status_bancada'] !== 'disponivel') {
            $erro = "Esta bancada não está disponível.";
        } elseif ($idProjeto !== null && !in_array($idProjeto, $idsProjetosDoUsuario)) {
            $erro = "Projeto inválido.";
        }

        if ($erro) {
            header("Location: processaReserva.php?id=$idBancada&erro=" . urlencode($erro));
            exit;
        }

        $precoTotal = $bancada['preco_bancada'] * $horas; // multiplica para saber o preço total 
        $dataInicio = $inicio->format('Y-m-d H:i:s'); // formatação
        $fim = clone $inicio; // clona a hora inicial
        $fim->modify("+$horas hours");
        $dataFim = $fim->format('Y-m-d H:i:s');

        $reservas = readAll(database(), "Reservas", " id_bancada = ?", [$_GET['id']]);

        $ocupada = false;
        foreach ($reservas as $r) {
            $hours = $r['horas_reservadas'];
            $resInicio = new DateTime($r['data_reserva']);
            $resFim = clone $resInicio;
            $resFim->modify("+$hours hours");
            if ($resInicio < $fim && $resFim > $inicio) {
                $ocupada = true;
                break;
            }
        }
        if ($ocupada) {
            $msg = urlencode("Esta bancada já está reservada neste horário.");
            header("Location: processaReserva.php?id=$idBancada&erro=$msg");
            exit;
        } else {
            create(database(), "Reservas", [
                'data_reserva'     => $dataInicio,
                'horas_reservadas' => $horas,
                'preco_total'      => $precoTotal,
                'id_usuario'       => $idUsuario,
                'id_bancada'       => $_GET['id'],
                'id_projeto'       => $idProjeto
            ]);
            header("Location: processaReserva.php?id=$idBancada&sucesso=1");
            exit;
        }
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link rel="stylesheet" href="./css/processaReserva.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<?php if(isset($userLogado)){ ?>
<body>
    <?php require_once __DIR__ . '/nav.php' ?>
    <br>
    <br>
    <br>
    <div class="card">
        <div class="card-fotos">
            <img class="foto-principal" src="./img/index/bancadaEX.png" alt="">
            <div class="miniaturas">
                <img src="./img/index/bancadaEX.png" alt="">
                <img src="./img/index/bancadaEX.png" alt="">
                <img src="./img/index/bancadaEX.png" alt="">
            </div>
        </div>

        <div class="card-info">
            <h1><?= $bancada['nome_bancada'] ?></h1>
            <p class="descricao">
                <?= $bancada['descricao_bancada'] ?>
            </p>
            <p><i class="bi bi-people-fill"></i> Capacidade: <?= $bancada['quantidade_bancada'] ?> pessoas</p>
            <p><i class="bi bi-check-circle-fill"></i> <?= $bancada['primeira_vantagem'] ?></p>
            <p><i class="bi bi-check-circle-fill"></i> <?= $bancada['segunda_vantagem'] ?></p>
        </div>

        <div class="card-reserva">
            <p class="preco">R$<?= $bancada['preco_bancada'] ?><span>/ hora</span></p>

            <form action="" method="post">
                <div class="linha-valor">
                    <label for="id_projeto">Projeto:</label>
                    <select class="campo" name="id_projeto" id="id_projeto">
                        <option value="">Nenhum projeto (reserva avulsa)</option>
                        <?php foreach ($projetos as $p): ?>
                            <option value="<?= $p['id_projeto'] ?>"><?= $p['nome_projeto'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="linha-valor">
                    <label for="data_reserva">Data e Hora:</label>
                    <input class="campo" type="datetime-local" name="data_reserva" id="data_reserva" min="<?= $minInput ?>" step="3600" required>
                </div>

                <div class="linha-horas">
                    <label>Horas:</label>
                    <div class="linha-valor">
                        <label class="rotulo-valor" for="valorHora"></label>
                        <input class="campo campo-numero" type="number" name="valorHora" id="valorHora" min="1" max="12" step="1" required>
                    </div>
                </div>

                <button class="botao-salvar">Reservar <i class="bi bi-arrow-right"></i></button>
            </form>
            <?php if (isset($_GET['erro'])): ?>
                <p style="color: #ff4d4d; font-size: 0.9rem; margin-bottom: 10px;">
                    <?= htmlspecialchars($_GET['erro']) ?>
                </p>
            <?php endif; ?>
            <?php if (isset($_GET['sucesso'])): ?>
                <p style="color: #2e9e4f; font-size: 0.9rem; margin-bottom: 10px;">
                    Reserva realizada com sucesso!
                </p>
            <?php endif; ?>
        </div>

    </div>
<?php } else { ?>
<body>
    <?php require_once __DIR__ . '/nav.php' ?>
    <br>
    <br>
    <br>
    <div class="naoTemLogin">
        <div class="card-info">
            <h1>Faça login para reservar</h1>
            <p class="descricao">
                Para reservar uma bancada, você precisa estar logado na sua conta.
            </p>
            <a class="botao-salvar" href="./loginUsuario.php">Ir para o login <i class="bi bi-arrow-right"></i></a>
            <p>Não tem conta? <a href="./cadastroUser.php">Cadastre-se aqui!</a></p>
        </div>
    </div>
<?php } ?>
</body>

</html>