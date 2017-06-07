<?php
	clearstatcache();
	$e = @$_GET['e'];
	//retornar erro e sucesso
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Cadastramento de Senha!</title>
	<meta charset="utf-8">
    <script type="text/javascript" src="../javascript/jquery.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
        rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="../css/Cadsenha.css">
</head>
<body>
    <header>
            
            <section class="logomarca">
            <a href="../index.php">
                <img class="logo" src="../img/logo.png" alt="logo">  
                </a>
            </section>
            
    </header>
    
	<div id="input-email">
    
        <form name="login" action="passCadastration.php?e=<?php echo $e ?>" method="post">
	
        <h1>CADASTRAR SENHA</h1>
           
          <h2>E-mail:
		  <input required type="text" name="email" maxlength="25" size="25"  placeholder="Digite seu email" /></h2>
		  <h2>Senha:
		  <input required type="password" name="password" maxlength="25" size="25"  placeholder="Digite uma senha" /></h2>
		  <h2>Confirmar Senha:
		  <input id="conf" required type="password" name="passwordConfirm" maxlength="25" size="25"  placeholder="Confirme sua senha"/></h2>
		
		  <input id="botao" type="submit" value="Cadastrar" />
        
        </form>
           
    </div>
         
    
</body>
</html>