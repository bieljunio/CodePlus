<?php
	header("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-cache, cachehack=".time());
	header("Cache-Control: no-store, must-revalidate");
	header("Cache-Control: post-check=-1, pre-check=-1", false);
    require 'validationlogin.php';
    require_once 'dict.inc.php';
?>
<!DOCTYPE html>
<html lang="pt_br">
    
    <head>
        <title>Code Plus - Home</title>
        <!-- Favicon -->
        <link rel="icon" href="../img/favicon.png" type="image/png">
        <!-- inclusões iniciais do arquivo html -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- fontes do google -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
        rel="stylesheet" type="text/css">
        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="../css/colaboradores.css">
        
        <!--  JavaScript, Jquery, AJAX -->
		<script src="../javascript/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="../javascript/ajax.js" type="text/javascript"></script>
		<script src="https://use.fontawesome.com/3a0cc21044.js"></script>
		
    </head>

    <body>
        <header>
            
            <section class="logomarca">
                <a href="home.php">
                    <img class="logo" src="../img/logo.png" alt="logo">
                </a>
            </section>
            
            <section>
                <nav id="registros">
                    <ul>
                        <li><a href="" onclick="return registerEntry();">Registrar Entrada</a></li>
                        <li><a href="" onclick="return registerExit();">Registrar Saída</a></li>
                    </ul>
                </nav>
            </section>
            
            <section class="box">
                <div class="dropdown">
                    <img class="seta" src="../img/seta.png" alt="seta" />
                    <img class="redondo" src="../img/perfil.png"   alt="Foto Perfil" />
                    <div class="dropdown_content">
                        <a class="ac_perfil" href="#">Acessar perfil</a>
                        <a class="al_senha" href="AlteracaoSenhaFront.php">Alterar senha</a>
                        <a class="sair" href="logout.php">Sair</a>
                    </div>
                </div>
            </section>
            
       </header>
            
        <section>
            
            <nav id="menu">
                <ul>
                    <li><a href="#">FUNCIONÁRIOS</a></li>
                    <li><a href="#">CONSULTAR FREQUÊNCIA</a></li>
                    <li><a href="form_cadastro.php">NOVO CADASTRO</a></li>
                </ul>
            </nav>
        
        </section>
        
        <section class="cont">
        <!-- Pesquisa por nome do colaborador -->
        <div id="busca">
            <form method="POST" class="form">
            
                 <h3>FILTRAR BUSCA</h3>
			     <input type="text" name="nameFilter" placeholder="Digite um nome" />
			     <input type="submit" value="Pesquisar" />
            
            </form>
        </div>
            
		
			<table id="table" cellspacing="0">
				<thead>
					<tr>
						<th>NOME</th>
						<th>SETOR</th>
						<th>FERRAMENTAS</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>		
			
        </section>
    <div id="rodape">
        
            <br>
            <p>Copyright &copy; 2017 - CodePlus</p>
        
    </div>
        <!-- TESTE -->
    </body>
</html>
