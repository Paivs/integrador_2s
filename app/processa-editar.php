<?php
require_once __DIR__ . '/init.php';

$id         = (int) ($_POST['id'] ?? 0);
$idAmbiente = (int) ($_POST['ambiente'] ?? 0);

$ambiente = read(database(), 'ambientes', 'id = ' . $idAmbiente);

update(
    database(),
    'leituras',
    [
        'ambiente_id'             => $idAmbiente,
        'codigo_medidor'          => $ambiente['nome'],
        'data_hora'               => date('Y-m-d H:i:s', strtotime($_POST['data_hora'])),
        'leitura_acumulada_kwh'   => $_POST['valor_relogio'],
        'estado_medidor_leituras' => $_POST['status_bloco'],
    ],
    'id = ?',
    [$id]
);

header('Location: lancamento_de_dados.php');
exit;
?>