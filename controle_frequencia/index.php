<?php
clearstatcache();
if((isset($_SESSION['logged'])) && $_SESSION['logged']) {
    header("Location: php/home.php");
    exit;
}

require_once 'php/dict.inc.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Code Plus - Login</title>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Pacifico|Roboto+Slab:400,700" 
        rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <link rel="icon" href="img/favicon.png" sizes="16x16" type="image/png">


        <?php
        if (isset($_GET['msg'])) {
            switch ($_GET['msg']) {
                case md5('LOGIN_FAULT'):
                    $S_msg = $dict[$_GET['msg']];
                    break;
                default:
                    $S_msg = 'Efetue o login.';
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
        <!--CABEÇALHO COM LOGO-->
        <header>
            <section>
                <img src="img/logo.png" alt="logo" class="logo">
            </section>
            
            <section>    
                <div id="login_fun">
                    <h1>Login de Funcionários</h1>
                </div>
            </section>
        </header>
        
        <section class="img_fundo">
            
        </section>
        
        <section>
                <!--DIV 2 COM CAMPOS DE E-MAIL E SENHA-->
            <div id="inserir">
                <form name="formlogin" method="post" action="php/login.php">
                    <label for="email">E-mail:</label>
                    <input id="email" type="text" name="email" placeholder="exemplo@codeplus.com.br" required><br />
                    <label for="senha">Senha:</label>
                    <input id="senha" type="password" name="senha" placeholder="**********"><br><br>
        <!--"BOTÕES" ESQUECI A SENHA E ENTRAR-->
                    <a href="#">Esqueci minha senha?</a> 
                    <button id="enviar" type="submit" name="entrar">Entrar</button>
                </form>
            </div>
        </section>
        
    </body>
</html>
