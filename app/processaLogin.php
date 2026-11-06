<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php 
 
require_once __DIR__ . '/banco/database.php';   
require_once __DIR__ . '/banco/crud.php';   

$pdo = database(); 

$email = $_POST['email'];
$senha = $_POST['senha'];


if (!empty($email) && !empty($senha)){


        try {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute(['email' => $email]);
        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['senha'] == $senha) {
            
            header('Location: index.php');
            exit;
            
        } else {
            print 'Email ou senha invalido';
    ?>
    <br>
    <a href="loginTeste.php">Voltar</a>
    <?php 
    }
    } catch (PDOException $e) {
        print "Erro no banco de dados: " . $e->getMessage();
    }
    }
    
    ?>
    
</body>
</html>