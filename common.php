<?php
function sanitize($ipt){
	$opt = str_replace("=","&#61;",$ipt);
	$opt = str_replace("*","&#42;",$ipt);
	$opt = str_replace("'","&#39;",$opt);
	$opt = str_replace("\r\n","<br />",$opt);
	$opt = str_replace("\n","<br />",$opt);
	$opt = str_replace("\r","<br />",$opt);
	return($opt);
}
?>