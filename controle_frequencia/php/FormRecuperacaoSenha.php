<?php

require 'bd.php';

	clearstatcache();
	$c = @$_GET['c'];


	$cpf = pg_query("SELECT cpf, nome FROM funcionario");


		//Encontra em qual cpf deve ser feito a alteração
		for($i = 0; $i < pg_num_rows($cpf); $i++){
			$cpfarray = pg_fetch_array($cpf, $i, PGSQL_NUM);

			if (md5($cpfarray[0]) === $c) {
				$cpfrecuperacao = $cpfarray[0];
			}
		}

//Verifica se existe uma request de alteração de senha
//Se não houver, o link é inválido
	$sqlrequest = <<<HEREDOC
		SELECT COUNT(*)
			FROM LOG_ALTERACAO
				WHERE CPF_ALTERADO = '$cpfrecuperacao'
				AND CPF_RESPONSAVEL = '$cpfrecuperacao'
				AND REGISTRO_ANTIGO = 'REQUEST'
HEREDOC;
$request = pg_query($sqlrequest);
$request = pg_fetch_result($request, 0, 0);
if ($request <= 0) {
	//Mensagem de link inválido
	echo <<<HEREDOC
		<script type="text/javascript">
	   		alert('Link inválido');
	   		location.href="../index.php"
	</script>
HEREDOC;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Recuperar Senha</title>
	<meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
        rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/RecSenha.css">
</head>
<body>
    <header>
            
            <section class="logomarca">
            <a href="../index.php">
                <img class="logo" src="../img/logo.png" alt="logo">  
                </a>
            </section>
            
    </header>
    
    <div id="RecSenha">
        
    <h1>RECUPERAR SENHA</h1>
    
    <form name="formrecuperacao" method="post" action="recuperacaosenha.php?c=<?php echo $c ?>">
    
	   <h2>Digite uma nova senha:
	   <input required type="password" name="newpassword" placeholder="Digite uma nova senha"/></h2>
	   <h2>Confirme sua senha:
	   <input required id="conf" type="password" name="confirmpassword" placeholder="Confirme sua senha"/></h2>
    
	   <button id="botao" type="submit" name="confirmar">Confirmar</button>  
        
    </form>
        
    </div>
</body>
</html>
