<?php

require_once __DIR__ . "/init.php";

if($_SERVER['REQUEST_METHOD'] == "POST" || isset($_POST)){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarios = readAll($pdo, "usuarios");

    foreach($usuarios as $u){
        if($email == $u['email_conta']){
            $usuario_email = $email;
        }else{
            $usuario_email = null;
        }
        if($senha == $u['senha_conta']){
            $usuario_senha = $senha;
        }else{
            $usuario_senha = null;
        }
    }

    if($usuario_email == null){
        header("Location: entrarConta.php?erro=EMAIL");
        exit;
    }elseif($usuario_senha == null){
        header("Location: entrarConta.php?erro=SENHA");
        exit;
    }else{
        
    }
}