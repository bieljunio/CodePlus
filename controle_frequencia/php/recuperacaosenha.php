<?php

require 'bd.php';

clearstatcache();
$c = @$_GET['c'];


//Obtém os inputs
$S_senha = filter_input(INPUT_POST, 'newpassword');
$S_senhaconfirmacao = filter_input(INPUT_POST, 'confirmpassword');


//Confere se as senhas são iguais
if($S_senha === $S_senhaconfirmacao){

		//realiza a query de busca do CPF
		$cpf = pg_query("SELECT cpf, nome FROM funcionario");


		//Encontra em qual cpf deve ser feito a alteração
		for($i = 0; $i < pg_num_rows($cpf); $i++){
			$cpfarray = pg_fetch_array($cpf, $i, PGSQL_NUM);

			if (md5($cpfarray[0]) === $c) {
				$cpfrecuperacao = $cpfarray[0];

				//Faz o hash da nova senha
				$S_senha = password_hash($S_senha, PASSWORD_DEFAULT);

				//Começo de transação
				pg_query("BEGIN");

				//SQL para update da senha
				$sql = <<<HEREDOC
						UPDATE LOGIN
							SET SENHA = '$S_senha' 
								WHERE CPF = '$cpfrecuperacao';
						UPDATE LOG_ALTERACAO
							SET REGISTRO_ANTIGO = 'ALTERADO'
								WHERE CPF_ALTERADO = '$cpfrecuperacao'
								AND CPF_RESPONSAVEL = '$cpfrecuperacao'
								AND REGISTRO_ANTIGO = 'REQUEST';
HEREDOC;
				pg_query($sql);
				//Confirmação de transação
				pg_query("COMMIT");
				echo <<<HEREDOC
					<script type="text/javascript">
				   		alert('Senha alterada com successo!');
				   		location.href="../index.php";
				</script>
HEREDOC;

			}
		}

} else {
	echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('As senhas não conferem');
	   		history.back(-1);
	</script>
HEREDOC;
}


?>