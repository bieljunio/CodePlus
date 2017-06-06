<?php
	require '../javascript/cpaint2/cpaint2.inc.php';
	require '../javascript/cpaint2/cpaint2.backend-debugger.php';
	require 'bd.php';
	//Instancia objeto cpaint
	$CPaint = new cpaint();
	//Registra funcoes
	$CPaint->register(array("Busca","buscaColaborador"));
	
	//Inicia o Cpaint
	$CPaint->start("ISO-8859-1");
	$CPaint->return_data();
	
		
	class Busca {
		function buscaColaborador($name){
			$sql = pg_query("SELECT f.nome, s.nome FROM funcionario f INNER JOIN setor s ON f.ID_Setor = s.ID_SETOR WHERE f.nome LIKE '%$name%'");
			$numRows = pg_num_rows($sql);
			if($numRows >= 1){
				for($i = 0; $i < $numRows; $i++){
					$colaborador = pg_fetch_array($sql, $i, PGSQL_NUM);
					echo "<p>$colaborador[0] ";
					echo "$colaborador[1]</p>";
					$msg[$i] = array($colaborador[0], $colaborador[1]);
				}
				return $msg;
			} else {
				$msg = "Nome não válido";
				return $msg;
			}
		Busca::RetornaValor($msg);
		}
		
		function RetornaValor($msg){
			global $CPaint;
			$CPaint->set_data($msg);
		}
	}
?>