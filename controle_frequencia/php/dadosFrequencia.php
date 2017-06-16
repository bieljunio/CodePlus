<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
//declaração da data atual
date_default_timezone_set('America/Sao_Paulo');
//$_SESSION['busca'][$i] esta e a sessao que armazena os dados do usuário selecionado
//Dentro da session busca, existe o array(nome, setor, cpf)
$date = date('d, M/Y');
?>
<!DOCTYPE html>
<html>
<head>
    
    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.png" type="image/png">
    <!-- inclusões iniciais do arquivo html -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- fontes do google -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
    rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/dadosFreq.css">
        
    
	<title>Frequencia Colaborador</title>
	<meta charset="utf-8" />
	<!-- ajax e jquery -->
	<script src="../javascript/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="../javascript/jquery.js"></script>
	<script src="../javascript/consultaFrequencia.js" type="text/javascript"></script>
	<style>
	table{border:1px solid #000; opacity: 0;};
	</style>
</head>
<body>
    <header>
            
            <section class="logomarca">
                <a href="home.php">
                    <img class="logo" src="../img/logo.png" alt="logo">
                </a>
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
                        <a class="ac_perfil" href="#">Acessar perfil</a>
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
    
    <section id="dadosbusca">
    
    <div id="dadoscolab">
	<p><b>Nome:&nbsp;&nbsp;</b> <?php echo $_SESSION['busca'][$_GET['id']]['nome']; ?></p>
	<p class="user" id="<?php echo $_GET['id']; ?>"><b>Setor:&nbsp;&nbsp;</b> <?php echo $_SESSION['busca'][$_GET['id']]['setor']; ?></p>
	<p><?php echo $date; ?></p>
    </div>
    
    <div id="busca">
    <h3>FILTRAR BUSCA POR PERÍODO</h3>
	<form method="post" class="form">
		<!-- colocar mask para data -->
		<h4>Data Inicial:<input required type="date" name="periodoInicio" placeholder="Digite a data inicial"></h4>
		<h4>Data Final:<input id="final" required type="date" name="periodoFinal" placeholder="Digite a data final"></h4>
		<input type="submit" value="Filtrar">	
	</form>
    </div>
        
    </section>
    
    <section id="consultresult">
	
	<table>
	<thead>
		<tr>
			<th>Data</th>
			<th>Entrada</th>
			<th>Saída</th>
		</tr>
	</thead>
	</table>
    
    </section>
    
    <div id="rodape">
        
            <br>
            <p>Copyright &copy; 2017 - CodePlus</p>
        
    </div>
</body>
</html>
