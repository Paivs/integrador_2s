<?php
   $ambientes = read(database(), "ambientes");
    $leituras = read(database(), "leituras");
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/styleDados.css">
        <title>Lançamento de Dados</title>
    </head>
    <body>
        <h1>Central de Lançamento de Dados</h1>

        <div>
            <h2>Lançamento Manual</h2>
        <form action="post" method="post">
            <label for="ambiente">Selecione o Ambiente / Medidor:</label>
            <select id="ambiente" name="ambiente" required>
                <option value="">Selecione algum ambiente</option>
                <?php foreach ($ambientes as $ambiente): ?>
                    <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nome'] ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="data_hora">Data e Hora do Registro:</label>
            <input type="datetime-local" id="data_hora" name="data_hora" required><br><br>

            <label for="valor_relogio">Valor Atual do Relogio em (kWh):</label>
            <input type="number" id="valor_relogio" name="valor_relogio" required><br><br>

            <label for="responsavel">Responsável pelo Registro:</label>
            <input type="text" id="responsavel" name="responsavel" required><br><br>

            <label for="setor">Setor:</label>
            <input type="text" id="setor" name="setor" required><br><br>

            <label for="status_bloco">Status do Bloco:</label>
            <select id="status_bloco" name="status_bloco" required>
                <option value="ativo">Ativo🟢</option>
                <option value="interferencia">Em Interferência🟡</option>
                <option value="inativo">Inativo🔴</option>
            </select><br><br>

            <button>Salvar Registro no Banco de Dados</button>
        </form>
        </div>


        <div>
            <h2>Ultimos Registros Gravados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>Medidor Sala</th>
                        <th>Valor do Relógio</th>
                        <th>Origem</th>
                        <th>Area m2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($leituras as $leitura): ?>
                        <tr>
                            <td><?= $leitura['data_hora'] ?></td>
                            <td><?= $leitura['ambiente'] ?></td>
                            <td><?= $leitura['valor_relogio'] ?></td>
                            <td><?= $leitura['responsavel'] ?></td>
                            <td><?= $leitura['setor'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div>
            <h2>Outras Opções para Registro de Dados</h2>
            <button>Importar Planilha CSV</button>
            <button>Gerar Leituras Simuladas</button>
        </div>

    </body>
</html>