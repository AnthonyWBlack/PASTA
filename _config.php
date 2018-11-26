<?php
$protocol = "http";
$domain = "barcodebattler.co.uk";
$path = "pasta";
$index = $protocol . "://" . $domain . "/" . $path;

/* SQL Access Levels -
0: SELECT only
1: INSERT, SELECT and UPDATE
2: CREATE, DELETE, DROP, INSERT, SELECT and UPDATE
*/

$MySQL_SVR = "localhost";
$MySQL_DB = "barcrco_pasta";
$MySQL_UN = array("barcrco_pastaGuest","barcrco_pastaUser","barcrco_pastaAdmin");
$MySQL_PW = array("c@Nn3l!on1", "t0rt3!lin1", "5p@gH3tT1");
?>