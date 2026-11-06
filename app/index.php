<?php


declare(strict_types=1);


$databaseStatus = 'Conectado';


try {
    require_once __DIR__ . '/init.php';
    $pdo->query('SELECT 1');
} catch (Throwable $exception) {
    $databaseStatus = 'Indisponível';
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projeto Integrador</title>
    <link rel="stylesheet" href="CSS/index.css">
   
</head>
<body>
    <h1>Projeto Integrador: SolarControl</h1>
    <p>O ambiente PHP está funcionando.</p>
    <div class="status">
        Banco de dados: <strong><?= htmlspecialchars($databaseStatus, ENT_QUOTES, 'UTF-8') ?></strong>
    </div>
    <p>Comece a aplicação editando <code>app/index.php</code>.</p>
</body>
</html>
