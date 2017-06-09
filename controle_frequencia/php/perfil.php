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
    <!-- Favicon page -->
    <link rel="icon" href="../img/favicon.png" sizes="16x16" type="image/png">
    <!-- Folhas de estilos -->
    <link rel="stylesheet" type="text/css" href="../css/cadastro.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
    rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/layout.css">
    <!-- Inserção de jquery -->
    <script src="../javascript/jquery-3.2.1.min.js"></script>
    <!--  Inserção de funções para os botões -->
    <script src="../javascript/jquery.js"></script>
</head>
    
<body>

 <header>
            
        <section class="logomarca">
                <a  href="home.php"><img class="logo" src="../img/logo.png" alt="logo"> </a>
        </section>
            
        <section>
                <nav id="registros">
                    <ul>
                        <li><a href="" onclick="return registerEntry();">Registrar Entrada</a></li>
                        <li><a href="" onclick="return registerExit();">Registrar Saída</a></li>
                    </ul>
                </nav>
        </section>
            
        <section class="box">
                <div class="dropdown">
                    <img class="seta" src="../img/seta.png" alt="seta" />
                    <img class="redondo" src="../img/perfil.png"   alt="Foto Perfil" />
                    <div class="dropdown_content">
                        <a class="ac_perfil" href="perfil.php">Acessar perfil</a>
                        <a class="al_senha" href="AlteracaoSenhaFront.php">Alterar senha</a>
                        <a class="sair" href="logout.php">Sair</a>
                    </div>
                </div>
        </section>
            
</header>
            
        <section>
            
            <nav id="menu">
                <ul>
                    <li><a href="#">FUNCIONÁRIOS</a></li>
                    <li><a href="#">CONSULTAR FREQUÊNCIA</a></li>
                    <li><a href="form_cadastro.php">NOVO CADASTRO</a></li>
                </ul>
            </nav>
        
        </section>
    
<div id="dadosperfil">
<p>
<?php echo <<<HEREDOC
	<h3>Dados Pessoais</h3>
	<section class="dados">
        <p>
        <b>Nome:</b>
		$arraydados[2] &nbsp;
		 <b>CPF:</b> 
		$arraydados[0] &nbsp;
		 <b>RG:</b> 
		$arraydados[1] </p> 
        
        <p>
		 <b>Sexo: </b> 
		$arraydados[4] &nbsp;
		 <b>Estado Civil:</b> 
		$arraydados[28] </p> 
        
        <p>
		 <b>Nome do pai:</b> 
		$arraydados[5] &nbsp;
		 <b>Nome da mãe:</b> 
		$arraydados[6] 
        </p>
	</section>
	<br>
	<h3>Endereço</h3>
	<section class="dados">
		<p>
        <b>Endereço:</b>
		$arraydados[18] &nbsp;
		<b>Número:</b> 
		$arraydados[20]&nbsp;
		<b>Complemento:</b> 
		$arraydados[21] </p> 
        
        <p>
		<b>Bairro:</b>
		$arraydados[19] &nbsp;
		<b>CEP:</b>
		$arraydados[22] &nbsp;
		<b>Estado:</b>
		$arraydados[24] &nbsp;
		<b>Cidade:</b>
		$arraydados[23]
        </p> 
	</section>
	<br>
	<h3>Contatos</h3>
		<section class="dados">
		<p>
        <b>Facebook:</b> 
		<a href = "https://www.facebook.com/$arraydados[8]">https://www.facebook.com/$arraydados[8] </a>&nbsp;
		<b>Skype:</b> 
		$arraydados[9]</p> 
        
        <p>
		<b>LinkedIn:</b> 
		<a href="https://br.linkedin.com/in/$arraydados[10]">https://br.linkedin.com/in/$arraydados[10]</a>&nbsp; 
		<b>Telefone:</b>
		$arraydados[12] &nbsp;
		<b>Telefone Alternativo:</b>
		$arraydados[13]</p> 
        
        <p> 
		<b>Email:</b>
		$arraydados[11] &nbsp;
		<b>Email alternativo:</b>
		$arraydados[14] 
        </p>
	</section>
	<br>
	<h3>Dados Acadêmicos</h3>
	<section class="dados">
        <p>
		<b>Período:</b> 
		$arraydados[17]º &nbsp;
		<b>R.A.:</b> 
		$arraydados[15]  &nbsp;
		<b>Coeficiente:</b> 
		$arraydados[16]  &nbsp;
		<b>Data de admissão:</b>
		$arraydados[7]
        </p>
        
	</section>
	<br>
	<h3>Dados Empresariais</h3>
	<section class="dados">
        <p>
		<b>Vínculo:</b>
		$arraydados[25]&nbsp;
		<b>Cargo:</b>
		$arraydados[26]&nbsp;
		<b>Setor:</b> 
		$arraydados[27] 
        </p>
	</section>
HEREDOC;
?>
</p>
</div> 
    <div id="rodape">
        
            <p>Copyright &copy; 2017 - CodePlus</p>
        
    </div>
 
</body>
</html>
