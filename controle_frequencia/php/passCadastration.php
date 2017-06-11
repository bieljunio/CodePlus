<?php
	require 'bd.php';
	$e = $_GET['e'];
	$S_email = filter_input(INPUT_POST, 'email');
	$S_password = filter_input(INPUT_POST, 'password');
	$S_passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm');

	//Garante que o e-mail recebido pelo navegador é igual ao e-mail do usuário cadastrado
	if($e == md5($S_email)){
		//Passa o e-mail para maiúsculo para ser enviado para o banco
		$S_email = strtoupper($S_email);
		//verifica se já houve acesso no sistema.
		$ultimoAcesso = pg_query("SELECT * FROM login WHERE email = '$S_email'");
		if(pg_field_is_null($ultimoAcesso, 0, "ultimo_acesso") == 1){
			if($S_password == $S_passwordConfirm){
				$S_senha = password_hash($S_password, PASSWORD_DEFAULT);
				pg_query("UPDATE login SET senha = '$S_senha' WHERE email = '$S_email'");
				//Mensagem de senha cadastrada com sucesso.
				echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('Senha cadastrada com sucesso!');
	   		location.href="../index.php";
	</script>
HEREDOC;
			} else {
				//Mensagem de senhas digitadas diferentes
				echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('As senhas não conferem');
	   		history.back(-1);
	</script>
HEREDOC;
			}
		} else {
			//Senha já cadastrada
			echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('Link inválido');
	</script>
HEREDOC;
		}
	} else {
		//Link inválido
		echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('Link inválido');
	</script>
HEREDOC;
	}
?>
