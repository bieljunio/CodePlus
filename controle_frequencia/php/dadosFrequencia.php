<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require 'bd.php';
require 'validationlogin.php';
//declaração da data atual
date_default_timezone_set('America/Sao_Paulo');
echo $date = date('d, M/Y');
//recupera o usário selecionado
$user = $_SESSION['busca'][$_GET['id']];
$sql = <<<HEREDOC
SELECT F.NOME, S.NOME AS SETOR, F.CPF
		FROM FUNCIONARIO F INNER JOIN SETOR S
		ON F.ID_SETOR = S.ID_SETOR
		WHERE F.CPF = '$user'
-- FIM QUERY
HEREDOC;
$sql = pg_query($sql);
$label = pg_fetch_array($sql);
$nome = $label[0];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Frequencia Colaborador</title>
	<meta charset="utf-8" />
</head>
<body>
	<p>Nome: <?php $label[0];?></p>
	<p>Setor: <?php $label[1]; ?></p>
	<p>CPF: <?php $label[2] ?></p>
	<form method="post">
	<!-- colocar mask para data -->
	<input type="text" name="periodo" >
	<button>Filtrar</button>
	
	<table>
		<thead>
		<tr>
			<th>
		</thead>
	</table>
</form>
</body>
</html>
