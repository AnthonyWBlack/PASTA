<?php
$pastaDBE = false;
$pastaDBC = mysqli_connect($MySQL_SVR, $MySQL_UN[0], $MySQL_PW[0], $MySQL_DB);
if(!$pastaDBC){
	$pastaDBE = true;
}
?>