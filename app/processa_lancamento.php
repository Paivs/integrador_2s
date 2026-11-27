<?php
    require_once __DIR__ . '/init.php';
$ambientes = readAll(database(), "ambientes");
$leituras = readAll(database(), "leituras");
$setores = readAll(database(), "setor");
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ambienteDado = $_POST['ambiente'];
$ambienteBanco = read(database(), "ambientes", "id = $ambienteDado");
$datahoraDado = $_POST['data_hora'];
$valorRelogioDado = $_POST['valor_relogio'];
$responsavelDado = $_POST['responsavel'];
$setorDado = $_POST['setor'];
$statusDado = $_POST['status_bloco'];
$dados = [
    'id' => null,
    'ambiente_id' => $ambienteBanco['id'],
    'usuario_id' => 1,
    'data_hora' => $datahoraDado,
    'leitura_acumulada_kwh' => $valorRelogioDado,
    'origem' => 'Manual',
    'area_m2_leitura' => $ambienteBanco['area_m2'],
    'codigo_medidor' => $ambienteBanco['codigo_medidor'],
    'estado_medidor_leituras' => $statusDado,
];
$troca = [
    'estado_medidor' => $statusDado,
];
create(database(), "leituras", $dados);
update(database(), "ambientes", $troca, "id=" . $ambienteBanco['id']); 
header("Location: lancamento_de_dados.php");
}
?>