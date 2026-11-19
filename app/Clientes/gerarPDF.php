<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/relatorioPDF.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$usuario = $_SESSION['idUsuario'] ?? null;

if (!$id || !$usuario) {
    die("Registro inválido ou sessão expirada.");
}

$registro = buscarRegistro($pdo, $id, (int)$usuario);

if (!$registro) {
    die("Registro não encontrado ou sem permissão.");
}

$options = new Options();
$options->set('isRemoteEnabled', false);
$options->set('defaultFont', 'DejaVu Sans');

$pdf = new Dompdf($options);
$pdf->loadHtml(montarRelatorio($registro), 'UTF-8');
$pdf->setPaper('A4', 'portrait');
$pdf->render();

$nomeArquivo = 'Relatorio_NC_' . $registro['id'] . '.pdf';

$pdf->stream($nomeArquivo, [
    'Attachment' => true
]);

exit;
?>