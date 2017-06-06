----------------------------------------BUSCA----------------------------------------
-- QUERY QUE RETORNA DADOS DE TODOS USUÁRIOS BASEADO NA ENTRADA DE UMA PARTE DE UM NOME
---- CUIDADO AO TRATAR NOMES COM ALIAS. SE FOR PASSAR POR ARRAY ASSOCIATIVA, O NOME DO ÍNDICE TEM QUE SER O NOME DO ALIAS. EX.: "SETOR" NÃO "S.NOME"	
-- ALTERAR $S_nome POR NOME DIGITADO NO CAMPO DE BUSCA
SELECT F.CPF,
	   F.NOME,
	   V.NOME AS VINCULO,
	   C.NOME AS CARGO,
	   S.NOME AS SETOR
	FROM FUNCIONARIO F
		INNER JOIN VINCULO V
			ON F.ID_VINCULO = V.ID_VINCULO
			INNER JOIN CARGO C
				ON F.ID_CARGO = C.ID_CARGO
				INNER JOIN SETOR S
					ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$S_nome%' --CUIDADO COM AS ASPAS E OS PORCENTOS, DEVEM SER MANTIDOS
-- FIM QUERY

-- QUERY QUE RETORNA DADOS DE TODOS USUÁRIOS BASEADO NA ENTRADA DE UMA PARTE DE UM NOME
---- CUIDADO AO TRATAR NOMES COM ALIAS. SE FOR PASSAR POR ARRAY ASSOCIATIVA, O NOME DO ÍNDICE TEM QUE SER O NOME DO ALIAS. EX.: "SETOR" NÃO "S.NOME"	
-- ALTERAR $S_nome POR NOME DIGITADO NO CAMPO DE BUSCA
SELECT F.CPF,
	   F.NOME,
	   S.NOME AS SETOR
	FROM FUNCIONARIO F
		INNER JOIN SETOR S
			ON F.ID_SETOR = S.ID_SETOR
		WHERE F.NOME LIKE '%$S_nome%' --CUIDADO COM AS ASPAS E OS PORCENTOS, DEVEM SER MANTIDOS
-- FIM QUERY
----------------------------------------FIM------------------------------------------

----------------------------------------RECUPERAÇÃO DE SENHA-------------------------
-- QUERY QUE DÁ UPDATE EM SENHA JÁ EXISTENTE BASEADO EM EMAIL
-- ALTERAR $S_senha POR SENHA A SER INSERIDA
-- ALTERAR $S_email POR EMAIL CUJA SENHA ESTÁ SENDO ALTERADA
UPDATE LOGIN
	SET SENHA = '$S_senha' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		WHERE EMAIL = '$S_email' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE DÁ UPDATE EM SENHA JÁ EXISTENTE BASEADO EM CPF
-- ALTERAR $S_senha POR SENHA A SER INSERIDA
-- ALTERAR $S_cpf POR CPF CUJA SENHA ESTÁ SENDO ALTERADA
UPDATE LOGIN
	SET SENHA = '$S_senha' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS	
		WHERE CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE DÁ UPDATE EM SENHA JÁ EXISTENTE BASEADO EM EMAIL E CPF (MAIS SEGURO)
-- ALTERAR $S_senha POR SENHA A SER INSERIDA
-- ALTERAR $S_email POR EMAIL CUJA SENHA ESTÁ SENDO ALTERADA
-- ALTERAR $S_cpf POR CPF CUJA SENHA ESTÁ SENDO ALTERADA
UPDATE LOGIN -- USAR ESSE
	SET SENHA = '$S_senha' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		WHERE EMAIL = '$S_email' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		AND CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE VERIFICA SE EXISTE EMAIL E CPF CADASTRADOS (USAR PARA "NÃO HÁ REGISTRO COM ESSA COMBINAÇÃO DE VALORES")
---- ESSA QUERY É MAIS SEGURA, PORÉM MENOS ABRANGENTE, JÁ QUE REFERENCIA UM REGISTRO PELA RELAÇÃO DE EMAIL E CPF JUNTOS
-- ALTERAR $S_email POR EMAIL CUJA CONTA SERÁ VERIFICADA
-- ALTERAR $S_cpf POR CPF CUJA CONTA SERÁ VERIFICADA
SELECT COUNT(*) -- USAR ESSE
	FROM LOGIN
		WHERE EMAIL = '$S_email' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		AND CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE VERIFICA SE EXISTE EMAIL OU CPF CADASTRADOS (USAR PARA DIFERENCIAR "EMAIL NÃO CADASTRADO" DE "CPF NÃO CADASTRADO")
