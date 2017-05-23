-- FUNÇÃO QUE VERIFICA EXISTÊNCIA DE DADOS NA TABELA LOGIN E RETORNA SENHA
-- CHAMADA:
-- efetuar_login('$email');
-- RETURN: $senha VARCHAR(80)
CREATE OR REPLACE FUNCTION efetuar_login
	(var_email VARCHAR(100)) 

RETURNS VARCHAR(80) AS $$

DECLARE
	senha VARCHAR(80);
	countresult INTEGER;
		
BEGIN
	var_email = UPPER(var_email);
	SELECT COUNT(L.EMAIL) INTO countresult FROM LOGIN L
		WHERE L.EMAIL = var_email;
	IF countresult > 0 THEN
		SELECT L.SENHA INTO senha FROM LOGIN L
			WHERE L.EMAIL = var_email;
		RETURN senha;
	ELSE
		RETURN null;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE UNE TODOS OS INSERTUPDATE_LOG
-- CHAMADA:
-- master_insert_log('$tabela', '$campo', '$registro_novo', '$data_hora', '$cpf_alterado', '$cpf_responsavel', $data_ponto)
-- NOTA: $data_ponto usado somente para PONTO_FUNCIONARIO, campo ID_PONTO (VER CHAMADA DESSA FUNÇÃO)
-- RETURN: 1 = SUCESSO; 0 = VALORES IGUAIS OU REGISTRO INEXISTENTE; -1 = CAMPO INEXISTENTE; -2 = TABELA INEXISTENTE OU CPF INVÁLIDO;
CREATE OR REPLACE FUNCTION master_insert_log
	(tabela VARCHAR(100), campo VARCHAR(100),
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14),
	data_ponto DATE)

RETURNS INTEGER AS $$

DECLARE
	mensagem INTEGER;
	contcpf INTEGER;
BEGIN
	SELECT COUNT(CPF) INTO contcpf FROM FUNCIONARIO WHERE CPF = cpf_alterado OR CPF = cpf_responsavel;
	IF contcpf > 0 THEN
		tabela = UPPER(tabela);
		registro_novo = UPPER(registro_novo);
		IF tabela = 'LOGIN' THEN
			SELECT insertupdate_log_login(tabela, campo, registro_novo,
				data_hora, cpf_alterado, cpf_responsavel) INTO mensagem;
			RETURN mensagem;
		ELSIF tabela = 'FUNCIONARIO' THEN
			SELECT insertupdate_log_funcionario(tabela, campo, registro_novo,
				data_hora, cpf_alterado, cpf_responsavel) INTO mensagem;
			RETURN mensagem;
		ELSIF tabela = 'CONTA_BANCARIA' THEN
			SELECT insertupdate_log_conta_bancaria(tabela, campo, registro_novo,
				data_hora, cpf_alterado, cpf_responsavel) INTO mensagem;
			RETURN mensagem;
		ELSIF tabela = 'PONTO_FUNCIONARIO' THEN
			SELECT insertupdate_log_ponto_funcionario(tabela, campo, registro_novo,
				data_hora, cpf_alterado, cpf_responsavel, data_ponto) INTO mensagem;
			RETURN mensagem;
		ELSE
			RETURN -2;
		END IF;
	ELSE
		RETURN -2;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM LOGIN
-- CHAMADA:
-- insertupdate_log_login ('$tabela', '$campo', '$registro_novo', '$data_hora', '$cpf_alterado', '$cpf_responsavel')
CREATE OR REPLACE FUNCTION insertupdate_log_login
	(tabela VARCHAR(100), campo VARCHAR(100),
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14))

RETURNS INTEGER AS $$

DECLARE
	registro_antigo VARCHAR(100);

BEGIN
	campo = UPPER(campo);

	IF campo = 'SENHA' THEN
		SELECT L.SENHA INTO registro_antigo FROM LOGIN L 
		WHERE L.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, 
				registro_antigo, cpf_alterado, cpf_responsavel);
			UPDATE LOGIN SET SENHA = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;

	ELSE
		RETURN -1;
	END IF;
