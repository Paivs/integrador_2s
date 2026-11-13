<?php

    require_once __DIR__ . "/init.php";

    if (isset($_SESSION['id'])) {
            $userAtual = read(database(), "Usuarios", "id_usuario = {$_SESSION['id']}");
            if($userAtual['perfil'] != "admin" || !isset($userAtual)){
                header("Location: index.php");
                exit;
            }
        }else{
            header("Location: index.php");
            exit;
        };


    

?>