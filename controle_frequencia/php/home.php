<?php
    require 'validationlogin.php';
    require_once 'dict.inc.php';
?>
<!DOCTYPE html>
<html lang="pt_br">
    
    <head>
    	<title>Code Plus - Home</title>
    	<!-- inclusões iniciais do arquivo html -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- fontes do google -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
        rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/layout.css">
        <!-- Inserção de jquery -->
        <script src="../javascript/jquery-3.2.1.min.js"></script>
        <!--  Inserção de funções para os botões -->
        <script src="../javascript/jquery.js"></script>
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
                        <a class="al_senha" href="#">Alterar senha</a>
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
                    <li><a href="#">NOVO CADASTRO</a></li>
                </ul>
            </nav>
        
        </section>
        
        <!--FAÇA O CONTEUDO DO CODIGO A PARTIR DESSE PONTO-->
        
        <section class="cont">
        <!--INSIRA OS DADOS AQUI-->
        </section>
        
    </body>
</html>