<?php
$pastaDBE = false;
$pastaDBC = mysqli_connect($MySQL_SVR, $MySQL_UN[2], $MySQL_PW[2], $MySQL_DB);
if(!$pastaDBC){
	$pastaDBE = true;
}
?>