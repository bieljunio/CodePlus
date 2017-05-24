<?php
require 'validationlogin.php';
require 'bd.php';
require 'funcoes.php';

//Define a função para o botão entrada
function buttonEntry($userCPF, $dateNow, $tm_dateNow){
	//faz consulta no banco de dados e ve se já houve inserção na data, caso não tenha feito, insere e retorna 1
	$EntryVerification = registrar_entrada($userCPF, $dateNow, $tm_dateNow);
	if($EntryVerification == 1){
		$msg = 'Registro de entrada efetuada com sucesso!';
	} else{
		$msg = 'Registro já efetuado na data de hoje!';
	}
	return $msg;
}

//Define a função para o botão saída
function buttonExit($userCPF, $dateNow, $tm_dateNow){
	//faz a consulta e insere a saida e retorna 1, caso haja uma inserção já feita na data retorna erro
	$EntryVerification = registrar_saida($userCPF, $dateNow, $tm_dateNow);
	if($EntryVerification == 1){
		$msg = 'Registro de saída efetuada com sucesso!';
	} else{
		$msg = 'Registro já efetuado na data de hoje!';
	}
	return $msg;
}

//executa o botão registrar entrada
function buttonResult(){
	//define a data e hora atual
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Y-m-d');
	$tm_date = date('H:i:s');
	
	if(isset($_GET['entry'])){
	$msgResult = buttonEntry($_SESSION['user'], $date, $tm_date);
	} else if(isset ($_GET['exit'])) {
	$msgResult = buttonExit($_SESSION['user'], $date, $tm_date);
	}
	echo $msgResult;
}

buttonResult();

?>