
<?php
    require 'validationlogin.php';
    require_once 'dict.inc.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"/> 
      
        <script src="../javascript/jquery-3.2.1.min.js"></script>
        <script src="../javascript/jquery.js"></script>
      
        <title>Home</title>



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
    <?php 
    $S_in = md5('entry');
    $S_out = md5('exit');
    echo "<p><a href='registerPoint.php?in={$S_in}'>Registrar Entrada</a></p>";
    echo "<p><a href='registerPoint.php?in={$S_out}'>Registrar Saída</a></p>";
	?>
        WELCOME!
        <br><br>
      
         <br><br>
       	<p><a href="" onclick="return registerEntry();">Registrar Entrada</a></p>
        <p><a href="" onclick="return registerExit();">Registrar Saída</a></p>
        <h3><a href="logout.php">LOGOUT</a></h3>
        
        
        <h4>Alterar Senha:</h4> 
          <form name="alterar_senha" id="alterar_senha" method="post" action="alterar_senha.php">
              <input type="password" id="old_password" name="old_password" placeholder="Senha Antiga"></input><br><br>
              <input type="password" id="new_password" name="new_password" placeholder="Senha Nova"></input><br><br>
              <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirme senha Nova"></input><br><br>
              <br>
              <button id="confirmar" type="submit" name="confirmar">Confirmar</button>
          </form>
        
        <br><br>
        <h3><a href="logout.php">LOGOUT</a></h3>
        <script type="text/javascript" src="../js/alterasenha.js"></script>
    </body>
</html>
