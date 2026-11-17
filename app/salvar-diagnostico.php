<?php

require_once __DIR__ . '/init.php';
protegerPagina();

if (!usuarioEhFuncionario() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: veiculos.php');
    exit;
}

$veiculoId = (int) ($_POST['veiculo_id'] ?? 0);
$problemas =$_POST['problemas'] ?? [];
$funcionarioId =$_SESSION['funcionario_id'] ?? null;

if ($veiculoId <= 0) {
    header('Location: veiculos.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmtDelete =$pdo->prepare('DELETE FROM veiculo_diagnosticos WHERE veiculo_id = ?');
    $stmtDelete->execute([$veiculoId]);

    if (is_array($problemas) && count($problemas) > 0) {
        $stmtInsert =$pdo->prepare(
            'INSERT INTO veiculo_diagnosticos (veiculo_id, codigo_falha_id, funcionario_id, situacao)
             VALUES (?, ?, ?, ?)'
        );

        foreach ($problemas as$codigoId) {
            $codigoId = (int)$codigoId;
            if ($codigoId > 0) {
                $stmtInsert->execute([$veiculoId, $codigoId,$funcionarioId, 'Com problema']);
            }
        }
    }

    $pdo->commit();
    header("Location: veiculos.php?diagnostico={$veiculoId}&mensagem=diagnostico_salvo#bloco-diagnostico");
    exit;
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {$pdo->rollBack();
    }
    header("Location: veiculos.php?diagnostico={$veiculoId}&mensagem=erro#bloco-diagnostico");
    exit;
}