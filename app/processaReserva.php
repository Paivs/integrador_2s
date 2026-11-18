<?php

require_once __DIR__ . '/init.php';

$pdo = database();
$bancada = read($pdo, 'Bancadas', 'id_bancada = ?', [$_GET['id']]);
$idUsuario = $_SESSION['id'];

$projetos = readAll(database(), "Projetos", "id_criador = ?", [$_SESSION['id']]);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $horas = $_POST['valorHora'];
    $precoTotal = $bancada['preco_bancada'] * $horas; // multiplica para saber o preço total 
    $inicio = new DateTime($_POST['data_reserva']); // converte o que vem do html para um formato de horas igual ao do sql
    $dataInicio = $inicio->format('Y-m-d H:i:s'); // formatação
    $fim = clone $inicio; // clona a hora inicial
    $fim->modify("+$horas hours");
    $dataFim = $fim->format('Y-m-d H:i:s');

    $reservas = readAll(database(), "Reservas", " id_bancada = ?", [$_GET['id']]);

    $ocupadas = 0;
    foreach ($reservas as $r) {
        $hours = $r['horas_reservadas'];
        $resInicio = new DateTime($r['data_reserva']);
        $resFim = clone $resInicio;
        $resFim->modify("+$hours hours");
        if ($resInicio < $fim && $resFim > $inicio) {
            $ocupadas++;
        }
    }
    if ($ocupadas >= $bancada['quantidade_bancada']) {
        $idBancada = $_GET['id'];
        $msg = urlencode("Não há reservas disponíveis para este horário.");
        header("Location: processaReserva.php?id=$idBancada&erro=$msg");
        exit;
    } else {
        $idProjeto = !empty($_POST['id_projeto']) ? $_POST['id_projeto'] : null;

        create(database(), "Reservas", [
            'data_reserva'     => $dataInicio,
            'horas_reservadas' => $horas,
            'preco_total'      => $precoTotal,
            'id_usuario'       => $idUsuario,
            'id_bancada'       => $_GET['id'],
            'id_projeto'       => $_POST['id_projeto']
        ]);
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
            <p><i class="bi bi-people-fill"></i> Capacidade: <?= $bancada['quantidade_bancada'] ?> bancadas</p>
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
                    <input class="campo" type="datetime-local" name="data_reserva" id="data_reserva" required>
                </div>

                <div class="linha-horas">
                    <label>Horas:</label>
                    <div class="linha-valor">
                        <label class="rotulo-valor" for="valorHora"></label>
                        <input class="campo campo-numero" type="number" name="valorHora" id="valorHora" min="1" step="1" required>
                    </div>
                </div>

                <button class="botao-salvar">Reservar <i class="bi bi-arrow-right"></i></button>
            </form>
            <?php if (isset($_GET['erro'])): ?>
                <p style="color: #ff4d4d; font-size: 0.9rem; margin-bottom: 10px;">
                    <?= htmlspecialchars($_GET['erro']) ?>
                </p>
            <?php endif; ?>
        </div>

    </div>

</body>

</html>