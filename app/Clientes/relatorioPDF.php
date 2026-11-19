<?php

function buscarRegistro(PDO $pdo, int $id, int $usuario)
{
    $sql = "SELECT
                r.*,
                u.nome AS nome_usuario,
                f.nome AS nome_funcionario,
                a.nome AS nome_administrador,
                d.nome AS nome_departamento
            FROM registros r
            INNER JOIN usuarios u ON r.idUsuario = u.id
            LEFT JOIN funcionarios fu ON r.responsavel_Imediato = fu.idUsuario
            LEFT JOIN usuarios f ON fu.idUsuario = f.id
            LEFT JOIN administrador ad ON r.responsavel_acaoFinal = ad.idUsuario
            LEFT JOIN usuarios a ON ad.idUsuario = a.id
            LEFT JOIN departamentos d ON r.idDepartamento = d.id
            WHERE r.id = ? AND r.idUsuario = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $usuario]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function montarRelatorio(array $r): string
{
    $caminhoCSS = __DIR__ . '/css/relatorioPDF.css';
    $cssRelatorio = file_exists($caminhoCSS) ? file_get_contents($caminhoCSS) : '';

    $esc = function ($valor) {
        return htmlspecialchars((string)($valor ?? 'Não informado'), ENT_QUOTES, 'UTF-8');
    };

    $data = !empty($r['data_ocorrencia'])
        ? date('d/m/Y H:i', strtotime($r['data_ocorrencia']))
        : 'Não informada';

    $prazo = !empty($r['prazo'])
        ? date('d/m/Y', strtotime($r['prazo']))
        : 'Não informado';

    $dataVerificacao = !empty($r['data_verificacao'])
        ? date('d/m/Y', strtotime($r['data_verificacao']))
        : 'Não informada';

    $html = '
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <style>/*CSS_RELATORIO*/</style>
    </head>
    <body>
        <div class="cabecalho">
            <h1>ELECTROSAFE</h1>
            <p>RELATÓRIO DE NÃO CONFORMIDADE</p>
        </div>

        <h2>Identificação</h2>
        <div class="campo"><strong>Número do registro</strong>' . $esc($r['id']) . '</div>
        <div class="campo"><strong>Responsável pelo registro</strong>' . $esc($r['nome_usuario']) . '</div>
        <div class="campo"><strong>Data da ocorrência</strong>' . $esc($data) . '</div>
        <div class="campo"><strong>Departamento</strong>' . $esc($r['nome_departamento']) . '</div>

        <h2>Descrição da ocorrência</h2>
        <div class="campo"><strong>Descrição</strong>' . nl2br($esc($r['descricao'])) . '</div>
        <div class="campo"><strong>Local, equipamento e tipo</strong>' . $esc($r['origem_desvio']) . '</div>
        <div class="campo"><strong>Norma violada</strong>' . $esc($r['norma_violada']) . '</div>
        <div class="campo"><strong>Nível de impacto</strong>' . $esc($r['impacto_erro']) . '</div>
        <div class="campo"><strong>Status</strong>' . $esc($r['status_registro']) . '</div>

        <h2>Tratativas</h2>
        <div class="campo"><strong>Ação imediata</strong>' . nl2br($esc($r['acao_imediata'])) . '</div>
        <div class="campo"><strong>Análise e ação recomendada</strong>' . nl2br($esc($r['analise_erro'])) . '</div>
        <div class="campo"><strong>Responsável pela ação imediata</strong>' . $esc($r['nome_funcionario']) . '</div>
        <div class="campo"><strong>Responsável pela ação final</strong>' . $esc($r['nome_administrador']) . '</div>
        <div class="campo"><strong>Prazo para correção</strong>' . $esc($prazo) . '</div>

        <h2>Verificação e fechamento</h2>
        <div class="campo"><strong>Data de verificação</strong>' . $esc($dataVerificacao) . '</div>
        <div class="campo"><strong>Eficácia</strong>' . $esc($r['eficacia']) . '</div>
        <div class="campo"><strong>Observações de fechamento</strong>' . nl2br($esc($r['obs_fechamento'])) . '</div>

        <div class="rodape">
            ELECTROSAFE - Segurança e confiabilidade<br>
            Documento gerado pelo sistema.
        </div>
    </body>
    </html>';

    return str_replace('/*CSS_RELATORIO*/', $cssRelatorio, $html);
}
?>
