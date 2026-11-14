
<?php
    require_once __DIR__ . "/banco/crud.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $dados_usuario =[
            "nome" => $_POST["nome"],
            "email" => $_POST["email"],
            "data_nascimento" => $_POST["data_nascimento"] ?: null,
            "senha" => password_hash($_POST["senha"], PASSWORD_DEFAULT),
            "cpf" => $_POST["cpf"],
            "telefone" => $_POST["telefone"]
        ];
        $id = create($pdo, "clientes", $dados_usuario);
        
        echo "Cliente cadastrado com sucesso!";
    }

    

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - ElectroSafe</title>
</head>
<body>
    <div>
        <form action="" method="POST">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome"
            placeholder="Insira seu nome completo" required>

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email"
            placeholder="email@gmail.com" required>

            <label for="data_nascimento">Data de nascimento:</label>
            <input type="date" name="data_nascimento" id="data_nascimento" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>

            <label for="senha_confirmada">Confirme a senha:</label>
            <input type="password" name="senha_confirmada" id="senha_confirmada" required>
            
            
            <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST["nome"];
                    $email = $_POST["email"];
                    $data_nascimento = $_POST["data_nascimento"];

                    $senha = $_POST["senha"];
                    $senha_confirmada = $_POST["senha_confirmada"];

                    if ($senha == $senha_confirmada) {
                        echo "Senha correta!";
                        header("location: app/Clientes/index.php");
                        exit;
                    } else {
                        echo "Senha incorreta! Tente novamente.";
                    }

                }

            ?>

            <button type="submit">Cadastrar</button>

        </form>
  </div>
</body>
</html>