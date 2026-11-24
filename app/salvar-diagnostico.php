<?php

require_once __DIR__ . '/init.php';
protegerPagina();

if (!usuarioEhFuncionario() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: veiculos.php');
    exit;
}

$id = (int) ($_POST['veiculo_id'] ?? 0);
$dados = $_POST['situacoes'] ?? [];
$funcionario = $_SESSION['funcionario_id'] ?? null;

if ($id <= 0) {
    header('Location: veiculos.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $excluir = $pdo->prepare('DELETE FROM veiculo_diagnosticos WHERE veiculo_id = ?');
    $excluir->execute([$id]);

    if (is_array($dados) && count($dados) > 0) {
        $inserir = $pdo->prepare(
            'INSERT INTO veiculo_diagnosticos (veiculo_id, codigo_falha_id, funcionario_id, situacao)
             VALUES (?, ?, ?, ?)'
        );

        foreach ($dados as $codigo => $situacao) {
            $codigo = (int) $codigo;

            if ($codigo > 0 && in_array($situacao, ['Com problema', 'Tenha atenção'], true)) {
                $inserir->execute([$id, $codigo, $funcionario, $situacao]);
            }
        }
    }

    $pdo->commit();
    header("Location: veiculos.php?diagnostico={$id}&mensagem=diagnostico_salvo#bloco-diagnostico");
    exit;
} catch (Throwable $erro) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    header("Location: veiculos.php?diagnostico={$id}&mensagem=erro#bloco-diagnostico");
    exit;
}
