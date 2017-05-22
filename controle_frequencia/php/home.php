<?php
    require 'validationlogin.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"/>
        <title>Home</title>
    </head>
    <body>
    <?php 
    $S_in = md5('entry');
    $S_out = md5('exit');
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d');
    $tm_date = date('H:i:s');
    echo "$date $tm_date";
    echo "<p><a href='registerPoint.php?in={$S_in}'>Registrar Entrada</a></p>";
    echo "<p><a href='registerPoint.php?in={$S_out}'>Registrar Saída</a></p>";
	?>
        WELCOME!
        <br><br>
        <h3><a href="logout.php">LOGOUT</a></h3>
    </body>
</html>
