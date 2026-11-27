
<?php

require_once __DIR__ . '/init.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/relatorioPDF.php';
require_once __DIR__ . '/../../vendor/autoload.php';    

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;

$idUsuario = $_SESSION['idUsuario'] ?? null;
$idRegistro = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if (!$idUsuario || !$idRegistro) {
    exit('Dados inválidos.');
}

try {

    // Busca o registro no banco
    $registro = buscarRegistro($pdo, (int)$idRegistro, (int)$idUsuario);

    if (!$registro) {
        throw new Exception('Registro não encontrado.');
    }

    // Gera o PDF
    $options = new Options();
    $options->set('isRemoteEnabled', false);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans');

    $pdf = new Dompdf($options);
    $pdf->loadHtml(montarRelatorio($registro), 'UTF-8');
    $pdf->setPaper('A4', 'portrait');
    $pdf->render();

    $arquivoPDF = $pdf->output();

    // Configuração do e-mail
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = getenv('SMTP_HOST');
    $mail->SMTPAuth = true;
    $mail->Username = getenv('SMTP_USER');
    $mail->Password = getenv('SMTP_PASS');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = (int)(getenv('SMTP_PORT') ?: 587);

    $mail->CharSet = 'UTF-8';

    $mail->setFrom(
        getenv('SMTP_USER'),
        'ELECTROSAFE'
    );

    // Destinatário: endereço configurado no servidor
    $destino = getenv('EMAIL_DESTINO') ?: getenv('SMTP_USER');

    if (!$destino || !filter_var($destino, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('E-mail de destino inválido.');
    }

    $mail->addAddress($destino);

    $mail->isHTML(true);
    $mail->Subject = 'Relatório de não conformidade - ElectroSafe';
    $mail->Body = '
        <h2>ElectroSafe</h2>
        <p>Segue em anexo o relatório de não conformidade.</p>
        <p>Número do registro: ' . (int)$idRegistro . '</p>
    ';

    $mail->AltBody = 'Segue em anexo o relatório de não conformidade.';

    // Anexa o PDF
    $mail->addStringAttachment(
        $arquivoPDF,
        'Relatorio_ElectroSafe_' . $idRegistro . '.pdf',
        'base64',
        'application/pdf'
    );

    $mail->send();

    header('Location: registro.php?sucesso=' . (int)$idRegistro . '&email=ok');
    exit;

} catch (Throwable $e) {

    error_log('Erro ao enviar relatório: ' . $e->getMessage());

    header('Location: registro.php?sucesso=' . (int)$idRegistro . '&email=erro');
    exit;
}
