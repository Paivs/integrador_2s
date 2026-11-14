<?php

require_once __DIR__ . "/init.php";

// 1. Lê o id da URL (encontrei.php?id=7) e garante que é número
$id = (int) ($_GET['idObjeto'] ?? 0);

// 2. Busca UM objeto com esse id (o ? protege contra SQL injection)
$objeto = read($pdo, 'objetos', 'idObjeto = ?', [$id]);


// 3. Se não existir, ou se não estiver perdido, volta para o painel
if (!$objeto || $objeto['status_objeto'] !== 'Perdido') {
    header('Location: painelObjetos.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encontrou objeto</title>

    <link rel="stylesheet" href="./css/style-encontrei.css">
</head>

<body>
    <h1>Você encontrou este objeto?</h1>

    <div class="tabela">
        <div class="objeto">
            <div class="emoji">
                <p><?= htmlspecialchars($objeto['imagemObjeto']) ?></p>
            </div>

            <div class="conteudo">
                <p>Nome: <?= htmlspecialchars($objeto['nome']) ?></p>
                <p>Descrição: <?= htmlspecialchars($objeto['descricao']) ?></p>
                <p>Categoria: <?= htmlspecialchars($objeto['categoria']) ?></p>
                <p>Perdido em: <?= htmlspecialchars($objeto['localEncontrado']) ?></p>
            </div>
        </div>

        <form action="">
            <label for="estato">Qual era o estado do objeto:</label>
            <select name="estatoObjeto" id="estatoObjeto">
                <option value="">Selecione</option>
                <option value="normal">Normal</option>
                <option value="precisaDeConcerto">Precisa de concerto</option>
                <option value="quebrado">Quebrado</option>
            </select>

            <label for="lugarEncontrado">Onde você o achou?</label>
            <input type="text" id="estado" name="estado" required>
        </form>
    </div>
</body>

</html>