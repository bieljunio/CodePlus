<?php
	require 'headers.php';
	require 'bd.php';
	require 'validationlogin.php';
	$name = strtoupper(strval(filter_input(INPUT_POST, 'nameFilter')));
	$sql = <<<HEREDOC
		SELECT F.NOME, S.NOME AS SETOR, F.CPF
		FROM FUNCIONARIO F INNER JOIN SETOR S
		ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$name%'
HEREDOC;
	$sql = pg_query($sql);
	if(pg_num_rows($sql)){
		unset($_SESSION['busca']);
		$i = 0;
		echo "<tbody>";
		while($linha = pg_fetch_array($sql)){
			$_SESSION['busca'][$i] = array(
					'nome'=> $linha[0],
					'setor'=> $linha[1],
					'user'=> $linha[2]);
			echo "<tr>
						<td class='nome'>{$_SESSION['busca'][$i]['nome']}</td>
						<td class='setor'>{$_SESSION['busca'][$i]['setor']}</td>
						<td class='ferramentas'><a target='_blank' href='viewperfil.php?c=$i'><i class='fa fa-user-o' aria-hidden='true'></i></a>
							<a target='_blank' href='dadosFrequencia.php?id={$i}'><i class='fa fa-bars' aria-hidden='true'></i></a></td>
					</tr>";
			$i++;
		}
		echo "</tbody>";
	}
?>