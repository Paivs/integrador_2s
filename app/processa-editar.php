<?php
require_once __DIR__ . '/init.php';

const DEBUG = true;
if (DEBUG) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
function falhar(string $mensagem, int $idLeitura = 0): void
{
    if (DEBUG) {
        echo '<pre style="font:14px monospace;padding:16px">';
        echo '<b>ERRO:</b> ' . htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') . "\n\n";
        echo '<b>POST recebido:</b>' . "\n";
        echo htmlspecialchars(print_r($_POST, true), ENT_QUOTES, 'UTF-8');
        echo '</pre>';
        exit;
    }
    error_log('processa-editar: ' . $mensagem);
    header('Location: ' . ($idLeitura > 0 ? "editar_leitura.php?id={$idLeitura}" : 'lancamento_de_dados.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: lancamento_de_dados.php');
    exit;
}

$idLeitura    = (int) ($_POST['id'] ?? 0);
$idAmbiente   = (int) ($_POST['ambiente'] ?? 0);
$idSetor      = (int) ($_POST['setor'] ?? 0);
$dataHora     = trim($_POST['data_hora'] ?? '');
$valorRelogio = trim($_POST['valor_relogio'] ?? '');
$responsavel  = trim($_POST['responsavel'] ?? '');
$statusBloco  = trim($_POST['status_bloco'] ?? '');

if ($idLeitura <= 0)  falhar('ID da leitura inválido.', $idLeitura);
if ($idAmbiente <= 0) falhar('Ambiente não informado.', $idLeitura);
if ($idSetor <= 0)    falhar('Setor não informado.', $idLeitura);
if ($responsavel === '') falhar('Responsável não informado.', $idLeitura);
if (!is_numeric($valorRelogio)) falhar('Valor do relógio inválido: "' . $valorRelogio . '"', $idLeitura);

$statusValidos = ['ATIVO', 'INTERFERÊNCIA', 'INATIVO'];
if (!in_array($statusBloco, $statusValidos, true)) {
    falhar('Status inválido: "' . $statusBloco . '" (confira se o arquivo está salvo em UTF-8).', $idLeitura);
}

$timestamp = strtotime($dataHora);
if ($dataHora === '' || $timestamp === false) {
    falhar('Data/hora inválida: "' . $dataHora . '"', $idLeitura);
}
$dataHoraBanco = date('Y-m-d H:i:s', $timestamp);

try {
    $pdo = database();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $leitura = read($pdo, 'leituras', 'id = ' . $idLeitura);
    if (!$leitura) {
        falhar("Leitura id {$idLeitura} não encontrada.", $idLeitura);
    }

    $ambiente = read($pdo, 'ambientes', 'id = ' . $idAmbiente);
    if (!$ambiente) {
        falhar("Ambiente id {$idAmbiente} não encontrado.", $idLeitura);
    }

    $dados = [
        'codigo_medidor'          => $ambiente['nome'],
        'data_hora'               => $dataHoraBanco,
        'leitura_acumulada_kwh'   => (float) $valorRelogio,
        'responsavel'             => $responsavel,
        'setor_id'                => $idSetor,
        'estado_medidor_leituras' => $statusBloco,
    ];

    $colunasExistentes = $pdo->query('SHOW COLUMNS FROM `leituras`')->fetchAll(PDO::FETCH_COLUMN);
    $ignoradas = array_diff(array_keys($dados), $colunasExistentes);
    $dados     = array_intersect_key($dados, array_flip($colunasExistentes));

    if (DEBUG && $ignoradas) {
        echo '<pre style="font:14px monospace;padding:16px;background:#fff3cd">';
        echo 'ATENÇÃO: estas colunas NÃO existem em "leituras" e foram ignoradas: '
            . implode(', ', $ignoradas) . "\n";
        echo 'Colunas reais da tabela: ' . implode(', ', $colunasExistentes) . '</pre>';
    }

    update($pdo, 'leituras', $dados, 'id = ?', [$idLeitura]);

} catch (Throwable $e) {
    falhar('Erro no banco: ' . $e->getMessage(), $idLeitura);
}
header('Location: lancamento_de_dados.php');
exit;