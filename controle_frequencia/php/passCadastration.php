<?php
	require 'bd.php';
	$S_email = filter_input(INPUT_POST, 'email');
	$S_password = filter_input(INPUT_POST, 'password');
	$S_passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm');
	$S_email = strtoupper($S_email);
	

	//Garante que o e-mail recebido pelo navegador é igual ao e-mail do usuário cadastrado
	if(isset($_GET['e']) == md5($S_email)){
		//verifica se já houve acesso no sistema.
		$ultimoAcesso = pg_query("SELECT ultimo_acesso FROM login WHERE email = '$S_email'");
		if(!$ultimoAcesso){
			if($password === $passwordConfirm){
				$S_senha = password_hash($S_password, PASSWORD_DEFAULT);
				pg_query("UPDATE login SET senha = '$S_password' WHERE email = '$S_email'");
			} else {
				echo "As senhas não conferem!";
			}
		}
		echo 'Senha cadastrada com sucesso';
	} else {
		echo 'Link inválido';
	}
?>