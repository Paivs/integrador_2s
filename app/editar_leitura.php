<?php
require_once __DIR__ . '/init.php';


$idLeitura = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($idLeitura <= 0) {
    header('Location: lancamento_de_dados.php');
    exit;
}

$ambientes = readAll(database(), "ambientes");
$setores   = readAll(database(), "setor");
$leitura   = read(database(), "leituras", "id = {$idLeitura}");

if (!$leitura) {
    header('Location: lancamento_de_dados.php');
    exit;
}

$dataHoraInput = date('Y-m-d\TH:i', strtotime($leitura['data_hora']));

function e($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/styleEditar.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title>Editar Lançamento</title>
</head>

<body>
    <div class="menu-conf">
        <?php require_once __DIR__ . '/menuLateral.php'; ?>

        <div class="conteudo">
            <h1>Editar Lançamento <?= e($leitura['codigo_medidor']) ?></h1>

            <div class="form-editar">

                <form action="processa-editar.php" method="post" autocomplete="off">
  
                    <input type="hidden" name="id" value="<?= $idLeitura ?>">

                    <div class="box-formulario">
                        <div class="formulario">
                            <label for="ambiente"><b>Selecione o Ambiente / Medidor:</b></label>
                            <br>
                            <select id="ambiente" name="ambiente" required>
                                <?php foreach ($ambientes as $ambiente): ?>
                                    <option value="<?= e($ambiente['id']) ?>"
                                        <?= ($ambiente['nome'] == $leitura['codigo_medidor']) ? 'selected' : '' ?>>
                                        <?= e($ambiente['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br><br>

                            <label for="data_hora"><b>Data e Hora para a Mudança:</b></label>
                            <br>
                            <input type="datetime-local" id="data_hora" name="data_hora"
                                value="<?= e($dataHoraInput) ?>" required><br><br>

                            <label for="valor_relogio"><b>Valor do Relógio para a Alteração em (kWh):</b></label>
                            <br>
                            <input type="number" step="any" id="valor_relogio" name="valor_relogio" placeholder="Digite o novo valor"
                                value="<?= e($leitura['leitura_acumulada_kwh']) ?>" required><br><br>

                            <label for="responsavel"><b>Responsável do Registro:</b></label>
                            <br>

                            <input type="text" id="responsavel" name="responsavel" placeholder="Digite seu nome"
                                value="<?= e($leitura['responsavel'] ?? '') ?>" required><br><br>
                        </div>

                        <div class="selecionar">

                            <label for="status_bloco"><b>Status do Bloco:</b></label>
                            <br>
                            <select id="status_bloco" name="status_bloco" required>
                                <?php
                                $statusOpcoes = [
                                    'ATIVO'         => 'Ativo🟢',
                                    'INTERFERÊNCIA' => 'Em Interferência🟡',
                                    'INATIVO'       => 'Inativo🔴',
                                ];
                                foreach ($statusOpcoes as $valor => $rotulo): ?>
                                    <option value="<?= e($valor) ?>"
                                        <?= ($leitura['estado_medidor_leituras'] === $valor) ? 'selected' : '' ?>>
                                        <?= $rotulo ?>
                                    </option>
                                <?php endforeach; ?>
                            </select><br><br>

                            <div class="botao">
                                <button type="submit"><b>Editar o Registro</b></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>