
<?php

require_once __DIR__ . "/init.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: equipes.php");
    exit;
}

$jogo = $_POST['jogo'] ?? null;
$nome = $_POST['nome'] ?? null;
$privacidade = $_POST['privacidade'] ?? null;
$descricao = $_POST['descricao'] ?? null;

try {
    $consulta = $pdo->prepare("
        INSERT INTO equipes 
        (nome, descricao, jogo_equipe, privacidade) 
        VALUES 
        (:nome, :descricao, :jogo, :privacidade)
    ");

    $consulta->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':jogo' => $jogo,
        ':privacidade' => $privacidade
    ]);

    header("Location: equipes.php");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());

    exit("Erro ao salvar as informações: " . $e->getMessage());
}
?>
