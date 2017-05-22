<?php
require 'bd.php';
require 'validationLogin.php';

//recebe os parâmetros passados pela page home.php
if(isset($_GET['in'])){
	switch ($_GET['in']){
		case md5('entry'):
			//faz consulta no banco para ver se já houve uma inserção nesta data
			$EntryVerification = pg_query()
			if($EntryVerification == NULL){
				//faz inserção da data na tabela de ponto
				$sql = pg_query("INSERT INTO ponto_funcionario");
			} else {
				//retorna a mensagem de já haver um ponto registrado
				teste
			}
			
			
			header("Location: home.php");
			break;
		case md5('exit'):
			
			
			header("Location: home.php?");
			break;
		default:
			
	}
}

?>