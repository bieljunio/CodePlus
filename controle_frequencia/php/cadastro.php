<?php
require 'validacaologin.php';

//Tabela funcionÃ¡rio
$S_cpf = filter_input(INPUT_POST, 'cpf');
$S_rg = filter_input(INPUT_POST, 'rg');
$S_nome = filter_input(INPUT_POST, 'nome');
$S_sexo = filter_input(INPUT_POST, 'sexo');
$S_nascimento = filter_input(INPUT_POST, 'nascimento');
$S_nacionalidade = filter_input(INPUT_POST, 'nacionalidade');
$S_nome_pai = filter_input(INPUT_POST, 'nome_pai');
$S_nome_mae = filter_input(INPUT_POST, 'nome_mae');
$S_data_admissao = filter_input(INPUT_POST, 'data_admissao');
$S_data_desligamento = filter_input(INPUT_POST, 'data_desligamento');
$S_facebook = filter_input(INPUT_POST, 'facebook');
$S_skype = filter_input(INPUT_POST, 'skype');
$S_linkedin = filter_input(INPUT_POST, 'linkedin');
$S_email = filter_input(INPUT_POST, 'email');
$I_telefone = filter_input(INPUT_POST, 'telefone');
$I_telefonealt = filter_input(INPUT_POST, 'telefonealt');
$S_emailalt = filter_input(INPUT_POST, 'emailalt');
$I_ra = filter_input(INPUT_POST, 'ra');
$I_coeficiente = filter_input(INPUT_POST, 'coeficiente');
$I_periodo = filter_input(INPUT_POST, 'periodo');
$S_endereço = filter_input(INPUT_POST, 'endereço');
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

//Tabela paÃ­s
$S_pais = filter_input(INPUT_POST, 'pais');

//Tabela setor
$S_setor = filter_input(INPUT_POST, 'setor');

//Tabela cargo
$S_cargo = filter_input(INPUT_POST, 'cargo');

//Tabela vinculo
$S_vinculo = filter_input(INPUT_POST, 'vinculo');

//Tabela login
//$S_email = filter_input(INPUT_POST, 'email');
$S_senha = filter_input(INPUT_POST, 'senha');

//Hash da senha
$S_senhahash = password_hash($S_senha, PASSWORD_DEFAULT);

$sqlfucionario = "INSERT INTO funcionario"





?>