<?php
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
        <link rel="stylesheet" type="text/css" href="../css/layout.css">
        <!-- Inserção de jquery -->
        <script src="../javascript/jquery-3.2.1.min.js"></script>
        <!--  Inserção de funções para os botões -->
        <script src="../javascript/jquery.js"></script>
        <!--Mensagem de erro para senha incorreta-->
        <?php
        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case md5('SENHA_FAULT'):
                    $S_msg = $senha_fault[$_GET['msg']];
                    break;
                default:
                    $S_msg = 'A senha inserida está incorreta.';
                    break;
            }
                
        ?>
        <script type="text/javascript">
            window.onload = function() {
                alert('<?php echo $S_msg; ?>');
            }
        </script>
        <?php
        }
        ?>
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
                    <li><a href="#">NOVO CADASTRO</a></li>
                </ul>
            </nav>
        
        </section>
        
        <!--FAÇA O CONTEUDO DO CODIGO A PARTIR DESSE PONTO-->
        
        <section class="cont">
        <!--INSIRA OS DADOS AQUI-->
        
        <!--Formulário para alteração de senha-->
        <center><br><br>
        <h4>Alterar Senha:</h4> 
          <form name="alterar_senha" id="alterar_senha" method="post" action="alterar_senha.php">
             <p><input type="password" id="old_password" name="old_password" placeholder="Senha Antiga"></input></p> <br>
              <p><input type="password" id="new_password" name="new_password" placeholder="Senha Nova"></input></p> <br>
              <p><input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirme senha Nova"></input></p> 
              <br>
              <button id="confirmar" type="submit" name="confirmar">Confirmar</button>
          </form>
        
        <script type="text/javascript" src="../javascript/alterasenha.js"></script>
        </center>

        </section>
        
    </body>
</html>