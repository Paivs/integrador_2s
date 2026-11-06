<?php
    require_once __DIR__ . '/init.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST['email'];
        $senha = $_POST['senha'];
    }
    $usuario_login = read(database(), "usuarios", "email='$email'");
    if($usuario_login['senha'] == $senha){
        header("Location: index.php");
    }else{
        header("Location: login.php?erro=login_invalido");
    };

    // $lista_usuarios = read(database(), "usuarios")  // -> vai trazer todos os usuários, sem distinguir ninguém
    // $usuarios_nome_roberto = read(database(), "usuarios", "nome = 'roberto%'") // vai trazer todos os usuarios que tnham o nome começando com roberto