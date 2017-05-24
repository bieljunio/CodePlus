<?php

require 'bd.php';
require 'funcoes.php';

//Tabela funcionário
$S_cpf = filter_input(INPUT_POST, 'cpf');
$S_rg = filter_input(INPUT_POST, 'rg');
$S_nome = filter_input(INPUT_POST, 'nome');
$C_sexo = filter_input(INPUT_POST, 'sexo');
$S_nascimento = filter_input(INPUT_POST, 'data_nascimento');
$S_nome_pai = filter_input(INPUT_POST, 'nome_pai');
$S_nome_mae = filter_input(INPUT_POST, 'nome_mae');
$S_data_admissao = filter_input(INPUT_POST, 'data_admissao');
$S_facebook = filter_input(INPUT_POST, 'facebook');
$S_skype = filter_input(INPUT_POST, 'skype');
$S_linkedin = filter_input(INPUT_POST, 'linkedin');
$S_email = filter_input(INPUT_POST, 'email');
$I_telefone = filter_input(INPUT_POST, 'telefone');
$I_telefonealt = filter_input(INPUT_POST, 'telefone_alternativo');
$S_emailalt = filter_input(INPUT_POST, 'email_alternativo');
$I_ra = filter_input(INPUT_POST, 'ra');
$I_coeficiente = filter_input(INPUT_POST, 'coeficiente');
$I_periodo = filter_input(INPUT_POST, 'periodo');
$S_endere�o = filter_input(INPUT_POST, 'endereco');
$I_numero = filter_input(INPUT_POST, 'numero');
$S_bairro = filter_input(INPUT_POST, 'bairro');
$S_complemento = filter_input(INPUT_POST, 'complemento');
$I_cep = filter_input(INPUT_POST, 'cep');




//Tabela estado civil
$S_estadocivil = filter_input(INPUT_POST, 'estado_civil');

//Tabela cidade
$S_cidade = filter_input(INPUT_POST, 'cidade');


//Tabela estado
$S_estado = filter_input(INPUT_POST, 'estado');


//Tabela setor
$S_setor = filter_input(INPUT_POST, 'setor');

//Tabela cargo
$S_cargo = filter_input(INPUT_POST, 'cargo');

//Tabela vinculo
$S_vinculo = filter_input(INPUT_POST, 'vinculo');

//Tabela login
$S_senha = rand(100000, 9999999);


$S_email = strtoupper($S_email);

echo $S_email;


$sql = pg_query("SELECT cpf, ra, rg, email FROM funcionario WHERE cpf = '$S_cpf' OR ra = '$I_ra' OR rg = '$S_rg' OR 'email' = '$S_email'");

echo pg_num_rows($sql);

if(pg_num_rows($sql)) {
	echo "Usu�rio j� cadastrado";
} else {
	
cadastrar_funcionario ($S_cpf, $S_rg, $S_nome, $S_nascimento, $C_sexo, $S_nome_pai, $S_nome_mae, $S_data_admissao,
          $S_facebook, $S_skype, $S_linkedin, $S_email, $I_telefone, $I_telefonealt, $S_emailalt,
          $I_ra, $I_coeficiente, $I_periodo, $S_endere�o, $S_bairro, $I_numero, $S_complemento, $I_cep, $S_cidade, $S_vinculo,
          $S_cargo, $S_setor, $S_estadocivil, $S_senha);


}

//CPF, RG, email, RA



?>