END;
$$ LANGUAGE plpgsql;
--FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM CONTA_BANCARIA
-- CHAMADA:
-- insertupdate_log_conta_bancaria ('$tabela', '$campo', '$registro_novo', '$data_hora', '$cpf_alterado', '$cpf_responsavel')
CREATE OR REPLACE FUNCTION insertupdate_log_conta_bancaria
	(tabela VARCHAR(100), campo VARCHAR(100),
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14))

RETURNS INTEGER AS $$

DECLARE
	registro_antigo VARCHAR(100);

BEGIN
	campo = UPPER(campo);

	IF campo = 'CONTA' THEN
		SELECT CB.CONTA INTO registro_antigo FROM CONTA_BANCARIA CB 
		WHERE CB.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, 
				registro_antigo, cpf_alterado, cpf_responsavel);
			UPDATE CONTA_BANCARIA SET CONTA = CAST(registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;

	ELSIF campo = 'AGENCIA' THEN
		SELECT CB.AGENCIA INTO registro_antigo FROM CONTA_BANCARIA CB 
		WHERE CB.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, 
				registro_antigo, cpf_alterado, cpf_responsavel);
			UPDATE CONTA_BANCARIA SET AGENCIA = CAST(registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_BANCO' THEN
		SELECT CB.ID_BANCO INTO registro_antigo FROM CONTA_BANCARIA CB 
		WHERE CB.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, 
				registro_antigo, cpf_alterado, cpf_responsavel);
			UPDATE CONTA_BANCARIA SET ID_BANCO = CAST(registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;

	ELSE
		RETURN -1;
	END IF;
END;
$$ LANGUAGE plpgsql;
--FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM PONTO_FUNCIONARIO
-- CHAMADA:
-- insertupdate_log_ponto_funcionario('$tabela', '$campo', '$registro_novo', '$data_hora', '$cpf_alterado', '$cpf_responsavel', $data_ponto)
CREATE OR REPLACE FUNCTION insertupdate_log_ponto_funcionario
	(tabela VARCHAR(100), campo VARCHAR(100), 
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14),
	data_ponto DATE)
			
RETURNS INTEGER as $$

DECLARE
	registro_antigo VARCHAR(100);
	existe INTEGER;

BEGIN
	campo = UPPER(campo);
	registro_antigo = data_ponto;
	IF campo = 'DATA' THEN
		SELECT COUNT(PF.DATA) INTO existe FROM PONTO_FUNCIONARIO PF
		WHERE PF.CPF = cpf_alterado
		AND PF.DATA = registro_novo;
		IF registro_antigo <> registro_novo AND existe = 0 THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE PONTO_FUNCIONARIO SET DATA = CAST(registro_novo AS DATE)
				WHERE CPF = cpf_alterado
				AND DATA = registro_antigo;
			RETURN 1;
		ELSE
			RETURN 0;
		END IF;

	ELSIF campo = 'ENTRADA' THEN
		SELECT PF.ENTRADA INTO registro_antigo FROM PONTO_FUNCIONARIO PF
		WHERE PF.CPF = cpf_alterado
		AND PF.DATA = registro_antigo;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  PONTO_FUNCIONARIO SET ENTRADA = CAST(registro_novo AS TIME)
				WHERE CPF = cpf_alterado
				AND DATA = registro_antigo;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'SAIDA' THEN
		SELECT PF.SAIDA INTO registro_antigo FROM PONTO_FUNCIONARIO PF
		WHERE PF.CPF = cpf_alterado
		AND PF.DATA = registro_antigo;
		IF registro_antigo <> registro_novo THEN
			PERFORM  inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE PONTO_FUNCIONARIO SET SAIDA = CAST(registro_novo AS TIME)
				WHERE CPF = cpf_alterado
				AND DATA = registro_antigo;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSE
	RETURN -1;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM FUNCIONARIO 
-- CHAMADA:
-- insertupdate_log_funcionario('$tabela', '$campo', '$registro_novo', '$data_hora', '$cpf_alterado', '$cpf_responsavel')
CREATE OR REPLACE FUNCTION insertupdate_log_funcionario
	(tabela VARCHAR(100), campo VARCHAR(100), 
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14))

RETURNS INTEGER as $$

DECLARE
	registro_antigo VARCHAR(100);
	var_senha VARCHAR(100);
	var_ultimo_acesso TIMESTAMP;

