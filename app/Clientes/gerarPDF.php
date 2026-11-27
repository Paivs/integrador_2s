
<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/relatorioPDF.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$idUsuario = $_SESSION['idUsuario'] ?? null;
$idRegistro = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$idUsuario || !$idRegistro) {
    exit('Registro inválido ou usuário não autenticado.');
}

$registro = buscarRegistro($pdo, (int)$idRegistro, (int)$idUsuario);

if (!$registro) {
    exit('Registro não encontrado.');
}

$options = new Options();
$options->set('isRemoteEnabled', false);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'DejaVu Sans');

$pdf = new Dompdf($options);
$pdf->loadHtml(montarRelatorio($registro), 'UTF-8');
$pdf->setPaper('A4', 'portrait');
$pdf->render();

if (ob_get_length()) {
    ob_end_clean();
}

$pdf->stream('Relatorio_ElectroSafe_' . $idRegistro . '.pdf', [
    'Attachment' => true
]);
