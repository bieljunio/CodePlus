<?php
require 'headers.php';
require 'bd.php';
require 'validationlogin.php';
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');
$lastMounth = date('Y-m-d', mktime (0, 0, 0, date("m")-1, date("d"),  date("Y")));
//$_SESSION['busca'][$i] esta e a sessao que armazena os dados do usuário selecionado
//Dentro da session busca, existe o array(nome, setor, cpf)
$sql = <<<HEREDOC
SELECT DATA, ENTRADA, SAIDA
	FROM PONTO_FUNCIONARIO
	WHERE CPF = '{$_SESSION['busca'][$_GET['id']]['user']}'
		AND DATA BETWEEN '{$lastMounth}' AND '{$date}'
-- FIM QUERY
HEREDOC;
$sql = pg_query($sql);
if(pg_num_rows($sql)){
	echo "<tbody>";
	while($result = pg_fetch_array($sql)){
		echo "<tr>
				<td>$result[0]</td>
				<td>$result[1]</td>
				<td>$result[2]</td>
			</tr>";
	}
}
echo "</tbody>";
?>