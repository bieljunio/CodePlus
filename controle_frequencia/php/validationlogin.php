<?php 
    session_start();
    
    if($_SESSION['logged'] == false){       
        header("Location: ../index.php");      
    }

?>