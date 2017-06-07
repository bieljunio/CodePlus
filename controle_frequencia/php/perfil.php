<?php

require 'bd.php';
require 'validationlogin.php';

//Obtém o cpf do usuário com sessão iniciada no login
$S_cpf = $_SESSION['user'];


//SQL para retornar todos os dados cadastrais
$sql = <<<HEREDOC
			SELECT F.CPF,
	   F.RG,
	   F.NOME,
	   F.NASCIMENTO,
	   F.SEXO,
	   F.NOME_PAI,
	   F.NOME_MAE,
	   F.ADMISSAO,
	   F.FACEBOOK,
	   F.SKYPE,
	   F.LINKEDIN,
	   F.EMAIL,
	   F.TELEFONE,
	   F.TELEFONE_ALT,
	   F.EMAIL_ALT,
	   F.RA,
	   F.COEFICIENTE,
	   F.PERIODO,
	   F.END_RUA,
	   F.END_BAIRRO,
	   F.END_NUMERO,
	   F.END_COMPLEMENTO,
	   F.END_CEP,
	   CIDADE.NOME AS CIDADE,
	   E.NOME AS ESTADO,
	   V.NOME AS VINCULO,
	   C.NOME AS CARGO,
	   S.NOME AS SETOR,
	   ES.NOME AS ESTADO_CIVIL
	FROM FUNCIONARIO F
		INNER JOIN CIDADE
			ON F.ID_CIDADE = CIDADE.ID_CIDADE
			INNER JOIN ESTADO E
				ON CIDADE.UF = E.UF
				INNER JOIN VINCULO V
					ON F.ID_VINCULO = V.ID_VINCULO
					INNER JOIN CARGO C
						ON F.ID_CARGO = C.ID_CARGO
						INNER JOIN SETOR S
							ON F.ID_SETOR = S.ID_SETOR
							INNER JOIN ESTADO_CIVIL ES
								ON F.ID_ESTADO_CIVIL = ES.ID_ESTADO_CIVIL
		WHERE CPF = '$S_cpf'
HEREDOC;

//Query do sql
$dados = pg_query($sql);
$arraydados = pg_fetch_array($dados);





if ($arraydados[4]==="M") {
	$arraydados[4] = "Masculino";
} else {
	$arraydados[4] = "Feminino";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfil</title>
	<meta charset="utf-8">
</head>
<body>

<p>
<?php echo <<<HEREDOC
	<h3>Dados Pessoais</h3>
	<section>
		Nome: 
		$arraydados[2] <br>
		CPF: 
		$arraydados[0] <br>
		RG: 
		$arraydados[1] <br>
		Sexo: 
		$arraydados[4] <br>
		Estado Civil: 
		$arraydados[28] <br>
		Nome do pai: 
		$arraydados[5] <br>
		Nome da mãe: 
		$arraydados[6] <br>
	</section>

	<br>

	<h3>Endereço</h3>
	<section>
		Endereço: 
		$arraydados[18] <br>
		Número: 
		$arraydados[20] <br>
		Complemento: 
		$arraydados[21] <br>
		Bairro:
		$arraydados[19] <br>
		CEP:
		$arraydados[22] <br>
		Estado:
		$arraydados[24] <br>
		Cidade:
		$arraydados[23] <br>
	</section>

	<br>

	<h3>Contatos</h3>
		<section>
		Facebook: 
		<a href = "https://www.facebook.com/$arraydados[8]">https://www.facebook.com/$arraydados[8]<br> </a>
		Skype: 
		$arraydados[9] <br>
		LinkedIn: 
		<a href="https://br.linkedin.com/in/$arraydados[10]">https://br.linkedin.com/in/$arraydados[10]</a> <br>
		Telefone:
		$arraydados[12] <br>
		Telefone Alternativo:
		$arraydados[13] <br>
		Email:
		$arraydados[11] <br>
		Email alternativo:
		$arraydados[14] <br>
	</section>

	<br>

	<h3>Dados Acadêmicos</h3>
	<section>
		Período: 
		$arraydados[17]º <br>
		R.A.: 
		$arraydados[15] <br>
		Coeficiente: 
		$arraydados[16] <br>
		Data de admissão:
		$arraydados[7] <br>		
	</section>

	<br>

	<h3>Dados Empresariais</h3>
	<section>
		Vínculo: 
		$arraydados[25] <br>
		Cargo: 
		$arraydados[26] <br>
		Setor: 
		$arraydados[27] <br>		
	</section>

HEREDOC;
?>
</p>

</body>
</html>


