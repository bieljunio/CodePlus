<?php
require 'validationlogin.php';
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
$S_facebook = " ";
$S_facebook = filter_input(INPUT_POST, 'facebook');
$S_skype = " ";
$S_skype = filter_input(INPUT_POST, 'skype');
$S_linkedin = " ";
$S_linkedin = filter_input(INPUT_POST, 'linkedin');
$S_email = filter_input(INPUT_POST, 'email');
$I_telefone = filter_input(INPUT_POST, 'telefone');
$I_telefonealt = "0";
$I_telefonealt = filter_input(INPUT_POST, 'telefone_alternativo');
$S_emailalt = " ";
$S_emailalt = filter_input(INPUT_POST, 'email_alternativo');
$I_ra = filter_input(INPUT_POST, 'ra');
$I_coeficiente = filter_input(INPUT_POST, 'coeficiente');
$I_periodo = filter_input(INPUT_POST, 'periodo');
$S_endereco = filter_input(INPUT_POST, 'endereco');
$I_numero = filter_input(INPUT_POST, 'numero');
$S_bairro = filter_input(INPUT_POST, 'bairro');
$S_complemento = filter_input(INPUT_POST, 'complemento');
$I_cep = filter_input(INPUT_POST, 'cep');
//Tabela estado civil
$S_estadocivil = filter_input(INPUT_POST, 'estado_civil');
$S_cidade = filter_input(INPUT_POST, 'cidade');
$S_estado = filter_input(INPUT_POST, 'estado');
$S_setor = filter_input(INPUT_POST, 'setor');
$S_cargo = filter_input(INPUT_POST, 'cargo');

//Tabela vinculo
$S_vinculo = filter_input(INPUT_POST, 'vinculo');

$S_email = strtoupper($S_email);



//Remoção de máscaras

//CPF
$maskCPF = array(".","-");
$S_cpf = str_replace($maskCPF, "", $S_cpf);
//RG
$maskRG = array(".", "-");
$S_rg = str_replace($maskRG, "", $S_rg);
//CEP
$maskCEP = array("-");
$I_cep = str_replace($maskCEP, "", $I_cep);
//Telefone
$maskTelefone = array("(",")","-", " ");
$I_telefone = str_replace($maskTelefone, "", $I_telefone);
//Telefone Alternativo
$I_telefonealt = str_replace($maskTelefone, "", $I_telefonealt);


//Obtém a data atual
date_default_timezone_set('America/Sao_Paulo');
$datahora = date('d-m-Y H:i:s');


//Variáveis para função update e log de alterações
$s_Tabela = "FUNCIONARIO";
$dt_Data = $datahora;
$s_CPF_Alterado = $_SESSION['cpfupdate'];
$s_CPF_Responsavel = $_SESSION['user'];

$array_Campo_Registro = array(
    "CPF" => "$S_cpf",              //VARCHAR(12) NOT NULL
    "RG" => "$S_rg",               //VARCHAR(15) NOT NULL
    "NOME" => "$S_nome",             //VARCHAR(100) NOT NULL
    "NASCIMENTO" => "$S_nascimento",       //DATE NOT NULL
    "SEXO" => "$C_sexo",             //VARCHAR(1) NOT NULL
    "NOME_PAI" => "$S_nome_pai",         //VARCHAR(100)
    "NOME_MAE" => "$S_nome_mae",         //VARCHAR(100)
    "ADMISSAO" => "$S_data_admissao",         //DATE NOT NULL
    "FACEBOOK" => "$S_facebook",         //VARCHAR(100)
    "SKYPE" => "$S_skype",            //VARCHAR(100)
    "LINKEDIN" => "$S_linkedin",         //VARCHAR(100)
    "EMAIL" => "$S_email",            //VARCHAR(100) NOT NULL
    "TELEFONE" => "$I_telefone",         //NUMERIC(11) NOT NULL
    "TELEFONE_ALT" => "$I_telefonealt",     //NUMERIC(11)
    "EMAIL_ALT" => "$S_emailalt",        //VARCHAR(100)
    "RA" => "$I_ra",               //NUMERIC(7) NOT NULL
    "COEFICIENTE" => "$I_coeficiente",      //VARCHAR(6) NOT NULL
    "PERIODO" => "$I_periodo",          //NUMERIC(1) NOT NULL
    "END_RUA" => "$S_endereco",          //VARCHAR(80) NOT NULL
    "END_BAIRRO" => "$S_bairro",       //VARCHAR(30) NOT NULL
    "END_NUMERO" => "$I_numero",       //VARCHAR(5) NOT NULL
    "END_COMPLEMENTO" => "$S_complemento",  //VARCHAR(30)
    "END_CEP" => "$I_cep",          //VARCHAR(9) NOT NULL
    "ID_CIDADE" => "$S_cidade",        //INTEGER NOT NULL
    "ID_VINCULO" => "$S_vinculo",       //INTEGER NOT NULL
    "ID_CARGO" => "$S_cargo",         //INTEGER NOT NULL
    "ID_SETOR" => "$S_setor",         //INTEGER NOT NULL
    "ID_ESTADO_CIVIL" => "$S_estadocivil",  //INTEGER NOT NULL
);

$dt_Data_Ponto = NULL;

$update = update_e_log($s_Tabela, $array_Campo_Registro, $dt_Data, $s_CPF_Alterado, $s_CPF_Responsavel, $dt_Data_Ponto);

//Mensagens de sucesso/erro e redirecionamento
if($update > 0){
    if($s_CPF_Responsavel === $_SESSION['user'] && $s_CPF_Alterado != $S_cpf){
        echo <<<HEREDOC
        <script>
        alert("Atualização dos dados cadastrais de $S_nome efetuada com sucesso. Faça o login novamente.");
        location.href="logout.php";
        </script>
HEREDOC;
    } else{
    echo <<<HEREDOC
        <script>
        alert("Atualização dos dados cadastrais de $S_nome efetuada com sucesso.");
        location.href="home.php";
        </script>
HEREDOC;
    }
} else {
    echo <<<HEREDOC
        <script>
        alert("Atualização dos dados cadastrais de $S_nome não efetuada.");
        location.href="home.php";
        </script>
HEREDOC;
}
 ?>


