<?php
	require 'bd.php';
	require 'validationlogin.php';
	require 'funcoes.php';
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Busca de cadastro</title>
	<meta charset="utf-8" />
	<!--  JavaScript, Jquery, AJAX -->
	<script src="../javascript/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="../javascript/ajax.js" type="text/javascript"></script>
</head>
<body>
	<form method="POST" class="form">
	<p><input type="text" name="nameFilter" /></p>
	<p><input type="submit" value="Pesquisar" /></p>
	</form>
	<div class="consultResult"></div>
</body>
</html>