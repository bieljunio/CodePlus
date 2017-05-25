<?php

require 'bd.php';
require 'validationlogin.php';
require 'funcoes.php';

$S_SenhaAntiga = filter_input(INPUT_POST, 'old_password');
$S_SenhaNova = filter_input(INPUT_POST, 'new_password');
$S_ConfirmacaoSenhaNova = filter_input(INPUT_POST, 'confirm_new_password');

$S_SenhaAntigaHash = retorna_senha($_SESSION['email']);

$I_cpf = $_SESSION['user'];

	
if (password_verify($S_SenhaAntiga, $S_SenhaAntigaHash)) {

	$S_SenhaNovaHash = password_hash($S_SenhaNova, PASSWORD_DEFAULT);

	$sql = <<<HEREDOC
	    UPDATE login
		SET senha = '$S_SenhaNovaHash'
		WHERE cpf = '$I_cpf'
HEREDOC;

	pg_query($sql);

	date_default_timezone_set('America/Sao_Paulo');
	$datahora = date('d-m-Y H:i:s');
	echo $datahora;

	$slqlog = <<<HEREDOC
		INSERT INTO log_alteracao (data_hora, tabela, campo, registro_antigo, cpf_alterado, cpf_responsavel)
		VALUES ('$datahora', 'login', 'senha', '$S_SenhaAntigaHash', '$I_cpf', '$I_cpf')
HEREDOC;

	pg_query($slqlog);
	
	$S_senhasuccess = md5('SENHA_SUCCESS');
	header("Location: logout.php?msg={$S_senhasuccess}");

} else {
	$S_senhafault = md5('SENHA_FAULT');
	header("Location: home.php?msg={$S_senhafault}");

}

?>
