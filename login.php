<?php

// INICIA SESSÃO
session_start();

// CONEXÃO COM BANCO DE DADOS
require 'bd.php';
require_once 'funcoes.php';

// Obtém dados do formulário de login
$S_AutenticationEmail = filter_input(INPUT_POST, 'email');
$S_AutenticationSenha = filter_input(INPUT_POST, 'password');


$S_PasswordHash = retorna_senha($S_AutenticationEmail);

if ($S_PasswordHash) {
 
        // Compara a senha informada com o banco de dados
        if (password_verify($S_AutenticationSenha, $S_PasswordHash)) {
            $_SESSION['logged'] = true;
            $_SESSION['user'] = retorna_cpf($S_AutenticationEmail);
            $_SESSION['email'] = $S_AutenticationEmail;
            header('Location: home.php');
        } else {
            $_SESSION['logged'] = false;
            $S_msgCode = md5('LOGIN_FAULT');            
            header("Location: ../index.php?msg={$S_msgCode}");
        }
} else {
    $_SESSION['logado'] = false;
    $S_msgCode = md5('LOGIN_FAULT');
        header("Location: ../index.php?msg={$S_msgCode}");
}

?>