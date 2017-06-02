<!--<script src="../javascript/jquery.js"></script>-->
<?php

require 'bd.php';
require 'funcoes.php';

//Tabela funcionário
$S_cpf = filter_input(INPUT_POST, 'cpf');
$S_rg = filter_input(INPUT_POST, 'rg');
$S_nome = filter_input(INPUT_POST, 'nome');
$C_sexo = filter_input(INPUT_POST, 'sexo');
$S_nascimento = filter_input(INPUT_POST, 'data_nascimento');
$S_nome_pai = filter_input(INPUT_POST, 'nome_pai');
$S_nome_mae = filter_input(INPUT_POST, 'nome_mae');
$S_data_admissao = filter_input(INPUT_POST, 'data_admissao');
$S_facebook = " ";
$S_facebook = filter_input(INPUT_POST, 'facebook');
$S_skype = " ";
$S_skype = filter_input(INPUT_POST, 'skype');
$S_linkedin = " ";
$S_linkedin = filter_input(INPUT_POST, 'linkedin');
$S_email = filter_input(INPUT_POST, 'email');
$I_telefone = filter_input(INPUT_POST, 'telefone');
$I_telefonealt = "0";
$I_telefonealt = filter_input(INPUT_POST, 'telefone_alternativo');
$S_emailalt = " ";
$S_emailalt = filter_input(INPUT_POST, 'email_alternativo');
$I_ra = filter_input(INPUT_POST, 'ra');
$I_coeficiente = filter_input(INPUT_POST, 'coeficiente');
$I_periodo = filter_input(INPUT_POST, 'periodo');
$S_endereco = filter_input(INPUT_POST, 'endereco');
$I_numero = filter_input(INPUT_POST, 'numero');
$S_bairro = filter_input(INPUT_POST, 'bairro');
$S_complemento = filter_input(INPUT_POST, 'complemento');
$I_cep = filter_input(INPUT_POST, 'cep');




//Tabela estado civil
$S_estadocivil = filter_input(INPUT_POST, 'estado_civil');

//Tabela cidade
$S_cidade = filter_input(INPUT_POST, 'cidade');


//Tabela estado
$S_estado = filter_input(INPUT_POST, 'estado');


//Tabela setor
$S_setor = filter_input(INPUT_POST, 'setor');

//Tabela cargo
$S_cargo = filter_input(INPUT_POST, 'cargo');

//Tabela vinculo
$S_vinculo = filter_input(INPUT_POST, 'vinculo');

//Tabela login
$S_senha = password_hash(rand(100000, 9999999), PASSWORD_DEFAULT);

$emailEnviar = $S_email;
$S_email = strtoupper($S_email);



							//Remoção de máscaras

//CPF
$maskCPF = array(".","-");
$S_cpf = str_replace($maskCPF, "", $S_cpf);
//RG
$maskRG = array(".", "-");
$S_rg = str_replace($maskRG, "", $S_rg);
//CEP
$maskCEP = array("-");
$I_cep = str_replace($maskCEP, "", $I_cep);
//Telefone
$maskTelefone = array("(",")","-", " ");
$I_telefone = str_replace($maskTelefone, "", $I_telefone);
//Telefone Alternativo
$I_telefonealt = str_replace($maskTelefone, "", $I_telefonealt);



$sql = pg_query("SELECT cpf, ra, rg, email FROM funcionario WHERE cpf = '$S_cpf' OR ra = '$I_ra' OR rg = '$S_rg' OR 'email' = '$S_email'");


if(pg_num_rows($sql)) {
	echo "Já cadastrado";
}else {
	
	$newCadastro = cadastrar_funcionario ($S_cpf, $S_rg, $S_nome, $S_nascimento, $C_sexo, $S_nome_pai, $S_nome_mae, $S_data_admissao,
				$S_facebook, $S_skype, $S_linkedin, $S_email, $I_telefone, $I_telefonealt, $S_emailalt,
	          	$I_ra, $I_coeficiente, $I_periodo, $S_endereco, $S_bairro, $I_numero, $S_complemento, $I_cep, $S_cidade, $S_vinculo,
	          	$S_cargo, $S_setor, $S_estadocivil, $S_senha);
	if($newCadastro == 1){
		//Faz o hash do e-mail
		$emailHash = md5($emailEnviar);
		
		/////////////////////////Módulo de envio de e-mail para redefinição de senha///////////////////////
		//Prepara o arquivo a ser enviado
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
		<h3>Para cadastrar sua senha, acesse o link a seguir:</p></h3>
		<p><a href='http://localhost/codeplus/controle_frequencia/php/pass.php?e=$emailHash'>http://localhost/codeplus/controle_frequencia/php/pass.php?e=$emailHash</a></p>
		</td>
		</tr>
		</table>
		</html>";
		
		//envio do e-mail
		require_once('phpmailer/class.phpmailer.php'); //chama a classe de onde você a colocou.
		
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
		
		$mail->addAddress($emailEnviar); // email do destinatario.
		
		$mail->Subject = "Cadastramento de senha!";
		$mail->Body = $arquivo;
		
		if(!$mail->Send()){
			echo "Não foi possível enviar e-mail de cadastro de senha para $emailEnviar";
		}else{
			echo "E-mail de cadastro de senha enviado com sucesso";
		}
	}else{
		echo "Erro ao efetuar cadastro!";
	}
}


?>
