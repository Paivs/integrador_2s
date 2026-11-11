<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_POST)){
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    
    if(
        preg_match('/[^a-zA-Z0-9_-]/', $username)) {
        header("Location: criarConta.php?erro=CARACTERE_INVALIDO");
        exit;
        }elseif(
        strlen(trim($senha)) > 50) {
            header("Location: criarConta.php?erro=SENHA");
            exit;
        }elseif(
        strlen(trim($senha)) < 8 || $senha == '' || !isset($senha)) {
            header("Location: criarConta.php?erro=SENHA_ERRADO");
            exit;
        }elseif(
        strlen(trim($email)) > 100){
            header("Location: criarConta.php?erro=EMAIL");
            exit;
        }elseif(
        $email == '' || !isset($email) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)){
            header("Location: criarConta.php?erro=EMAIL_ERRADO");
            exit;
        }elseif(
        strlen(trim($username)) > 20){
            header("Location: criarConta.php?erro=USERNAME");
            exit;
        }elseif(
        (!isset($username) || $username == '' || strlen(trim($username)) < 5) ){
            header("Location: criarConta.php?erro=USERNAME_ERRADO");
            exit;
    }else{
        try{
            $consulta = $pdo->prepare('
                INSERT INTO usuarios (email_conta,senha_conta,username_conta) VALUES (:email, :senha, :username)
            ');
            $consulta->execute(['email' => $email, 'senha' => $senha, 'username' => $username]);

            $id = $pdo->lastInsertId();

            $_SESSION['cadastrado'] = [
                'email' => $email,
                'senha' => $senha,
                'username' => $username,
                'id' => $id
            ];
            header("Location: index.php");
            exit;
            }catch(PDOException $e){
                error_log($e->getMessage());
                exit("Erro ao salvar as informações. E-mail ja existe");
            }
        }
    }
    