---- ESSA QUERY É MENOS SEGURA, PORÉM MAIS ABRANGENTE, JÁ QUE DIFERENCIA EXISTÊNCIA DE EMAIL E DE CPF (EX.: PODE HAVER CPF CADASTRADO, MAS NÃO COM AQUELE EMAIL)
------ NÃO USARIA ESSA QUERY AQUI NÃO, MESMO PORQUE INFORMAR, POR EXEMPLO, QUE SOMENTE O EMAIL NÃO ESTÁ CADASTRADO, DIZ QUE EXISTE UMA PESSOA COM O CPF DIGITADO
------ SÓ FIZ ELA PORQUE TAVA COM TEMPO, SEM O QUE FAZER, E SEM SONO HEHE A PROPÓSITO, QUEM TÁ LENDO É SUPER LEGAL
------ AINDA HÁ MÉTODOS DE UTILIZAR ESSA QUERY, BASTA SABER EFETUAR TRATAMENTOS NECESSÁRIOS E VÁLIDOS
-- ALTERAR $S_email POR EMAIL CUJA CONTA SERÁ VERIFICADA
-- ALTERAR $S_cpf POR CPF CUJA CONTA SERÁ VERIFICADA
SELECT COUNT(*)
	FROM LOGIN
		WHERE EMAIL = '$S_email' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
		OR CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY
----------------------------------------FIM------------------------------------------

----------------------------------------ACESSO AO PERFIL-----------------------------
-- QUERY QUE SELECIONA TODOS OS DADOS CADASTRAIS DO FUNCIONARIO A PARTIR DE UM CPF
---- CUIDADO AO TRATAR NOMES COM ALIAS. SE FOR PASSAR POR ARRAY ASSOCIATIVA, O NOME DO ÍNDICE TEM QUE SER O NOME DO ALIAS. EX.: "SETOR" NÃO "S.NOME"
-- ALTERAR $S_cpf POR CPF DE QUEM OS DADOS SERÃO EXIBIDOS
SELECT F.CPF,
	   F.RG,
	   F.NOME,
	   F.NASCIMENTO,
	   F.SEXO,
	   F.NOME_PAI,
	   F.NOME_MAE,
	   F.ADMISSAO,
	   F.FACEBOOK,
	   F.SKYPE,
	   F.LINKEDIN,
	   F.EMAIL,
	   F.TELEFONE,
	   F.TELEFONE_ALT,
	   F.EMAIL_ALT,
	   F.RA,
	   F.COEFICIENTE,
	   F.PERIODO,
	   F.END_RUA,
	   F.END_BAIRRO,
	   F.END_NUMERO,
	   F.END_COMPLEMENTO,
	   F.END_CEP,
	   CIDADE.NOME AS CIDADE,
	   E.NOME AS ESTADO,
	   V.NOME AS VINCULO,
	   C.NOME AS CARGO,
	   S.NOME AS SETOR,
	   ES.NOME AS ESTADO_CIVIL
	FROM FUNCIONARIO F
		INNER JOIN CIDADE
			ON F.ID_CIDADE = CIDADE.ID_CIDADE
			INNER JOIN ESTADO E
				ON CIDADE.UF = E.UF
				INNER JOIN VINCULO V
					ON F.ID_VINCULO = V.ID_VINCULO
					INNER JOIN CARGO C
						ON F.ID_CARGO = C.ID_CARGO
						INNER JOIN SETOR S
							ON F.ID_SETOR = S.ID_SETOR
							INNER JOIN ESTADO_CIVIL ES
								ON F.ID_ESTADO_CIVIL = ES.ID_ESTADO_CIVIL
		WHERE CPF = '$S_cpf' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE SELECIONA TODOS OS DADOS CADASTRAIS DO FUNCIONARIO A PARTIR DE UM RG
