<?php
	require 'cpaint2.inc.php';
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
			$sql = pg_query("SELECT * FROM funcionario WHERE nome LIKE '%$name%'");
			if(pg_num_fields($sql) >= 1){
				
			}
		}
	}
?>