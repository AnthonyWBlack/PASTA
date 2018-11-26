<?php
$pastaDBE = false;
$pastaDBC = mysqli_connect($MySQL_SVR, $MySQL_UN[1], $MySQL_PW[1], $MySQL_DB);
if(!$pastaDBC){
	$pastaDBE = true;
}
?>