---- CUIDADO AO TRATAR NOMES COM ALIAS. SE FOR PASSAR POR ARRAY ASSOCIATIVA, O NOME DO ÍNDICE TEM QUE SER O NOME DO ALIAS. EX.: "SETOR" NÃO "S.NOME"
-- ALTERAR $S_rg POR RG DE QUEM OS DADOS SERÃO EXIBIDOS
SELECT F.CPF,
	   F.RG,
	   F.NOME,
	   F.NASCIMENTO,
	   F.SEXO,
	   F.NOME_PAI,
	   F.NOME_MAE,
	   F.ADMISSAO,
	   F.FACEBOOK,
	   F.SKYPE,
	   F.LINKEDIN,
	   F.EMAIL,
	   F.TELEFONE,
	   F.TELEFONE_ALT,
	   F.EMAIL_ALT,
	   F.RA,
	   F.COEFICIENTE,
	   F.PERIODO,
	   F.END_RUA,
	   F.END_BAIRRO,
	   F.END_NUMERO,
	   F.END_COMPLEMENTO,
	   F.END_CEP,
	   CIDADE.NOME AS CIDADE,
	   E.NOME AS ESTADO,
	   V.NOME AS VINCULO,
	   C.NOME AS CARGO,
	   S.NOME AS SETOR,
	   ES.NOME AS ESTADO_CIVIL
	FROM FUNCIONARIO F
		INNER JOIN CIDADE
			ON F.ID_CIDADE = CIDADE.ID_CIDADE
			INNER JOIN ESTADO E
				ON CIDADE.UF = E.UF
				INNER JOIN VINCULO V
					ON F.ID_VINCULO = V.ID_VINCULO
					INNER JOIN CARGO C
						ON F.ID_CARGO = C.ID_CARGO
						INNER JOIN SETOR S
							ON F.ID_SETOR = S.ID_SETOR
							INNER JOIN ESTADO_CIVIL ES
								ON F.ID_ESTADO_CIVIL = ES.ID_ESTADO_CIVIL
		WHERE RG = '$S_rg' --CUIDADO COM AS ASPAS, DEVEM SER MANTIDAS
-- FIM QUERY

-- QUERY QUE SELECIONA TODOS OS DADOS CADASTRAIS DO FUNCIONARIO A PARTIR DE UM RA
---- CUIDADO AO TRATAR NOMES COM ALIAS. SE FOR PASSAR POR ARRAY ASSOCIATIVA, O NOME DO ÍNDICE TEM QUE SER O NOME DO ALIAS. EX.: "SETOR" NÃO "S.NOME"
-- ALTERAR $S_rg POR RG DE QUEM OS DADOS SERÃO EXIBIDOS
SELECT F.CPF,
	   F.RG,
	   F.NOME,
	   F.NASCIMENTO,
	   F.SEXO,
	   F.NOME_PAI,
	   F.NOME_MAE,
	   F.ADMISSAO,
	   F.FACEBOOK,
	   F.SKYPE,
	   F.LINKEDIN,
	   F.EMAIL,
	   F.TELEFONE,
	   F.TELEFONE_ALT,
	   F.EMAIL_ALT,
	   F.RA,
	   F.COEFICIENTE,
	   F.PERIODO,
	   F.END_RUA,
	   F.END_BAIRRO,
	   F.END_NUMERO,
	   F.END_COMPLEMENTO,
	   F.END_CEP,
	   CIDADE.NOME AS CIDADE,
	   E.NOME AS ESTADO,
	   V.NOME AS VINCULO,
	   C.NOME AS CARGO,
	   S.NOME AS SETOR,
	   ES.NOME AS ESTADO_CIVIL
	FROM FUNCIONARIO F
		INNER JOIN CIDADE
			ON F.ID_CIDADE = CIDADE.ID_CIDADE
			INNER JOIN ESTADO E
				ON CIDADE.UF = E.UF
				INNER JOIN VINCULO V
					ON F.ID_VINCULO = V.ID_VINCULO
					INNER JOIN CARGO C
						ON F.ID_CARGO = C.ID_CARGO
						INNER JOIN SETOR S
							ON F.ID_SETOR = S.ID_SETOR
							INNER JOIN ESTADO_CIVIL ES
								ON F.ID_ESTADO_CIVIL = ES.ID_ESTADO_CIVIL
		WHERE RA = $I_ra --CUIDADO, AQUI NÃO VAI ASPAS POR NÃO SE TRATAR DE UM VARCHAR
-- FIM QUERY
----------------------------------------FIM------------------------------------------