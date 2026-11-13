<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_POST)){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarios = readAll($pdo, "usuarios");
    $id = null;

    $usuario_email = null;
    $usuario_senha = null;

    foreach($usuarios as $u){
        if($email == $u['email_conta']){
            $usuario_email = $email;
            if($senha == $u['senha_conta']){
                $usuario_senha = $senha;
                $id = $u['id'];
                $username = $u['username_conta'];
                break;
            }
        } 
    }
    if($usuario_email == null){
        header("Location: entrarConta.php?erro=EMAIL_SENHA");
        exit;
    }elseif($usuario_senha == null){
        header("Location: entrarConta.php?erro=EMAIL_SENHA");
        exit;
    }
}



$_SESSION['cadastrado'] = [
    'email' => $email,
    'senha' => $senha,
    'username' => $username,
    'id' => $id
];

header("Location: entrarConta.php");