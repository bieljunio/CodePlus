<?php

    require 'validationlogin.php';
  

?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"/>
    </head>
    <body>
        <form id="registerPoint" name="registerPoint" method="post" action="registerPoint.php">
            <input type="submit" name="in" value="Registrar Entrada"/>
            <input type="submit" name="out" value="Registrar Saída" />
        </form>
        WELCOME!
        <br><br>
        <h3><a href="logout.php">LOGOUT</a></h3>
    </body>
</html>
