<?php
	clearstatcache();
	$e = @$_GET['e'];
	//retornar erro e sucesso
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cadastramento de Senha!</title>
	<meta charset="utf-8">	
	<script type="text/javascript" src="../javascript/jquery.js"></script>
</head>
<body>
	<div id="input-email"></div>
	<form name="login" action="passCadastration.php?e=<?php echo "$e" ?>" method="post">
		<label>E-mail:</label>
		<input type="text" name="email" />
		<label>Senha:</label>
		<input type="password" name="password" />
		<input type="submit" value="Cadastrar" />
	</form>
</body>
</html>