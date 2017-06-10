<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	require 'bd.php';
	$name = filter_input(INPUT_POST, 'nameFilter');
	$name = strtoupper(strval($name));
	$sql = <<<HEREDOC
		SELECT F.NOME, S.NOME AS SETOR
		FROM FUNCIONARIO F INNER JOIN SETOR S
		ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$name%'
HEREDOC;
	$sql = pg_query($sql);
	$rows = pg_num_rows($sql);
	if($rows){
		while($linha = pg_fetch_array($sql)){
			$nome =  $linha[0];
			$setor = $linha[1];
			echo "<tbody>
					<tr>
						<td id='nome'>$nome</td>
						<td id='setor'>$setor</td>
						<td id='ferramentas'><a href=''><i class='fa fa-user-o' aria-hidden='true'></i></a>
							<a href=''><i class='fa fa-bars' aria-hidden='true'></i></a></td>
					</tr>
				</tbody>";
		}
	}
?>