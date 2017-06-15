<?php
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	require 'bd.php';
	require 'validationlogin.php';
	$name = filter_input(INPUT_POST, 'nameFilter');
	$name = strtoupper(strval($name));
	$sql = <<<HEREDOC
		SELECT F.CPF,
	   F.NOME,
	   S.NOME AS SETOR
	FROM FUNCIONARIO F
		INNER JOIN SETOR S
			ON F.ID_SETOR = S.ID_SETOR
			WHERE F.NOME LIKE '%$name%'
HEREDOC;
	$sql = pg_query($sql);
	$rows = pg_num_rows($sql);
	if($rows){
		unset($_SESSION['busca']);
		$i = 0;
		while($linha = pg_fetch_array($sql)){
			//$cpf = md5($linha[0]);
			$_SESSION['busca'][$i] = $linha[0];
			$nome =  $linha[1];
			$setor = $linha[2];
			echo "<tbody>
					<tr>
						<td id='nome'>$nome</td>
						<td id='setor'>$setor</td>
						<td id='ferramentas'><a target='_blank' href='viewperfil.php?c=$i'><i class='fa fa-user-o' aria-hidden='true'></i></a>
							<a ><i class='fa fa-bars' aria-hidden='true'></i></a></td>
					</tr>
				</tbody>";
				$i++;
		}
	}
?>
