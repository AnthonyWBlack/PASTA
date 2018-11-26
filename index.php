<?php
header('Content-Type: text/html; charset=iso-8859-1');
require_once '_config.php';
require_once 'common.php';
$inst = 0;
if(isset($_GET["u"], $_GET["v"])){
	// End User Email Address Confirmation
	$inst = 4;
	include 'dbConnect1.php';
	if(!$pastaDBE){
		$pastaSQL = "UPDATE `ppl` SET `EmailConf`=1 WHERE `ID`=" . sanitize($_GET["u"]) . " AND `Cookie`='" . sanitize($_GET["v"]) . "'";
		mysqli_query($pastaDBC, $pastaSQL);
		include 'dbDisconnect.php';	
	}
}
if(isset($_GET["U"], $_GET["C"])){
	// End User Auto-login
	$inst = 400;
}
?><!DOCTYPE html><html><head>
<link rel="stylesheet" type="text/css" href="pasta.css" />
<link rel="icon" type="image/png" href="http://barcodebattler.co.uk/pasta/icon.png" />
<title>PASTA: Login</title>
<script>
var PASTA_IDX = "<?php echo($index); ?>";
<?php
if($inst == 400){
	echo("var urlData = {\r\n\td0: " . sanitize($_GET["U"]) . ",\r\n\td1: \"" . sanitize($_GET["C"]) . "\"\r\n};\r\n");
}
?>
</script>
<script src="pasta.js"></script>
<script src="ajax.js"></script>
</head><body onLoad="startUp(<?php echo($inst); ?>);">
<div class="pastaHead">PASTA<div class="pastaHeadSub">Pro-Active System for Tracking Assets</div></div>
<div class="pastaNav" id="pNav">·</div>
<div class="pastaContent" id="pCon">...</div>
<div class="pastaLoader"><canvas id="display" width="256" height="256">If you can read this, you'll need to upgrade to a browser which can render the CANVAS tag.</canvas></div>
</body></html>