<?php
require 'bd.php';
require 'validationLogin.php';
require 'funcoes.php';

//define a data e hora atual
date_default_timezone_set('America/Sao_Paulo');
$date = date('Y-m-d');
$tm_date = date('H:i:s');
//recebe os parâmetros passados pela page home.php
if(isset($_GET['in'])){
	switch ($_GET['in']){
		case md5('entry'):
			//faz consulta no banco para ver se já houve uma inserção nesta data
			$EntryVerification = registrar_entrada($_SESSION['user'], $date, $tm_date);
			if($EntryVerification == 1){
				$S_msg = md5('ENTRY_SUCCESS');
				header("Location: home.php?msg={$S_msg}");
			} else {
				//retorna a mensagem de já haver um ponto registrado
				$S_msg = md5('ENTRY_FAIL');
				header("Location: home.php?msg={$S_msg}");
			}
			
			break;
		case md5('exit'):
			
			
			header("Location: home.php?");
			break;
		default:
			
	}
}

?>