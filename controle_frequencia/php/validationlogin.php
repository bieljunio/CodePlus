<?php 
    session_start();
    
    if($_SESSION['logged'] == true){
        echo 'OK';        
    }else{
        header("Location: ../index.php");      
    }

?>