BEGIN
	campo = UPPER(campo);

	IF campo = 'EMAIL' THEN
		SELECT F.EMAIL INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			SELECT LO.SENHA, LO.ULTIMO_ACESSO INTO var_senha, var_ultimo_acesso FROM LOGIN LO WHERE LO.CPF = cpf_alterado;
			DELETE FROM LOGIN WHERE CPF = cpf_alterado;
			UPDATE  FUNCIONARIO SET EMAIL = registro_novo
				WHERE CPF = cpf_alterado;
			INSERT INTO LOGIN VALUES (cpf_alterado, registro_novo, var_senha, var_ultimo_acesso);
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'RG' THEN
		SELECT F.RG INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET RG = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'NOME' THEN
		SELECT F.NOME INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET NOME = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'NASCIMENTO' THEN
		SELECT F.NASCIMENTO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET NASCIMENTO = CAST(registro_novo AS DATE)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'SEXO' THEN
		SELECT F.SEXO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET SEXO = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'NOME_PAI' THEN
		SELECT F.NOME_PAI INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET NOME_PAI = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'NOME_MAE' THEN
		SELECT F.NOME_MAE INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET NOME_MAE = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ADMISSAO' THEN
		SELECT F.ADMISSAO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ADMISSAO = CAST(registro_novo AS DATE)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'DESLIGAMENTO' THEN
		SELECT F.DESLIGAMENTO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET DESLIGAMENTO = CAST(registro_novo AS DATE)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'FACEBOOK' THEN
		SELECT F.FACEBOOK INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET FACEBOOK = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'SKYPE' THEN
		SELECT F.SKYPE INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET SKYPE = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'LINKEDIN' THEN
		SELECT F.LINKEDIN INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET LINKEDIN = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'TELEFONE' THEN
		SELECT F.TELEFONE INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET TELEFONE = CAST (registro_novo AS NUMERIC)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'TELEFONE_ALT' THEN
		SELECT F.TELEFONE_ALT INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET TELEFONE_ALT = CAST (registro_novo AS NUMERIC)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'EMAIL_ALT' THEN
		SELECT F.EMAIL_ALT INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET EMAIL_ALT = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'RA' THEN
		SELECT F.RA INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET RA = CAST (registro_novo AS NUMERIC)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'COEFICIENTE' THEN
		SELECT F.COEFICIENTE INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET COEFICIENTE = CAST (registro_novo AS NUMERIC)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'PERIODO' THEN
		SELECT F.PERIODO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET PERIODO = CAST (registro_novo AS NUMERIC)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'END_RUA' THEN
		SELECT F.END_RUA INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET END_RUA = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'END_BAIRRO' THEN
		SELECT F.END_BAIRRO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET END_BAIRRO = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'END_NUMERO' THEN
		SELECT F.END_NUMERO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET END_NUMERO = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'END_COMPLEMENTO' THEN
		SELECT F.END_COMPLEMENTO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET END_COMPLEMENTO = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'END_CEP' THEN
		SELECT F.END_CEP INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET END_CEP = registro_novo
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_CIDADE' THEN
		SELECT F.ID_CIDADE INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ID_CIDADE = CAST (registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_VINCULO' THEN
		SELECT F.ID_VINCULO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ID_VINCULO = CAST (registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_CARGO' THEN
		SELECT F.ID_CARGO INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ID_CARGO = CAST (registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_SETOR' THEN
		SELECT F.ID_SETOR INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ID_SETOR = CAST (registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'ID_ESTADO_CIVIL' THEN
		SELECT F.ID_ESTADO_CIVIL INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  FUNCIONARIO SET ID_ESTADO_CIVIL = CAST (registro_novo AS INTEGER)
				WHERE CPF = cpf_alterado;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSIF campo = 'CPF' THEN
		SELECT F.CPF INTO registro_antigo FROM FUNCIONARIO F
		WHERE F.CPF = cpf_alterado;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			PERFORM funcionario_cpf_ops(registro_antigo, registro_novo);
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;

	ELSE
		RETURN -1;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NOVO FUNCIONARIO COM CPF NOVO
-- CHAMADA:
-- funcionario_cpf_ops('$cpf_antigo', '$cpf_novo')
CREATE OR REPLACE FUNCTION funcionario_cpf_ops
	(cpf_antigo VARCHAR(14), cpf_novo VARCHAR(14))

RETURNS VOID AS $$

DECLARE
	-- FUNCIONÁRIO
	var_rg VARCHAR(15);
	var_nome VARCHAR(100);
    var_nascimento DATE;
    var_sexo VARCHAR(1);
    var_nome_pai VARCHAR(100);
    var_nome_mae VARCHAR(100);
    var_admissao DATE;
    var_desligamento DATE;
    var_facebook VARCHAR(100);
    var_skype VARCHAR(100);
    var_linkedin VARCHAR(100);
    var_email VARCHAR(100);
    var_telefone NUMERIC(11);
    var_telefone_alt NUMERIC(11);
    var_email_alt VARCHAR(100);
    var_ra NUMERIC(7);
    var_coeficiente NUMERIC(5);
    var_periodo NUMERIC(1);
    var_end_rua VARCHAR(80);
    var_end_bairro VARCHAR(30);
    var_end_numero VARCHAR(5);
    var_end_complemento VARCHAR(30);
    var_end_cep VARCHAR(9);
    var_id_cidade INTEGER;
    var_id_vinculo INTEGER;
    var_id_cargo INTEGER;
    var_id_setor INTEGER;
    var_id_estado_civil INTEGER;
    -- efetuar_login
    var_login_senha VARCHAR(80);
    var_login_ultimo_acesso TIMESTAMP;
    -- RESTO
    cont INTEGER;

BEGIN
	SELECT FU.RG, FU.NOME, FU.NASCIMENTO, FU.SEXO, FU.NOME_PAI, FU.NOME_MAE,
		FU.ADMISSAO, FU.DESLIGAMENTO, FU.FACEBOOK, FU.SKYPE, FU.LINKEDIN, FU.EMAIL,
		FU.TELEFONE, FU.TELEFONE_ALT, FU.EMAIL_ALT, FU.RA, FU.COEFICIENTE, FU.PERIODO,
		FU.END_RUA, FU.END_BAIRRO, FU.END_NUMERO, FU.END_COMPLEMENTO, FU.END_CEP,
		FU.ID_CIDADE, FU.ID_VINCULO, FU.ID_CARGO, FU.ID_SETOR, FU.ID_ESTADO_CIVIL
	INTO var_rg, var_nome, var_nascimento, var_sexo, var_nome_pai, var_nome_mae,
		var_admissao, var_desligamento, var_facebook, var_skype, var_linkedin, var_email,
		var_telefone, var_telefone_alt, var_email_alt, var_ra, var_coeficiente, var_periodo,
		var_end_rua, var_end_bairro, var_end_numero, var_end_complemento, var_end_cep,
		var_id_cidade, var_id_vinculo, var_id_cargo, var_id_setor, var_id_estado_civil
	FROM FUNCIONARIO FU WHERE FU.CPF = cpf_antigo;

	SELECT COUNT(LO.EMAIL) INTO cont FROM LOGIN LO WHERE LO.CPF = cpf_antigo;

	IF cont > 0 THEN
		SELECT LO.SENHA, LO.ULTIMO_ACESSO
		INTO var_login_senha, var_login_ultimo_acesso
		FROM LOGIN LO WHERE LO.CPF = cpf_antigo;

		DELETE FROM LOGIN WHERE CPF = cpf_antigo;

		UPDATE FUNCIONARIO SET RA = 0 WHERE CPF = cpf_antigo;
		UPDATE FUNCIONARIO SET RG = '0' WHERE CPF = cpf_antigo;
		UPDATE FUNCIONARIO SET EMAIL = 'padrao@mail.com' WHERE CPF = cpf_antigo;

		INSERT INTO FUNCIONARIO
		VALUES
			(cpf_novo, var_rg, var_nome, var_nascimento, var_sexo, var_nome_pai, var_nome_mae,
			var_admissao, var_desligamento, var_facebook, var_skype, var_linkedin, var_email,
			var_telefone, var_telefone_alt, var_email_alt, var_ra, var_coeficiente, var_periodo,
			var_end_rua, var_end_bairro, var_end_numero, var_end_complemento, var_end_cep,
			var_id_cidade, var_id_vinculo, var_id_cargo, var_id_setor, var_id_estado_civil);

		INSERT INTO LOGIN
		VALUES
			(cpf_novo, var_email, var_login_senha, var_login_ultimo_acesso);
	ELSE
		UPDATE FUNCIONARIO SET RA = 0 WHERE CPF = cpf_antigo;
		UPDATE FUNCIONARIO SET RG = '0' WHERE CPF = cpf_antigo;
		UPDATE FUNCIONARIO SET EMAIL = 'padrao@mail.com' WHERE CPF = cpf_antigo;
		
		INSERT INTO FUNCIONARIO
		VALUES
			(cpf_novo, var_rg, var_nome, var_nascimento, var_sexo, var_nome_pai, var_nome_mae,
			var_admissao, var_desligamento, var_facebook, var_skype, var_linkedin, var_email,
			var_telefone, var_telefone_alt, var_email_alt, var_ra, var_coeficiente, var_periodo,
			var_end_rua, var_end_bairro, var_end_numero, var_end_complemento, var_end_cep,
			var_id_cidade, var_id_vinculo, var_id_cargo, var_id_setor, var_id_estado_civil);
	END IF;

	UPDATE PONTO_FUNCIONARIO SET CPF = cpf_novo WHERE CPF = cpf_antigo;
	UPDATE LOG_ALTERACAO SET CPF_ALTERADO = cpf_novo WHERE CPF_ALTERADO = cpf_antigo;
	UPDATE LOG_ALTERACAO SET CPF_RESPONSAVEL = cpf_novo WHERE CPF_RESPONSAVEL = cpf_antigo;
	UPDATE CONTA_BANCARIA SET CPF = cpf_novo WHERE CPF = cpf_antigo;
	DELETE FROM FUNCIONARIO WHERE CPF = cpf_antigo;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO
-- CHAMADA:
-- inserir_log('$data_hora', '$tabela', '$campo', '$registro_antigo', '$cpf_alterado', '$cpf_responsavel')
CREATE OR REPLACE FUNCTION inserir_log
	(datahora TIMESTAMP, tabelaalterada VARCHAR(100), campoalterado VARCHAR(100),
	registroantigo VARCHAR(100), cpfalterado VARCHAR(14), cpfresponsavel VARCHAR(14))

RETURNS VOID AS $$

BEGIN
INSERT INTO LOG_ALTERACAO(
	DATA_HORA, TABELA, CAMPO, REGISTRO_ANTIGO, CPF_ALTERADO, CPF_RESPONSAVEL)
VALUES
	(datahora, tabelaalterada, campoalterado, registroantigo, cpfalterado, cpfresponsavel);
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO
-- CHAMADA:
-- cadastrar_funcionario ($s_CPF, $s_RG, $s_Nome, $dt_Nascimento, $c_Sexo, $s_Nome_Pai, $s_Nome_Mae, $dt_Admissao,
-- $s_Facebook, $s_Skype, $s_Linkedin, $s_Email, $n_Telefone, $n_Telefone_Alt, $s_Email_Alt,
-- $n_RA, $n_Coeficiente, $n_Periodo, $s_Rua, $s_Bairro, $s_Numero, $s_Complemento, $s_CEP, $i_ID_Cidade, $i_Vinculo,
-- $i_Cargo, $i_Setor, $i_Estado_Civil, $s_Senha)
CREATE OR REPLACE FUNCTION cadastrar_funcionario
	(var_cpf VARCHAR(14), var_rg VARCHAR(15), var_nome VARCHAR(100), var_nascimento DATE,
	var_sexo VARCHAR(1), var_nome_pai VARCHAR(100), var_nome_mae VARCHAR(100),
	var_admissao DATE, var_facebook VARCHAR(100),
	var_skype VARCHAR(100), var_linkedin VARCHAR(100), var_email VARCHAR(100),
	var_telefone NUMERIC(11), var_telefone_alt NUMERIC(11), var_email_alt VARCHAR(100),
	var_ra NUMERIC(7), var_coeficiente NUMERIC(5), var_periodo NUMERIC(1),
	var_end_rua VARCHAR(80), var_end_bairro VARCHAR(30), var_end_numero VARCHAR(5),
	var_end_complemento VARCHAR(30), var_end_cep VARCHAR(9), var_id_cidade INTEGER,
	var_id_vinculo INTEGER, var_id_cargo INTEGER, var_id_setor INTEGER, var_id_estado_civil INTEGER,
	var_login_senha VARCHAR(80))

RETURNS INTEGER AS $$

BEGIN
var_cpf = UPPER(var_cpf);
var_rg = UPPER(var_rg);
var_nome = UPPER(var_nome);
var_sexo = UPPER(var_sexo);
var_nome_pai = UPPER(var_nome_pai);
var_nome_mae = UPPER(var_nome_mae);
var_facebook = UPPER(var_facebook);
var_skype = UPPER(var_skype);
var_linkedin = UPPER(var_linkedin);
var_email = UPPER(var_email);
var_email_alt = UPPER(var_email_alt);
var_end_rua = UPPER(var_end_rua);
var_end_bairro = UPPER(var_end_bairro);
var_end_numero = UPPER(var_end_numero);
var_end_complemento = UPPER(var_end_complemento);
var_end_cep = UPPER(var_end_cep);

INSERT INTO FUNCIONARIO
VALUES
	(var_cpf, var_rg, var_nome, var_nascimento,
	var_sexo, var_nome_pai, var_nome_mae,
	var_admissao, null, var_facebook,
	var_skype, var_linkedin, var_email,
	var_telefone, var_telefone_alt, var_email_alt,
	var_ra, var_coeficiente, var_periodo,
	var_end_rua, var_end_bairro, var_end_numero,
	var_end_complemento, var_end_cep, var_id_cidade,
	var_id_vinculo, var_id_cargo, var_id_setor, var_id_estado_civil);

INSERT INTO LOGIN
VALUES
	(var_cpf, var_email, var_login_senha);

RETURN 1;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE PONTO DE ENTRADA
-- RETORNO 1 = SUCESSO; RETORNO 2 = FALHA (JÁ EXISTE REGISTRO NAQUELA DATA);
CREATE OR REPLACE FUNCTION registrar_ponto_entrada
	(var_cpf VARCHAR(14), var_data DATE, var_entrada TIME)

RETURNS INTEGER AS $$

DECLARE
	cont INTEGER;

BEGIN
	SELECT COUNT(PF.DATA) INTO cont FROM PONTO_FUNCIONARIO PF
	WHERE PF.DATA = var_data
	AND PF.CPF = var_cpf;
	IF cont <= 0 THEN
		INSERT INTO PONTO_FUNCIONARIO (DATA, ENTRADA, CPF)
		VALUES
			(var_data, var_entrada, var_cpf);
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE VERIFICA SE EXISTE PONTO DE DETERMINADO CPF EM DETERMINADA DATA
CREATE OR REPLACE FUNCTION verifica_data
	(var_cpf VARCHAR(14), var_data DATE)

RETURNS INTEGER AS $$

DECLARE
	cont INTEGER;

BEGIN
	SELECT COUNT(PF.DATA) INTO cont FROM PONTO_FUNCIONARIO PF
	WHERE PF.CPF = var_cpf
	AND PF.DATA = var_data;
	IF cont < 0 THEN
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE PONTO DE SAÍDA
CREATE OR REPLACE FUNCTION registrar_ponto_saida 
	(var_cpf VARCHAR(14), var_data DATE, var_saida TIME)

RETURNS INTEGER AS $$

DECLARE
	cont INTEGER;

BEGIN
	SELECT PF.SAIDA INTO cont FROM PONTO_FUNCIONARIO
	WHERE PF.CPF = var_cpf
	AND PF.SAIDA = var_saida;
	IF cont <= 0 THEN
		UPDATE PONTO_FUNCIONARIO SET SAIDA = var_saida
		WHERE CPF = var_cpf AND DATA = var_data;
		RETURN 1;
	ELSE
		RETURN 0;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------