<?php
require 'bd.php';
	$name = strval(@$_GET['nameFilter']);
	$name = strtoupper($name);
	$sql = <<<HEREDOC
		SELECT F.NOME, S.NOME AS SETOR
		FROM FUNCIONARIO F INNER JOIN SETOR S
		ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$name%'
HEREDOC;
	$sql = pg_query($sql);
	$rows = pg_num_rows($sql);
	echo "
			<div class='table'>
			<div class='table header'>NOME</div>
			<div class='table header'>SETOR</div>";
	while($linha = pg_fetch_array($sql)){
		$nome =  $linha[0];
		$setor = $linha[1];
		echo "<div class='table body'>$nome</div>
			<div class='table body'>$setor</div>
			<div class='table body'>
				<a href=''>Dados</a>
				<a href=''>Frequencia</a>	
			</div>
		</div>";
	}
	
?>