<?php
header("Content-type: text/html; charset=utf-8");

//Conexão com banco de dados
require 'bd.php';

//Obtém inputs de email e cpf
$S_email = filter_input(INPUT_POST, 'emailrecuperacao');
$S_cpf = filter_input(INPUT_POST, 'cpfrecuperacao');
//Deixa email maiúsculo
$S_emailBanco = strtoupper($S_email);

//Retira máscaras do cpf
$maskCPF = array("." , "-");
$S_cpf = str_replace($maskCPF, "", $S_cpf);

//Obtém a data atual
date_default_timezone_set('America/Sao_Paulo');
$datahora = date('d-m-Y H:i:s');

//Verifica se email e cpf existem no banco de dados
$sql = <<<HEREDOC
	SELECT EMAIL, CPF
	FROM LOGIN
		WHERE EMAIL = '$S_emailBanco'
		AND CPF = '$S_cpf'
HEREDOC;
$verificacaoemail = pg_query($sql);
$verificacaoemail = pg_fetch_array($verificacaoemail);

if ($verificacaoemail) {
//Verifica se existe requisição de recuperação de senha
$sqlrequest = <<<HEREDOC
		SELECT COUNT(*)
			FROM LOG_ALTERACAO
				WHERE CPF_ALTERADO = '$S_cpf'
				AND CPF_RESPONSAVEL = '$S_cpf'
				AND REGISTRO_ANTIGO = 'REQUEST'
HEREDOC;
$request = pg_query($sqlrequest);
$request = pg_fetch_result($request, 0, 0);
//Insere uma request, se não houver, ou insere update na data, se houver
if ($request <= 0){
	$insertrequest = <<<HEREDOC
			INSERT INTO LOG_ALTERACAO
		VALUES
			('$datahora',
			 'LOGIN',
			 'SENHA',
			 'REQUEST',
			 '$S_cpf',
			 '$S_cpf')
HEREDOC;
	pg_query($insertrequest);
} else {
	//Atualiza a data se já houver request
	$updatedate = <<<HEREDOC
	UPDATE LOG_ALTERACAO
		SET DATA_HORA = '$datahora'
			WHERE CPF_ALTERADO = '$S_cpf'
			AND CPF_RESPONSAVEL = '$S_cpf'
			AND REGISTRO_ANTIGO = 'REQUEST'
HEREDOC;
	pg_query($updatedate);
}





	//Hash de email e data
	$cpfhash = md5($S_cpf);
	//Email de recuperação de senha
	$arquivo = "<style type='text/css'>
		body {
		margin: 0px;
		font-family: Helvetica, sans-serif;
		font-size: 12px;
		color: #666666;
		}
		
		a {
		color: #FF0000;
		text-decoration: none;
		}
		
		a:hover {
		color: #FF0000;
		text-decoration: none;
		}
		</style>
		<html>
		<table width='510' border='0' cellpadding='1' cellspacing='1'>
		<tr>
		<td>
		<h1>Este e-mail foi gerado automaticamente!</h1>
		<h3>Para recuperar sua senha, acesse o link a seguir:</p></h3>
		<p><a href='http://localhost/codeplus/controle_frequencia/php/FormRecuperacaoSenha.php?c=$cpfhash'>http://localhost/codeplus/controle_frequencia/php/FormRecuperacaoSenha.php?c=$cpfhash</a></p><br><br>
		<h3>Se você não requistou recuperação de senha, desconsidere este e-mail.</h3>
		</td>
		<br><br>
		</tr>
		</table>
		</html>";

	//Envio do e-mail
		require_once('phpmailer/class.phpmailer.php'); //Chama a classe de onde você a colocou.
		
		$mail = new PHPMailer(); // instancia a classe PHPMailer
		
		$mail->IsSMTP();
		
		//configuração do gmail
		$mail->Port = '465'; //porta usada pelo gmail.
		$mail->Host = 'smtp.gmail.com';
		$mail->IsHTML(true);
		$mail->Mailer = 'smtp';
		$mail->SMTPSecure = 'ssl';
		
		//configuração do usuário do gmail
		$mail->SMTPAuth = true;
		$mail->Username = 'codepluisejota@gmail.com'; // usuario gmail.
		$mail->Password = 'codeplusej'; // senha do email.
		
		$mail->SingleTo = true;
		
		// configuração do email a ver enviado.
		$mail->From = "codepluisejota@gmail.com";
		$mail->FromName = "Code Plus";
		
		$mail->addAddress($S_email); // email do destinatario.
		
		$mail->Subject = "Recuperação de senha!";
		$mail->Body = $arquivo;
		
		if(!$mail->Send()){
			echo <<<HEREDOC
					<script type="text/javascript">
				   		alert('Não foi possível enviar o e-mail de recuperação de senha.');
				   		history.back(-1);
				</script>
HEREDOC;
		}else{
			echo <<<HEREDOC
					<script type="text/javascript">
				   		alert('E-mail de recuperação de senha enviado com sucesso!');
				   		location.href="../index.php";
				</script>
HEREDOC;
		}	
} else {
	echo <<<HEREDOC
					<script type="text/javascript">
				   		alert('Os dados não conferem');
				   		history.back(-1);
				</script>
HEREDOC;

}

?>