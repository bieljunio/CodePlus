-- FUNÇÃO QUE VERIFICA EXISTÊNCIA DE DADOS NA TABELA LOGIN E RETORNA SENHA
-- CHAMADA:
-- efetuar_login($email, $senha);
-- RETURN: $senha VARCHAR(80)
CREATE OR REPLACE FUNCTION efetuar_login (var_email VARCHAR(100)) 

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
-- master_insert_log($tabela, $campo, $registro_novo, $data_hora, $cpf_alterado, $cpf_responsavel, $id_eventual)
-- NOTA: $id_eventual usado somente para CONTA_BANCARIA, campo ID_BANCO (VER CHAMADA DESSA FUNÇÃO)
-- RETURN: 1 = SUCESSO; 0 = VALORES IGUAIS; -1 = CAMPO INEXISTENTE; -2 = TABELA INEXISTENTE;
CREATE OR REPLACE FUNCTION master_insert_log
	(tabela VARCHAR(100), campo VARCHAR(100),
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14),
	id_eventual INTEGER)

RETURNS INTEGER AS $$

DECLARE
	mensagem INTEGER;

BEGIN
	tabela = UPPER(tabela);
	IF tabela = 'LOGIN' THEN
		SELECT insertupdate_log_login(tabela, campo, registro_novo,
			data_hora, cpf_alterado, cpf_responsavel) INTO mensagem;
		RETURN mensagem;
	--ELSIF tabela = 'FUNCIONARIO' THEN
	ELSIF tabela = 'CONTA_BANCARIA' THEN
		SELECT insertupdate_log_conta_bancaria(tabela, campo, registro_novo,
			data_hora, cpf_alterado, cpf_responsavel) INTO mensagem;
		RETURN mensagem;
	ELSIF tabela = 'PONTO_FUNCIONARIO' THEN
		SELECT insertupdate_log_ponto_funcionario(tabela, campo, registro_novo,
			data_hora, cpf_alterado, cpf_responsavel, id_eventual) INTO mensagem;
		RETURN mensagem;
	ELSE
		RETURN -2;
	END IF;
END;
$$ LANGUAGE plpgsql;
-- FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM LOGIN
-- CHAMADA:
-- insertupdate_log_login ($tabela, $campo, $registro_novo, $data_hora, $cpf_alterado, $cpf_responsavel)
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
-- insertupdate_log_conta_bancaria ($tabela, $campo, $registro_novo, $data_hora, $cpf_alterado, $cpf_responsavel)
CREATE OR REPLACE FUNCTION insertupdate_log_conta_bancaria
	(tabela VARCHAR(100), campo VARCHAR(100),
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14))

RETURNS INTEGER AS $$

DECLARE
	registro_antigo VARCHAR(100);

BEGIN
	campo = UPPER(campo);
	--CASO O CAMPO ALTERADO SEJA 'CONTA'
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

	--CASO O CAMPO ALTERADO SEJA 'AGENCIA'
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
	ELSE
		RETURN -1;
	END IF;
END;
$$ LANGUAGE plpgsql;
--FIM FUNÇÃO

--------------------------------------------------------------------------------------------------------------

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO E DA UPDATE EM PONTO_FUNCIONARIO
-- CHAMADA:
-- SELECT PF.ID_PONTO FROM PONTO_FUNCIONARIO PF WHERE PF.CPF = $cpf AND PF.ENTRADA = $timestamp_entrada AND PF.SAIDA = $timestamp_saida
-- $id_eventual = PF.ID_PONTO
-- insertupdate_log_ponto_funcionario($tabela, $campo, $registro_novo, $data_hora, $cpf_alterado, $cpf_responsavel, $id_eventual)
CREATE OR REPLACE FUNCTION insertupdate_log_ponto_funcionario
	(tabela VARCHAR(100), campo VARCHAR(100), 
	registro_novo VARCHAR(100), data_hora TIMESTAMP,
	cpf_alterado VARCHAR(14), cpf_responsavel VARCHAR(14),
	id_eventual INTEGER)
			
RETURNS INTEGER as $$

DECLARE
	registro_antigo VARCHAR(100);
	--time_registro_novo TIMESTAMP;

BEGIN

	--time_registro_novo = CAST(registro_novo AS VARCHAR(100));
	
	campo = UPPER(campo);
	IF campo = 'ENTRADA' THEN
		SELECT PF.ENTRADA INTO registro_antigo FROM PONTO_FUNCIONARIO PF
		WHERE PF.CPF = cpf_alterado
		AND   PF.ID_PONTO = id_eventual;
		IF registro_antigo <> registro_novo THEN
			PERFORM inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE  PONTO_FUNCIONARIO SET ENTRADA = CAST(registro_novo AS TIMESTAMP)--time_registro_novo
				WHERE CPF = cpf_alterado --faltou id, ele estava dando update em todos
				AND   ID_PONTO = id_eventual;
			RETURN 1;
		ELSE 
			RETURN 0;
		END IF;
	ELSIF campo = 'SAIDA' THEN
		SELECT PF.SAIDA INTO registro_antigo FROM PONTO_FUNCIONARIO PF
		WHERE PF.CPF = cpf_alterado
		AND   PF.ID_PONTO = id_eventual;
		IF registro_antigo <> registro_novo THEN
			PERFORM  inserir_log(data_hora, tabela, campo, registro_antigo,
				cpf_alterado, cpf_responsavel);
			UPDATE PONTO_FUNCIONARIO SET SAIDA = CAST(registro_novo AS TIMESTAMP)--time_registro_novo
				WHERE CPF = cpf_alterado --faltou id, ele estava dando update em todos
				AND   ID_PONTO = id_eventual;
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

-- FUNÇÃO QUE INSERE NA TABELA LOG_ALTERACAO
-- CHAMADA:
-- inserir_log($data_hora, $tabela, $campo, $registro_antigo, $cpf_alterado, $cpf_responsavel)
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