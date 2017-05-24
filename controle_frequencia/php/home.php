<?php
    require 'validationlogin.php';
    require 'dict.inc.php';
?>

<!DOCTYPE html>
<html>

    <head>
    	<title>Home</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"/>
        <script src="../javascript/jquery-3.2.1.min.js"></script>
        <script src="../javascript/jquery.js"></script>
        
    </head>
    <body>
		<p>WELCOME!</p>
        <br><br>
       	<p><a href="" onclick="return registerEntry();">Registrar Entrada</a></p>
        <p><a href="" onclick="return registerExit();">Registrar Saída</a></p>
        <h3><a href="logout.php">LOGOUT</a></h3>
        
        
    </body>
</html>
