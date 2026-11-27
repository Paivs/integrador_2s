<?php
declare(strict_types=1);

/*
 * processaRegistro.php
 * Recebe registro.php, valida tudo e grava somente colunas existentes em
 * registros. Não altera o banco de dados.
 */
require_once __DIR__ . '/init.php';

if (!isset($pdo) || !($pdo instanceof PDO)) {
    throw new RuntimeException('A conexão PDO não foi encontrada em init.php.');
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function voltarFormulario(array $dados, array $erros): never
{
    $_SESSION['registro_form'] = $dados;
    $_SESSION['registro_erros'] = $erros;
    header('Location: registro.php');
    exit;
}

function redirecionarErro(string $mensagem): never
{
    header('Location: registro.php?erro=' . rawurlencode($mensagem));
    exit;
}

function idExiste(PDO $pdo, string $tabela, string $coluna, int $id): bool
{
    $permitidos = [
        'usuarios'      => ['id'],
        'departamentos' => ['id'],
        'funcionarios'  => ['idUsuario'],
        'administrador' => ['idUsuario'],
    ];

    if (!isset($permitidos[$tabela]) || !in_array($coluna, $permitidos[$tabela], true)) {
        return false;
    }

    $stmt = $pdo->prepare("SELECT 1 FROM {$tabela} WHERE {$coluna} = ? LIMIT 1");
    $stmt->execute([$id]);
    return (bool) $stmt->fetchColumn();
}

function dataBanco(?string $valor, bool $obrigatoria = false): ?string
{
    $valor = trim((string) $valor);

    if ($valor === '') {
        return $obrigatoria ? null : null;
    }

    // O formulário atual usa input type="date".
    $data = DateTimeImmutable::createFromFormat('!Y-m-d', $valor);
    $erros = DateTimeImmutable::getLastErrors();
    $comErro = is_array($erros) && ($erros['warning_count'] > 0 || $erros['error_count'] > 0);

    if (!$data || $comErro || $data->format('Y-m-d') !== $valor) {
        return null;
    }

    return $data->format('Y-m-d');
}

function dataHoraBanco(?string $data, ?string $hora): ?string
{
    $data = trim((string) $data);
    $hora = trim((string) $hora);

    if ($data === '') {
        return null;
    }

    if ($hora === '') {
        $hora = '00:00';
    }

    if (!preg_match('/^\d{2}:\d{2}$/', $hora)) {
        return null;
    }

    $dataHora = DateTimeImmutable::createFromFormat('!Y-m-d H:i', $data . ' ' . $hora);
    $erros = DateTimeImmutable::getLastErrors();
    $comErro = is_array($erros) && ($erros['warning_count'] > 0 || $erros['error_count'] > 0);

    if (!$dataHora || $comErro || $dataHora->format('Y-m-d H:i') !== $data . ' ' . $hora) {
        return null;
    }

    return $dataHora->format('Y-m-d H:i:s');
}

function colunasRegistros(PDO $pdo): array
{
    $resultado = [];
    $linhas = $pdo->query('SHOW COLUMNS FROM registros')->fetchAll(PDO::FETCH_ASSOC);
    foreach ($linhas as $linha) {
        if (!empty($linha['Field'])) {
            $resultado[(string) $linha['Field']] = true;
        }
    }
    return $resultado;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registro.php');
    exit;
}

$tokenSessao = (string) ($_SESSION['csrf_registro'] ?? '');
$tokenPost = (string) ($_POST['csrf_token'] ?? '');
if ($tokenSessao === '' || $tokenPost === '' || !hash_equals($tokenSessao, $tokenPost)) {
    redirecionarErro('Sessão expirada. Atualize a página e envie o formulário novamente.');
}

$idUsuario = (int) ($_SESSION['idUsuario'] ?? 0);

$dados = [
    'data_ocorrencia'       => trim((string) ($_POST['data_ocorrencia'] ?? '')),
    'hora_ocorrencia'       => trim((string) ($_POST['hora_ocorrencia'] ?? '')),
    'idDepartamento'        => trim((string) ($_POST['idDepartamento'] ?? '')),
    'local'                 => trim((string) ($_POST['local'] ?? '')),
    'equipamento'           => trim((string) ($_POST['equipamento'] ?? '')),
    'norma_violada'         => trim((string) ($_POST['norma_violada'] ?? '')),
    'status_registro'       => trim((string) ($_POST['status_registro'] ?? 'AGUARDANDO')),
    'impacto_erro'          => trim((string) ($_POST['impacto_erro'] ?? '')),
    'descricao'             => trim((string) ($_POST['descricao'] ?? '')),
    'acao_imediata'         => trim((string) ($_POST['acao_imediata'] ?? '')),
    'responsavel_Imediato'  => trim((string) ($_POST['responsavel_Imediato'] ?? '')),
    'prazo'                 => trim((string) ($_POST['prazo'] ?? '')),
    'analise_erro'          => trim((string) ($_POST['analise_erro'] ?? '')),
    'responsavel_acaoFinal' => trim((string) ($_POST['responsavel_acaoFinal'] ?? '')),
    'prazo_limite'          => trim((string) ($_POST['prazo_limite'] ?? '')),
    'data_verificacao'      => trim((string) ($_POST['data_verificacao'] ?? '')),
    'eficacia'              => trim((string) ($_POST['eficacia'] ?? '')),
    'obs_fechamento'        => trim((string) ($_POST['obs_fechamento'] ?? '')),
];

$erros = [];

if ($idUsuario <= 0 || !idExiste($pdo, 'usuarios', 'id', $idUsuario)) {
    $erros[] = 'Usuário logado inválido. Faça login novamente.';
}

$dataOcorrencia = dataHoraBanco($dados['data_ocorrencia'], $dados['hora_ocorrencia']);
if ($dataOcorrencia === null) {
    $erros[] = 'Informe uma data de ocorrência válida.';
}

if ($dados['local'] === '' || mb_strlen($dados['local']) > 100) {
    $erros[] = 'Informe um local com até 100 caracteres.';
}

if ($dados['equipamento'] === '' || mb_strlen($dados['equipamento']) > 95) {
    $erros[] = 'Informe um equipamento ou instalação com até 95 caracteres.';
}

if ($dados['descricao'] === '' || mb_strlen($dados['descricao']) < 10) {
    $erros[] = 'A descrição deve ter pelo menos 10 caracteres.';
}

if (mb_strlen($dados['norma_violada']) > 200) {
    $erros[] = 'A norma violada deve ter no máximo 200 caracteres.';
}

$opcoesStatus = ['AGUARDANDO', 'ANDAMENTO', 'FINALIZADO', 'CANCELADO'];
$opcoesImpacto = ['LEVE', 'MODERADO', 'CRITICO'];
$opcoesEficacia = ['', 'SIM', 'NÃO'];

if (!in_array($dados['status_registro'], $opcoesStatus, true)) {
    $erros[] = 'Status do registro inválido.';
}

if (!in_array($dados['impacto_erro'], $opcoesImpacto, true)) {
    $erros[] = 'Selecione um nível de risco válido.';
}

if ($dados['idDepartamento'] !== '') {
    $idDepartamento = (int) $dados['idDepartamento'];
    if ($idDepartamento <= 0 || !idExiste($pdo, 'departamentos', 'id', $idDepartamento)) {
        $erros[] = 'Departamento inválido.';
    }
}

$idResponsavelImediato = (int) $dados['responsavel_Imediato'];
if ($idResponsavelImediato <= 0 || !idExiste($pdo, 'funcionarios', 'idUsuario', $idResponsavelImediato)) {
    $erros[] = 'Selecione um funcionário válido para a ação imediata.';
}

$idResponsavelFinal = (int) $dados['responsavel_acaoFinal'];
if ($idResponsavelFinal <= 0 || !idExiste($pdo, 'administrador', 'idUsuario', $idResponsavelFinal)) {
    $erros[] = 'Selecione um administrador válido para a ação final.';
}

foreach (['prazo', 'prazo_limite', 'data_verificacao'] as $campo) {
    if ($dados[$campo] !== '' && dataBanco($dados[$campo]) === null) {
        $erros[] = 'A data informada em ' . $campo . ' é inválida.';
    }
}

if (!in_array($dados['eficacia'], $opcoesEficacia, true)) {
    $erros[] = 'Valor de eficácia inválido.';
}

if (!empty($erros)) {
    voltarFormulario($dados, $erros);
}

/*
 * `local` e `equipamento` não existem na tabela registros fornecida.
 * Por isso são incorporados à descrição, sem alterar o banco.
 */
$descricaoCompleta = 'Local: ' . $dados['local'] . PHP_EOL
    . 'Equipamento/instalação: ' . $dados['equipamento'] . PHP_EOL . PHP_EOL
    . $dados['descricao'];

$colunasExistentes = colunasRegistros($pdo);
$dadosBanco = [
    'idUsuario'             => $idUsuario,
    'descricao'             => $descricaoCompleta,
    'status_registro'       => $dados['status_registro'],
    'data_ocorrencia'       => $dataOcorrencia,
    'idDepartamento'        => $dados['idDepartamento'] === '' ? null : (int) $dados['idDepartamento'],
    'impacto_erro'          => $dados['impacto_erro'],
    'norma_violada'         => $dados['norma_violada'] === '' ? null : $dados['norma_violada'],
    'origem_desvio'         => null,
    'acao_imediata'         => $dados['acao_imediata'] === '' ? null : $dados['acao_imediata'],
    'responsavel_Imediato'  => $idResponsavelImediato,
    'prazo'                 => $dados['prazo'] === '' ? null : dataBanco($dados['prazo']) . ' 00:00:00',
    'analise_erro'          => $dados['analise_erro'] === '' ? null : $dados['analise_erro'],
    'responsavel_acaoFinal' => $idResponsavelFinal,
    'prazo_limite'          => $dados['prazo_limite'] === '' ? null : dataBanco($dados['prazo_limite']) . ' 00:00:00',
    'data_verificacao'      => $dados['data_verificacao'] === '' ? null : dataBanco($dados['data_verificacao']) . ' 00:00:00',
    'eficacia'              => $dados['eficacia'] === '' ? null : $dados['eficacia'],
    'obs_fechamento'        => $dados['obs_fechamento'] === '' ? null : $dados['obs_fechamento'],
];

$colunas = [];
$marcadores = [];
$parametros = [];

foreach ($dadosBanco as $coluna => $valor) {
    if (!isset($colunasExistentes[$coluna])) {
        continue;
    }
    $colunas[] = $coluna;
    $marcadores[] = ':' . $coluna;
    $parametros[':' . $coluna] = $valor;
}

$obrigatorias = ['idUsuario', 'descricao', 'status_registro', 'data_ocorrencia', 'impacto_erro', 'responsavel_Imediato', 'responsavel_acaoFinal'];
foreach ($obrigatorias as $obrigatoria) {
    if (!in_array($obrigatoria, $colunas, true)) {
        redirecionarErro('A tabela registros não possui a coluna obrigatória: ' . $obrigatoria);
    }
}

try {
    $pdo->beginTransaction();

    $sql = 'INSERT INTO registros (' . implode(', ', $colunas) . ') VALUES (' . implode(', ', $marcadores) . ')';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);
    $id = (int) $pdo->lastInsertId();

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Erro ao inserir não conformidade: ' . $e->getMessage());
    voltarFormulario($dados, ['Não foi possível salvar o registro no banco. Verifique a configuração e tente novamente.']);
}

header('Location: registro.php?sucesso=' . $id);
exit;
