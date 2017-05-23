<?php
//FUNÇÃO QUE CADASTRA NOVO USUÁRIO (AUTOMATICAMENTE CADASTRA NOVO LOGIN)
//NOTA: SENHA DEVE SER PASSADA TAMBÉM, UTILIZANDO FUNÇÃO DE RANDOMIZAÇÃO
//PARA EFEITO DE TRATAMENTO, RETORNO: 1 = SUCESSO; 0 = FALHA;
function cadastrar_funcionario ($s_CPF, $s_RG, $s_Nome, $dt_Nascimento, $c_Sexo, $s_Nome_Pai, $s_Nome_Mae, $dt_Admissao,
		$s_Facebook, $s_Skype, $s_Linkedin, $s_Email, $n_Telefone, $n_Telefone_Alt, $s_Email_Alt,
		$n_RA, $n_Coeficiente, $n_Periodo, $s_Rua, $s_Bairro, $s_Numero, $s_Complemento, $s_CEP, $i_ID_Cidade, $i_Vinculo,
		$i_Cargo, $i_Setor, $i_Estado_Civil, $s_Senha)
{
	//INICIA TRANSACT
	pg_query("BEGIN");
	$sql = <<<HEREDOC
	    SELECT cadastrar_funcionario('$s_CPF', '$s_RG', '$s_Nome', '$dt_Nascimento', '$c_Sexo', '$s_Nome_Pai', '$s_Nome_Mae', '$dt_Admissao',
	    '$s_Facebook', '$s_Skype', '$s_Linkedin', '$s_Email', $n_Telefone, $n_Telefone_Alt, '$s_Email_Alt',
	    $n_RA, $n_Coeficiente, $n_Periodo, '$s_Rua', '$s_Bairro', '$s_Numero', '$s_Complemento', '$s_CEP', $i_ID_Cidade, $i_Vinculo,
	    $i_Cargo, $i_Setor, $i_Estado_Civil, '$s_Senha');
HEREDOC;
	//EFETUA FUNÇÃO
	$query = pg_query($sql);
	//VALIDA SE FUNÇÃO RETORNOU VALOR. SE SIM, EFETUA COMMIT, SE NÃO, EFETUA ROLLBACK
	if ($query){
		pg_query("COMMIT");
		return 1;
	}else{
		pg_query("ROLLBACK");
		return 0;
	}
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE DA UPDATE NA $s_Tabela DESEJADA, BASEADO EM $array_Campo_Registro [$s_Campo => $s_Registro]
//NOTA: ARRAY PASSADA DEVE SER ASSOCIATIVA: "nome_campo" => "valor_registrado"
//NOTA2: CONT SERVE PARA VERIFICAR TODAS AS RESPOSTAS DO TIPO 1 E 0 ("ALTERAÇÃO EFETUADA" E "NÃO HOUVE ALTERAÇÃO NOS VALORES")
//       CASO HAJA RESPOSTA DO TIPO -1 E -2, HAVERÁ FALHA E ROLLBACK, POIS PELO MENOS UM DOS CAMPOS DA TABELA NÃO FOI ALTERADO CORRETAMENTE
//       FOI FEITO DESSA FORMA PARA GARANTIR INTEGRIDADE DE TODOS OS DADOS!
//PARA EFEITO DE TRATAMENTO, RETORNO: 1 = SUCESSO; 0 = FALHA;
function update_e_log($s_Tabela, $array_Campo_Registro, $dt_Data,
		$s_CPF_Alterado, $s_CPF_Responsavel, $dt_Data_Ponto)
{
	$s_Campo = '';
	$s_Registro = '';
	$cont = 0;
	if ($s_Tabela <> "PONTO_FUNCIONARIO"){
		$dt_Data_Ponto = "null";
	}
	pg_query("BEGIN");
	foreach($array_Campo_Registro as $s_Campo => $s_Registro){
		$sql = <<<HEREDOC
            SELECT master_insert_log('$s_Tabela', '$s_Campo', '$s_Registro', '$dt_Data', '$s_CPF_Alterado',
              '$s_CPF_Responsavel', '$dt_Data_Ponto');
HEREDOC;
		
		$query = pg_query($sql);
		$result = pg_fetch_result($query, 0, 0);
		if ($result == 1 or $result == 0){
			$cont++;
		}
		if ($s_Campo == "CPF"){
			if ($s_CPF_Responsavel == $s_CPF_Alterado){
				$s_CPF_Responsavel = $s_Registro;
			}
			$s_CPF_Alterado = $s_Registro;
		}
	}
	if ($cont == count($array_Campo_Registro)){
		pg_query("COMMIT");
		return 1;
	}else{
		pg_query("ROLLBACK");
		return 0;
	}
	unset ($array_Campo_Registro);
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE RETORNA ID DE PONTO A SER ALTERADO
//NOTA: $dt_Data RECEBE, POR PADRÃO, "dd/mm/aaaa"
//RETORNO NULL = PESQUISA INVÁLIDA
//FUNÇÃO DEPRECIADA!!!
function retorna_id_ponto_funcionario($s_CPF, $dt_Data)//FUNÇÃO DEPRECIADA!!!
{
	//FUNÇÃO DEPRECIADA!!!
	$sql = <<<HEREDOC
          SELECT ID_PONTO FROM PONTO_FUNCIONARIO WHERE CPF = '$s_CPF' AND DATA = '$dt_Data';
HEREDOC;
	$query = pg_query($sql);
	$result = pg_fetch_result($query, 0, 0);
	if ($result){
		return $result;
	}else{
		return null;
	}
	//FUNÇÃO DEPRECIADA!!!
}
//FUNÇÃO DEPRECIADA!!!
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE REGISTRA ENTRADA
//RETORNO 1 = SUCESSO, RETORNO 0 = FALHA;
function registrar_entrada($s_CPF, $dt_Data, $tm_Entrada)
{
	pg_query("BEGIN");
	$sql = <<<HEREDOC
          SELECT registrar_ponto_entrada('$s_CPF', '$dt_Data', '$tm_Entrada');
HEREDOC;
	$query = pg_query($sql);
	$result = pg_fetch_result($query, 0, 0);
	if ($result > 0){
		pg_query("COMMIT");
		return 1;
	}else{
		pg_query("ROLLBACK");
		return 0;
	}
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE REGISTRA SAIDA
//RETORNO 1 = SUCESSO, RETORNO 0 = FALHA;
function registrar_saida($s_CPF, $dt_Data, $tm_Saida)
{
	$sql = <<<HEREDOC
          SELECT registrar_ponto_saida('$s_CPF', '$dt_Data', '$tm_Saida');
HEREDOC;
	$query = pg_query($sql);
	$result = pg_fetch_result($query, 0, 0);
	if ($result > 0){
		pg_query("COMMIT");
		return 1;
	}else{
		pg_query("ROLLBACK");
		return 0;
	}
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE VERIFICA SE EXISTE PONTO DE DETERMINADO CPF EM DETERMINADA DATA
//RETORNO 1 = NÃO EXISTE; 0 = EXISTE;
function verificar_data($s_CPF, $dt_Data)
{
	$sql = <<<HEREDOC
          SELECT verifica_data('$s_CPF', '$dt_Data');
HEREDOC;
	$query = pg_query($sql);
	$result = pg_fetch_result($query, 0, 0);
	if ($result > 0){
		pg_query("COMMIT");
		return 1;
	}else{
		pg_query("ROLLBACK");
		return 0;
	}
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNÇÃO QUE RETORNA CPF BASEADO EM BUSCA COM EMAIL
function retorna_cpf($s_Email)
{
	$s_Email = strtoupper($s_Email);
	$sql = <<<HEREDOC
        SELECT CPF FROM FUNCIONARIO WHERE EMAIL = '$s_Email';
HEREDOC;
	$query = pg_query($sql);
	$result = pg_fetch_result($query, 0, 0);
	if ($result){
		return $result;
	}else{
		return null;
	}
}
//FIM FUNÇÃO
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TIPOS DE ARRAY E VALORES ESPERADOS PARA A FUNÇÃO update_e_log
//NOTA: TODOS OS VALORES (CHAVE => REGISTRO) DEVEM SER PASSADOS COMO STRING
//NOTA2: SOMENTE A TABELA PONTO_FUNCIONARIO RECEBE $i_ID, O RESTO RECEBE "NULL"
//TABELA FUNCIONARIO
$array_Funcionario = array(
		"CPF" => "",              //VARCHAR(14) NOT NULL
		"RG" => "",               //VARCHAR(15) NOT NULL
		"NOME" => "",             //VARCHAR(100) NOT NULL
		"NASCIMENTO" => "",       //DATE NOT NULL
		"SEXO" => "",             //VARCHAR(1) NOT NULL
		"NOME_PAI" => "",         //VARCHAR(100)
		"NOME_MAE" => "",         //VARCHAR(100)
		"ADMISSAO" => "",         //DATE NOT NULL
		"FACEBOOK" => "",         //VARCHAR(100)
		"SKYPE" => "",            //VARCHAR(100)
		"LINKEDIN" => "",         //VARCHAR(100)
		"EMAIL" => "",            //VARCHAR(100) NOT NULL
		"TELEFONE" => "",         //NUMERIC(11) NOT NULL
		"TELEFONE_ALT" => "",     //NUMERIC(11)
		"EMAIL_ALT" => "",        //VARCHAR(100)
		"RA" => "",               //NUMERIC(7) NOT NULL
		"COEFICIENTE" => "",      //NUMERIC(5) NOT NULL
		"PERIODO" => "",          //NUMERIC(1) NOT NULL
		"END_RUA" => "",          //VARCHAR(80) NOT NULL
		"END_BAIRRO" => "",       //VARCHAR(30) NOT NULL
		"END_NUMERO" => "",       //VARCHAR(5) NOT NULL
		"END_COMPLEMENTO" => "",  //VARCHAR(30)
		"END_CEP" => "",          //VARCHAR(9) NOT NULL
		"ID_CIDADE" => "",        //INTEGER NOT NULL
		"ID_VINCULO" => "",       //INTEGER NOT NULL
		"ID_CARGO" => "",         //INTEGER NOT NULL
		"ID_SETOR" => "",         //INTEGER NOT NULL
		"ID_ESTADO_CIVIL" => "",  //INTEGER NOT NULL
);
//FIM ARRAY
//TABELA CONTA_BANCARIA
$array_Conta_Bancaria = array(
		"CONTA" => "",            //INTEGER NOT NULL
		"AGENCIA" => "",          //INTEGER NOT NULL
		"ID_BANCO" => "",         //INTEGER NOT NULL
);
//FIM ARRAY
//TABELA LOGIN
//NOTA: SENHA DEVE SER PASSADA JÁ CRIPTOGRAFADA
$array_Login = array(
		"SENHA" => "",            //VARCHAR(80) NOT NULL
);
//FIM ARRAY
//TABELA PONTO_FUNCIONARIO
//NOTA: COMO PONTO_FUNCIONARIO REQUER $i_ID, USAR FUNÇÃO SECUNDÁRIA retorna_id_ponto_funcionario PARA RECUPERAR ID_PONTO
$array_Ponto_Funcionario = array(
		"DATA" => "",             //DATE NOT NULL
		"ENTRADA" => "",          //TIME NOT NULL
		"SAIDA" => "",            //TIME
);
//FIM ARRAY
//////////////////////////////////////////////////////////////////////////////////////////////////////////////