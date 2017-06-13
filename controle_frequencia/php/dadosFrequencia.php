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
	<p>Nome: <?php echo $_SESSION['busca'][$_GET['id']]['nome']; ?></p>
	<p class="user" id="<?php echo $_GET['id']; ?>">Setor: <?php echo $_SESSION['busca'][$_GET['id']]['setor']; ?></p>
	<p><?php echo $date; ?></p>
	<form method="post" class="form">
		<!-- colocar mask para data -->
		<input type="text" name="periodoInicio">
		<input type="text" name="periodoFinal">
		<input type="submit" value="Filtrar">	
	</form>
	
	<table>
	<thead>
		<tr>
			<th>Data</th>
			<th>Entrada</th>
			<th>Saída</th>
		</tr>
	</thead>
	</table>
</body>
</html>
