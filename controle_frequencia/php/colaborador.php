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
	<!--  JavaScript, Jquery -->
	<script src="../javascript/jquery.js" type="text/javascript"></script>
	<script src="../javascript/jquery-3.2.1.min.js" type="text/javascript"></script>
	<!-- CPAINT 2 framework -->
	<script src="../javascript/cpaint2/cpaint2.inc.compressed.js" type="text/javascript"></script>
</head>
<body>
	<p><input type="text" name="nameFilter" /></p>
	<p><a href="" onclick="search();">Pesquisar</a></p>
	<p><script>tableConsult(msg);</script>
</body>
</html>