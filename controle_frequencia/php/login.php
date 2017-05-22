<?php

// INICIA SESSÃO
session_start();

// CONEXÃO COM BANCO DE DADOS
require 'bd.php';

// Obtém dados do formulário de login
$S_AutenticationEmail = filter_input(INPUT_POST, 'email');
$S_AutenticationSenha = filter_input(INPUT_POST, 'password');

// Verifica se o e-mail está cadastrado no banco
//$S_Email = pg_query("SELECT email FROM login WHERE email = '$S_AutenticationEmail'");


$sql = <<<HEREDOC
    SELECT efetuar_login('$S_AutenticationEmail');
HEREDOC;

$S_PasswordHash = pg_query($sql);


if ($S_PasswordHash) {
 
        // Compara a senha informada com o banco de dados
        if (password_verify($S_AutenticationSenha, pg_fetch_result($S_PasswordHash, 0, 0))) {
            $_SESSION['logged'] = true;
            header('Location: home.php');
        } else {
            $_SESSION['logged'] = false;
            $_SESSION['user'] = $S_Email;
            $S_msgCode = md5('LOGIN_FAULT');
            
            header("Location: ../index.php?msg={$S_msgCode}");
        }
} else {
    $_SESSION['logado'] = false;
    $S_msgCode = md5('LOGIN_FAULT');
        header("Location: ../index.php?msg={$S_msgCode}");
}




//if ($S_Email) {
//    
//    
//        // Obtém hash da senha no banco de dados
//        $S_PasswordHash = pg_query("SELECT senha FROM login WHERE email='$S_AutenticationEmail'");
//
//        // Compara a senha informada com o banco de dados
//        if (password_verify($S_AutenticationSenha, pg_fetch_result($S_PasswordHash, 0, 0))) {
//            $_SESSION['logged'] = true;
//            header('Location: home.php');
//        } else {
//            $_SESSION['logged'] = false;
//            $_SESSION['user'] = $S_Email;
//            $S_msgCode = md5('LOGIN_FAULT');
//            
//            header("Location: ../index.php?msg={$S_msgCode}");
//        }

?>