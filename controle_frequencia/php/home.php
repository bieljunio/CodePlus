<?php
    require 'validationlogin.php';
    require 'dict.inc.php';
?>

<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8"/>
        <title>Home</title>
    </head>
    
    <?php 
	if (isset($_GET['msg'])) {
		switch ($_GET['msg']) {
			case md5('ENTRY_SUCCESS'):
				$S_msg = $dict[$_GET['msg']];
				break;
			case md5('ENTRY_FAIL'):
				$S_msg = $dict[$_GET['msg']];
				break;
			default:
				$S_msg = 'Operação já efetuada!';
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
    
    <body>
    <?php 
    $S_in = md5('entry');
    $S_out = md5('exit');
    echo "<p><a href='registerPoint.php?in={$S_in}'>Registrar Entrada</a></p>";
    echo "<p><a href='registerPoint.php?in={$S_out}'>Registrar Saída</a></p>";
	?>
	
        WELCOME!
        <br><br>
        <h3><a href="logout.php">LOGOUT</a></h3>
        
    </body>
</html>
