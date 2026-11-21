<?php

require_once __DIR__ . "/init.php";


if (isset($_GET['id']) && isset($_SESSION['logoEquipe'][$_GET['id']])) {
    $_SESSION['logoSelecionada'] = $_GET['id'];
    

    header('Location: equipes.php#popup');
    exit;
}




if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    header("Location: equipes.php");
    exit;
}

$jogo = $_POST['jogo'] ?? null;
$nome = $_POST['nome'] ?? null;
$privacidade = $_POST['privacidade'] ?? null;
$descricao = $_POST['descricao'] ?? null;
$img = $_SESSION['logoSelecionada'];



try {
    $consulta = $pdo->prepare("
        INSERT INTO equipes 
        (nome, descricao, jogo_equipe, privacidade, img) 
        VALUES 
        (:nome, :descricao, :jogo, :privacidade, :img)
    ");

    $consulta->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':jogo' => $jogo,
        ':privacidade' => $privacidade,
        ':img' => $img
    ]);

    // Limpa a logo selecionada da sessão após salvar no banco
    unset($_SESSION['logoSelecionada']);

    header("Location: equipes.php");
    exit;

} catch (PDOException $e) {
    error_log($e->getMessage());

    exit("Erro ao salvar as informações: " . $e->getMessage());
}
?>
