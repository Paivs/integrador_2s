
<?php
require_once __DIR__ . '/init.php';
require_once __DIR__ . '/banco/crud.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: registro.php');
    exit;
}

// Dados recebidos do formulário
$idUsuario = $_SESSION['idUsuario'] ?? null;

$descricao = trim($_POST['descricao'] ?? '');
$status = trim($_POST['status_registro'] ?? 'AGUARDANDO');
$data = trim($_POST['data_ocorrencia'] ?? '');
$idDepartamento = $_POST['idDepartamento'] ?? null;

$impacto = trim($_POST['impacto_erro'] ?? '');
$norma = trim($_POST['norma_violada'] ?? '');
$origem = trim($_POST['origem_desvio'] ?? '');

$acaoImediata = trim($_POST['acao_imediata'] ?? '');
$responsavelImediato = $_POST['responsavel_Imediato'] ?? null;
$prazo = trim($_POST['prazo'] ?? '');

$analise = trim($_POST['analise_erro'] ?? '');
$responsavelFinal = $_POST['responsavel_acaoFinal'] ?? null;
$prazoLimite = trim($_POST['prazo_limite'] ?? '');

$dataVerificacao = trim($_POST['data_verificacao'] ?? '');
$eficacia = trim($_POST['eficacia'] ?? '');
$obsFechamento = trim($_POST['obs_fechamento'] ?? '');

try {

    // Verifica os campos obrigatórios
    if (
        empty($idUsuario) ||
        empty($descricao) ||
        empty($impacto) ||
        empty($responsavelImediato) ||
        empty($responsavelFinal)
    ) {
        throw new Exception("Preencha todos os campos obrigatórios.");
    }

    // Monta os dados para inserir no banco
    $dadosRegistro = [
        'idUsuario' => $idUsuario,
        'descricao' => $descricao,
        'status_registro' => $status,
        'impacto_erro' => $impacto,
        'norma_violada' => $norma ?: null,
        'origem_desvio' => $origem ?: null,
        'acao_imediata' => $acaoImediata ?: null,
        'responsavel_Imediato' => $responsavelImediato,
        'prazo' => $prazo ?: null,
        'analise_erro' => $analise ?: null,
        'responsavel_acaoFinal' => $responsavelFinal,
        'prazo_limite' => $prazoLimite ?: null,
        'data_verificacao' => $dataVerificacao ?: null,
        'eficacia' => $eficacia ?: null,
        'obs_fechamento' => $obsFechamento ?: null,
        'idDepartamento' => $idDepartamento ?: null
    ];

    // Só envia a data se ela foi informada
    if (!empty($data)) {
        $dadosRegistro['data_ocorrencia'] = $data;
    }

    // Realiza o cadastro
    $create = create($pdo, 'registros', $dadosRegistro);

    header('Location: registro.php?tipoMensagem=sucesso');
    exit;

} catch (PDOException $e) {

    $mensagem = "Erro ao registrar: " . $e->getMessage();
    $tipoMensagem = "erro";

} catch (Exception $e) {

    $mensagem = $e->getMessage();
    $tipoMensagem = "erro";
}
?>
