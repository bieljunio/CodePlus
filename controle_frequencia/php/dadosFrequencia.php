<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require 'bd.php';
//require 'validationlogin.php';
//declaração da data atual
date_default_timezone_get('America/Sao_Paulo');
echo $today = date("F j, Y, g:i a");
//recupera o usário selecionado
$user = $_SESSION['busca'][$_GET['u']];
$lastmonth = mktime (0, 0, 0, date("m")-1, date("d"),  date("Y"));
echo $lastmonth;
/*$sql = <<<HEREDOC
SELECT DATA, ENTRADA, SAIDA
	FROM PONTO_FUNCIONARIO
		WHERE CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		AND DATA BETWEEN '$date' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
					AND '$DT_data_maxima' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY
HEREDOC;*/

?>
<!DOCTYPE html>
<html>
<head>
	<title>Frequencia Colaborador</title>
	<meta charset="utf-8" />
</head>
<body>
	<form method="post">
	<!-- colocar mask para data -->
	<input type="text" name="periodo" >
	<button>Filtrar</button>
</form>
</body>
</html>