<?php
require_once __DIR__ . '/init.php';
$ambientes = readAll(database(), "ambientes");
$leituras = readAll(database(), "leituras");
$setores = readAll(database(), "setor");

$databaseStatus = 'Conectado';



try {
    require_once __DIR__ . '/init.php';
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    $databaseStatus = 'Indisponível';
}
?>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/styleDados.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title>Lançamento de Dados</title>
</head>

<body>
    <div class="menu-conf">
        <?php require_once __DIR__ . '/menuLateral.php'; ?>

        <div class="conteudo">
            <h1>Central de Lançamento de Dados</h1>

            <div class="status">
                <p>Banco de dados <strong><?= htmlspecialchars($databaseStatus, ENT_QUOTES, 'UTF-8') ?></strong></p>
            </div>

            <div class="form-container">
                <div class=" form-manual">
                    <h2>Lançamento Manual</h2>
                    <form action="processa_lancamento.php" method="post" autocomplete="off">
                        <label for="ambiente"><b>Selecione o Ambiente / Medidor</b></label>
                        <br>
                        <select id="ambiente" name="ambiente" required>
                            <?php foreach ($ambientes as $ambiente): ?>
                                <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nome'] ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label for="data_hora"><b>Data e Hora do Registro:</b></label>
                        <br>
                        <input type="datetime-local" id="data_hora" name="data_hora" required><br><br>

                        <label for="valor_relogio"><b>Valor Atual do Relogio em (kWh): </b></label>
                        <br>
                        <input type="number" id="valor_relogio" name="valor_relogio" placeholder="Digite um valor valido"><br><br>

                        <label for="responsavel"><b>Responsável pelo Registro:</b></label>
                        <br>
                        <input type="text" id="responsavel" name="responsavel" placeholder="Digite seu nome"><br><br>

                        <label for="status_bloco"><b>Status do Medidor:</b></label>
                        <br>
                        <select id="status_bloco" name="status_bloco" required>
                            <option value="ATIVO">Ativo🟢</option>
                            <option value="INTERFERÊNCIA">Em Interferência🟡</option>
                            <option value="INATIVO">Inativo🔴</option>
                        </select><br><br>

                        <button type="submit"><b>Salvar Registro no Banco de Dados</b></button>
                    </form>
                </div>


                <div class="coluna">


                    <div class="form-registro">
                        <h2><b>Ultimos Registros Gravados</b></h2>
                        <div class="tabela-registros">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Data e Hora</th>
                                        <th>Medidor Sala</th>
                                        <th>Valor do Relógio</th>
                                        <th>Origem</th>
                                        <th>Area m2</th>
                                        <th>Estado</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($leituras as $leitura): ?>
                                        <tr>
                                            <td><?= $leitura['data_hora'] ?></td>
                                            <td><?= $leitura['codigo_medidor'] ?></td>
                                            <td><?= $leitura['leitura_acumulada_kwh'] ?></td>
                                            <td><?= $leitura['origem'] ?></td>
                                            <td><?= $leitura['area_m2_leitura'] ?></td>
                                            <td><?= $leitura['estado_medidor_leituras'] ?></td>
                                            <td class="botao">
                                                <a class="excluir" href="excluir_leitura.php?id=<?= $leitura['id'] ?>" onclick="return confirm('Quer excluir esse dado?')">Excluir</a>
                                                <a class="editar" href="editar_leitura.php?id=<?= $leitura['id'] ?>">Editar</a>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-historico">
                        <div class="historico">
                            <div class="total-registros">
                                <h3>Total de Registros Gravados</h3>
                                <p><?= count($leituras) ?></p>
                            </div>

                            <div class="medidores-ativos">
                                <h3>Medidores Ativos</h3>
                                <p><?= count(array_filter($leituras, function ($leitura) {
                                        return $leitura['estado_medidor_leituras'] === 'ATIVO';
                                    })) ?></p>
                            </div>
                        </div>
                        <div class="historico2">
                            <div class="ultima-leitura">
                                <h3>Última leitura (kWh)</h3>
                                <p><?= end($leituras)['leitura_acumulada_kwh'] ?></p>
                            </div>

                            <div class="ultimo-lancamento">
                                <h3>Último Lançamento</h3>
                                <p><?= end($leituras)['data_hora'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>


</html>