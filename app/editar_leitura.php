 <?php
    require_once __DIR__ . '/init.php';
    $idUsuario = $_GET['id'];
    $ambientes = readAll(database(), "ambientes");
    $leituras = readAll(database(), "leituras");
    $setores = readAll(database(), "setor");
    $leituraUsuario = read(database(), "leituras", "id = {$idUsuario}");
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
             <h1>Editar Lançamento <?= $leituraUsuario['codigo_medidor'] ?> </h1>

             <div class="form-editar">

                 <form action="processa-editar.php" method="$_GET" autocomplete="off">
                     <div class="box-formulario">
                         <div class="formulario">
                             <label for="ambiente"><b>Selecione o Ambiente / Medidor:</b></label>
                             <br>
                             <select id="ambiente" name="ambiente" required val>
                                 <?php foreach ($ambientes as $ambiente): ?>
                                     <option value="<?= $ambiente['id'] ?>"><?= $ambiente['nome'] ?></option>
                                 <?php endforeach; ?>
                             </select><br><br>

                             <label for="data_hora"><b>Data e Hora para a Mudança:</b></label>
                             <br>
                             <input type="datetime-local" id="data_hora" name="data_hora" required><br><br>

                             <label for="valor_relogio"><b>Valor do Relogio para a Alteração em (KWh)</b></label>
                             <br>
                             <input type="number" id="valor_relogio" name="valor_relogio" required><br><br>

                             <label for="responsalvel"><b>Responsalvel do Registro:</b></label>
                             <br>
                             <input type="text" id="responsalvel" name="responsalvel" required><br><br>
                         </div>
                         <div class="selecionar">
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

                             <button type="submit"><b>Editar o Registro</b></button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
 </body>

 </html>