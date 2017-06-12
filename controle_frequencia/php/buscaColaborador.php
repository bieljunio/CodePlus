<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	require 'bd.php';
	$name = strtoupper(strval(filter_input(INPUT_POST, 'nameFilter')));
	$sql = <<<HEREDOC
		SELECT F.NOME, S.NOME AS SETOR, F.CPF
		FROM FUNCIONARIO F INNER JOIN SETOR S
		ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$name%'
HEREDOC;
	$sql = pg_query($sql);
	if(pg_num_rows($sql)){
		session_unset(@$_SESSION['busca']);
		session_start();
		$i = 0;
		while($linha = pg_fetch_array($sql)){
			$nome =  $linha[0];
			$setor = $linha[1];
			$_SESSION['busca'][$i] = $linha[2];
			echo "<tbody>
					<tr>
						<td id='nome'>$nome</td>
						<td id='setor'>$setor</td>
						<td id='ferramentas'><a href=''><i class='fa fa-user-o' aria-hidden='true'></i></a>
							<a href='dadosFrequencia.php?u={$i}'><i class='fa fa-bars' aria-hidden='true'></i></a></td>
					</tr>
				</tbody>";
			$i++;
		}
	}
?>