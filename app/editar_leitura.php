 <?php
    require_once __DIR__ . '/init.php';
    $ambientes = readAll(database(), "ambientes");
    $leituras = readAll(database(), "leituras");
    $setores = readAll(database(), "setor");
    ?>
 <html>

 <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="./css/styleEditar.css">
     <link rel="stylesheet" href="./css/styleMenu.css">
     <title>Lançamento de Dados</title>
 </head>

 <body>
     <div class="menu-conf">
         <?php require_once __DIR__ . '/menuLateral.php'; ?>

         <div class="conteudo">
             <h1>Editar Lançamento</h1>

             <div class="form-container">
                 <div class=" form-manual">
                     <h2>Lançamento Manual</h2>
                     <form action="processa_lancamento.php" method="post" autocomplete="off">
                         <label for="ambiente"><b>Selecione o Ambiente / Medidor:</b></label>
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
                         <input type="number" id="valor_relogio" name="valor_relogio" required><br><br>

                         <label for="responsavel"><b>Responsável pelo Registro:</b></label>
                         <br>
                         <input type="text" id="responsavel" name="responsavel" required><br><br>

                         <label for="setor"><b>Setor:</b></label>
                         <br>
                         <select id="setor" name="setor" required>
                             <?php foreach ($setores as $s): ?>
                                 <option value="<?= $s['id'] ?>"><?= $s['nome'] ?></option>
                             <?php endforeach; ?>
                         </select><br><br>

                         <label for="status_bloco"><b>Status do Bloco:</b></label>
                         <br>
                         <select id="status_bloco" name="status_bloco" required>
                             <option value="ATIVO">Ativo🟢</option>
                             <option value="INTERFERÊNCIA">Em Interferência🟡</option>
                             <option value="INATIVO">Inativo🔴</option>
                         </select><br><br>

                         <button type="submit"><b>Salvar Registro no Banco de Dados</b></button>
                     </form>
                 </div>
             </div>
         </div>
 </body>

 </html>