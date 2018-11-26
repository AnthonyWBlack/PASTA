<?php
header('Content-Type: text/html; charset=iso-8859-1');
require '_config.php';
require_once 'common.php';
$clientData = array();
$cookieIn = "";
$cookieOut = "";
$content = "";
$debug = "";
$delimit = chr(127);
$instruction = "0";
$levels = ["Unverified", "Admin", "Low Admin", "Technician", "End User"];
$mainTitle = "PASTA: ";
$menu = "";
$title = "";
$userID = 0;
$userName = "";
$userLevel = 0;
$userValid = false;

if(isset($_POST["pastaCMD"])){
	$ipt = sanitize($_POST["pastaCMD"]);
	$clientData = explode($delimit, $ipt);
	$instruction = substr($clientData[0], 1);
	if(isset($_COOKIE["PASTA_User"]) || isset($clientData[1], $clientData[2])){
		if($instruction > 98){
			$userValid = userPersist($instruction);
		}else{
			
		}
	}
}

// Pull static page content from the database
include 'dbConnect0.php';
if($pastaDBE){
	$title = "ERROR";
	$menu = "!";
	$content = "A database connection error has occurred. Please be patient while our admin team works to fix the problem and try again later.";
}else{
	$pastaSQL = "SELECT * FROM `pages` WHERE `Instruction`=" . $instruction;
	if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
		while($pastaRow = mysqli_fetch_array($pastaDBR)){
			$title = $pastaRow["Title"];
			$menuCodes = explode(",", $pastaRow["MenuList"]);
			$content = $pastaRow["Content"];
		}
		mysqli_free_result($pastaDBR);
	}else{
		$title = "ERROR";
		$menu = "!";
		$content = "A page was requested that does not exist in our database. Please be patient while our admin team works to fix the problem and try again later.<br />Error Code = Ix" . $instruction;
	}
	for($i = 0; $i < count($menuCodes); $i++){
		$pastaSQL = "SELECT `Title` FROM `pages` WHERE `Instruction`=" . $menuCodes[$i];
		if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
			if($i > 0){
				$menu .= " · ";
			}
			while($pastaRow = mysqli_fetch_array($pastaDBR)){
				if($menuCodes[$i] == $instruction){
					$css = "A";
				}else{
					$css = "I";
				}
				$menu .= "<a href=\"javascript:loadM(" . $menuCodes[$i] . ")\" class=\"pastaNav" . $css . "\">" . $pastaRow["Title"] . "</a>";
			}
			mysqli_free_result($pastaDBR);
		}
	}
	include 'dbDisconnect.php';
}

// Generate dynamic page content
if($userValid){
	$content = "Logged in as " . $userName . ".<br /><br />" . $content;
	switch($instruction){
		case 99:
		// Close user session
		userClose($userName);
		$userName = "Logged Out";
		break;
		case 100:
		// Admin Login
		
		break;
		case 121:
		// Activated User Account Panel
		$content .= "<table border=\"1\"><tr><th>ID</th><th>Username</th><th>Level</th><th>Logon</th><th>Logout</th><th>First Name</th><th>Surname</th><th>Contact</th><th>Password</th><th>Edit</th><th>Close</th></tr>";
		include 'dbConnect1.php';
		$updateEml = "";
		$updateLevel = 0;
		$updateUser = 0;
		$vCode = "";
		if(!$pastaDBE){
			$pastaSQL = "SELECT `ID`, `Username`, `Level`, `Email`, `LogonTime`, `LogoutTime`, `Title`, `FirstName`, `Surname` FROM `ppl` WHERE `Level`>0";
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
					if($pastaRow["ID"] == $userID){
						$pwd_reset_button = "&nbsp;";
						$contactButton = "&nbsp;";
						$editButton = "&nbsp;";
						$deleteButton = "&nbsp;";
					}else{
						switch($pastaRow["Level"]){
							case 1:
							$pwd_reset_button = pastaButton("Reset Password", "issuePwd", $pastaRow["ID"]);
							break;
							case 4:
							$pwd_reset_button = pastaButton("Issue Shortcut", "issuePwd", $pastaRow["ID"]);
							break;
						}
						$contactButton = pastaButton("Send Message", "newFeature", $pastaRow["ID"]);
						$editButton = pastaButton("Edit Account", "newFeature", $pastaRow["ID"]);
						$deleteButton = pastaButton("Close Account", "newFeature", $pastaRow["ID"]);
					}
					if(isset($clientData[1], $clientData[2]) && $pastaRow["ID"] == $clientData[1] && $clientData[2] == "EmailPass"){
						$updateEml = $pastaRow["Email"];
						$updateUser = $pastaRow["ID"];
						$updateLevel = $pastaRow["Level"];
						$pwd_reset_button = "Email Sent";
					}
					$tableRow = "<tr><td>" . $pastaRow["ID"] . "</td><td>" . $pastaRow["Username"] . "</td><td>" . $levels[$pastaRow["Level"]] . "</td><td>" . date("d/m/Y Hi", $pastaRow["LogonTime"]) . "</td><td>" . date("d/m/Y Hi", $pastaRow["LogoutTime"]) . "</td><td>" . $pastaRow["FirstName"] . "</td><td>" . $pastaRow["Surname"] . "</td><td>" . $contactButton . "</td><td>" . $pwd_reset_button . "</td><td>" . $editButton . "</td><td>" . $deleteButton . "</td></tr>";
					$content .= $tableRow;
				}
				mysqli_free_result($pastaDBR);
				if($updateUser > 0){
					switch($updateLevel){
						case 1:
						// Reset admin password and Hash and email to 
						break;
						case 4:
						$vCode = ranString(32);
						$pastaSQL = "UPDATE `ppl` SET `Cookie`='" . $vCode . "' WHERE `ID`=" . $updateUser;
						sendMail($updateEml, 1, $updateUser, $vCode);
						break;
					}
				}
			}
			include 'dbDisconnect.php';
		}
		$content .= "</table>";
		break;
		case 123:
		// Account Request Panel
		$content .= "<table border=\"1\"><tr><th>ID</th><th>Username</th><th>Level</th><th>Logon</th><th>Logout</th><th>First Name</th><th>Surname</th><th>Verify</th><th>Close Account</th></tr>";
		include 'dbConnect1.php';
		if(!$pastaDBE){
			if(isset($clientData[1], $clientData[2]) && $clientData[2] == "EmailConf"){
				$pastaSQL = "UPDATE `ppl` SET `Level`=4 WHERE `ID`=" . $clientData[1];
				mysqli_query($pastaDBC, $pastaSQL);
				$content .= $clientData[1] . "<br />";
			}
			$pastaSQL = "SELECT `ID`, `Username`, `Level`, `LogonTime`, `LogoutTime`, `Title`, `FirstName`, `Surname` FROM `ppl` WHERE `Level`=0";
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
				$tableRow = "<tr><td>" . $pastaRow["ID"] . "</td><td>" . $pastaRow["Username"] . "</td><td>" . $levels[$pastaRow["Level"]] . "</td><td>" . date("d/m/Y Hi", $pastaRow["LogonTime"]) . "</td><td>" . date("d/m/Y Hi", $pastaRow["LogoutTime"]) . "</td><td>" . $pastaRow["FirstName"] . "</td><td>" . $pastaRow["Surname"] . "</td><td>" . pastaButton("Verify", "verifyUser", $pastaRow["ID"]) . "</td><td>Close Account Button</td></tr>";
				$content .= $tableRow;
				}
				mysqli_free_result($pastaDBR);
			}
			include 'dbDisconnect.php';
		}
		$content .= "</table>";
		break;
		case 401:
		// End User Fault Log
		// Split content by ## and catch OPT commands
		$contentSections = explode("##", $content);
		for($i = 0; $i < count($contentSections); $i++){
			if(strpos($contentSections[$i], "OPT:") === 0){
				$contentSections[$i] = selectOptions($contentSections[$i]);
			}
		}
		$content = implode("", $contentSections);
		// Insert resulting option lists
		break;
		case 402:
		include 'dbConnect0.php';
		if(!$pastaDBE){
			$pastaSQL = "SELECT `ID`, `DateLogged`, `DateModified`, `Severity`, `FaultType` FROM `faults` WHERE `userID`=" . $userID . " AND `DateLogged` > `DateClosed`";
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
					$taskID = $pastaRow["ID"];
					$taskOutput = "<div class=\"pastaSubHead\">ID: " . $taskID . " | Logged: " . date("d/m/Y Hi", $pastaRow["DateLogged"]) . " | Modified: " . date("d/m/Y Hi", $pastaRow["DateLogged"]) . "</div>";
					$pastaSQL2 = "SELECT `DateLogged`, `Body` FROM `faultComments` WHERE `faultID`=" . $taskID;
					if($pastaDBR2 = mysqli_query($pastaDBC, $pastaSQL2)){
						while($pastaRow2 = mysqli_fetch_array($pastaDBR2)){
							$taskOutput .= date("d/m/Y Hi", $pastaRow2["DateLogged"]) . ": " . $pastaRow2["Body"] . "<hr />";
						}
					}
					mysqli_free_result($pastaDBR2);
					$content .= $taskOutput;
				}
				mysqli_free_result($pastaDBR);
			}
			include 'dbDisconnect.php';
		}
		break;
		case 404:
		// End User task submission
		include 'dbConnect1.php';
		if(!$pastaDBE){
			$now = time();
			$taskID = 0;
			$adminID = 1;
			$pastaSQL = "INSERT INTO `faults` (`userID`, `roomID`, `assetID`, `DateLogged`, `DateModified`, `DateClosed`, `DateDeadline`, `Severity`, `FaultType`, `AssignedTech`, `ManagerTech`) VALUES (" . $userID . ", 0, 0, " . $now . ", " . $now . ", 0, 0, " . $clientData[1] . ", " . $clientData[2] . ", " . $adminID . ", " . $adminID . ")";
			mysqli_query($pastaDBC, $pastaSQL);
			$pastaSQL = "SELECT `ID` FROM `faults` WHERE `userID`=" . $userID . " AND `DateLogged`=" . $now;
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
					$taskID = $pastaRow["ID"];
				}
			}
			mysqli_free_result($pastaDBR);
			$pastaSQL = "INSERT INTO `faultComments` (`userID`, `faultID`, `DateLogged`, `Body`) VALUES (" . $userID . ", " . $taskID . ", " . $now . ", '" . $clientData[3] . "')";
			mysqli_query($pastaDBC, $pastaSQL);
			$pastaSQL = "SELECT `Email` FROM `ppl` WHERE `ID`=" . $adminID;
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				$vCode = $userName . $delimit . $clientData[3];
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
					sendMail($pastaRow["Email"], 2, 0, $vCode);
				}
			}
			include 'dbDisconnect.php';
		}
		break;
	}
}else{
	if($instruction > 99){
		$title = "ERROR";
		$menu = "<a href=\"javascript:loadM(0)\" class=\"pastaNavI\">Back</a>";
		$content = "These user credentials do not exist in our database. Please use the 'Back' link in the above menu and try again.";
	}else{
		switch($instruction){
			case 4:
			// Email Address Validation
			if(isset($clientData[1], $clientData[2], $clientData[3])){
				include 'dbConnect1.php';
				if(!$pastaDBE){
					$foundRows = 0;
					$pastaSQL = "SELECT `ID` FROM `ppl` WHERE `Email` = '" . $clientData[1] . "'";
					if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
						while($pastaRow = mysqli_fetch_array($pastaDBR)){
							$foundRows++;
						}
						mysqli_free_result($pastaDBR);
					}
					if($foundRows == 0){
						$userName = strtolower($clientData[3]) . substr(strtolower($clientData[2]),0,1);
						$FirstName = capFirst($clientData[2]);
						$Surname = capFirst($clientData[3]);
						$UID = 0;
						$foundRows = 0;
						$pastaSQL = "SELECT `ID` FROM `ppl` WHERE `Surname` = '" . $clientData[3] . "' AND `FirstName` LIKE '" . substr($FirstName, 0, 1) . "%'";
						if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
							while($pastaRow = mysqli_fetch_array($pastaDBR)){
								$foundRows++;
							}
							mysqli_free_result($pastaDBR);
						}
						if($foundRows > 0){
							$userName .= ($foundRows + 1);
						}
						$vCode = ranString(16);
						$pastaSQL = "INSERT INTO `ppl` (`Username`, `OrgID`, `Level`, `Email`, `EmailConf`, `Created`, `Cookie`, `FirstName`, `Surname`) VALUES ('" . $userName . "', 0, 0, '" . $clientData[1] . "', 0, " . time() . ", '" . $vCode . "', '" . $FirstName . "', '" . $Surname . "')";
						mysqli_query($pastaDBC, $pastaSQL);
						$pastaSQL = "SELECT `ID` FROM `ppl` WHERE `Email`='" . $clientData[1] . "'";
						if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
							while($pastaRow = mysqli_fetch_array($pastaDBR)){
								$UID = $pastaRow["ID"];
							}
							mysqli_free_result($pastaDBR);
						}
						sendMail($clientData[1], 0, $UID, $vCode);
					}else{
						$content = "An account with this email address already exists in our records. Please use the Contact Us page to request an update from our Admin team.";
					}
				}
				include 'dbDisconnect.php';
			}else{
				$content = "PROCESS REQUEST FAILED - DATA NOT RECEIVED!";
			}
			break;
		}
	}
}

// Final data output
echo($mainTitle . $title . "··" . $menu . "··" . $content);

// Capitalise the first letter of a string
function capFirst($ipt){
	$opt = strtoupper(substr($ipt, 0, 1)) . strtolower(substr($ipt, 1));
	return($opt);
}

// Fast, consistent Button formatting
function pastaButton($label, $jsFunction, $pValue){
	$output = "<input class=\"pastaButton\" type=\"button\" value=\"" . $label . "\" onClick=\"" . $jsFunction . "(" . $pValue . ");\" />";
	return($output);
}

function selectOptions($optionID){
	global $MySQL_SVR, $MySQL_UN, $MySQL_PW, $MySQL_DB;
	include 'dbConnect0.php';
	$output = "<option value=\"0\">--Please Select--</option>";
	if(!$pastaDBE){
		$optionInst = substr($optionID, 4);
		switch($optionInst){
			case 0:
			$pastaSQL = "SELECT * FROM `severities`";
			break;
			case 1:
			$pastaSQL = "SELECT * FROM `faultTypes`";
			break;
		}
		if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
			while($pastaRow = mysqli_fetch_array($pastaDBR)){
				$output .= "<option value=\"" . $pastaRow["ID"] . "\">" . $pastaRow["Name"] . "</option>";
			}
			mysqli_free_result($pastaDBR);
		}
	}
	include 'dbDisconnect.php';
	return($output);
	//return($optionInst);
}

// Send Emails
function sendMail($eml, $inst, $uCode, $vCode){
	global $delimit, $index;
	$eol = "\n";
	$headers = "From: PASTA Admin Team<No-Reply-PASTA@barcodebattler.co.uk>\r\nReply-To: anthony.w.black@outlook.com\r\nMIME-Version: 1.0\r\n";
	$splitter = md5(time());
	switch($inst){
		case 0:
		$headers .= "Content-type:text/html;charset=UTF-8\r\n";
		$subject = "PASTA - Please Verify Your Email Address";
		$message = "<html><head><title>PASTA Email</title></head><body>Thank you for signing up with PASTA.<br /><br />Please verify your email address by visiting this address:<a href=\"http://barcodebattler.co.uk/pasta?u=" . $uCode . "&v=" . $vCode . "\">http://barcodebattler.co.uk/pasta?u=" . $uCode . "&v=" . $vCode . "</a><br /><br />If you have received this email unexpectedly and have not signed up to PASTA, please disregard and delete this email message.<br /><br />Kind regards,<br />PASTA Admin Team.</body></html>";
		mail($eml, $subject, $message, $headers);
		break;
		case 1:
		$headers .= "Content-Type: multipart/mixed; boundary=\"" . $splitter . "\"";
		$subject = "PASTA - Your Access Shortcuts";
		$attachWinMac = "[InternetShortcut]\r\nURL=" . $index . "?U=" . $uCode . "&C=" . $vCode . "\r\n";
		$attachLinux = "[Desktop Entry]\r\nEncoding=UTF-8\nIcon=text-html\r\nType=Link\r\nName=RFI\r\nURL=" . $index . "?U=" . $uCode . "&C=" . $vCode . "\r\n";
		$fNameWinMac = "PASTA_Logon_Windows_Mac.url";
		$fNameLinux = "PASTA_Logon_Linux.desktop";
		$fZip = new ZipArchive;
		$fZip->open("zip/PASTA_Logon.zip", ZipArchive::CREATE);
		$fZip->addFromString($fNameWinMac, $attachWinMac);
		$fZip->addFromString($fNameLinux, $attachLinux);
		$fZip->close();
		$file = fopen("zip/PASTA_Logon.zip","r");
		$fileData = fread($file, filesize("zip/PASTA_Logon.zip"));
		fclose($file);
		unlink("zip/PASTA_Logon.zip");
		$message .= "--" . $splitter . "\r\nContent-type:text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n<html><head><title>PASTA Email</title></head><body>Thank you for signing up with PASTA.<br /><br />Your PASTA access link is attached. Please download it and save it to a convenient location, such as your documents folder, desktop or favourites.<br /><br />To access PASTA, simply open the shortcut once you have saved it. You don't even need to remember your password.<br /><br />If you have received this email unexpectedly and have not signed up to PASTA, please disregard and delete this email message.<br /><br />Kind regards,<br />PASTA Admin Team.</body></html>\r\n--" . $splitter . "\r\nContent-Type: application/zip; name=\"PASTA_Logon.zip\"\r\nContent-Transfer-Encoding: base64\r\nContent-Disposition: attachment\r\n\r\n" . chunk_split(base64_encode($fileData)) . "\r\n\r\n--" . $splitter . "--";
		mail($eml, $subject, $message, $headers);
		break;
		case 2:
		$headers .= "Content-type:text/html;charset=UTF-8\r\n";
		$parts = explode($delimit, $vCode);
		$subject = "PASTA Service Desk - " . $parts[0] . "Has Logged A Task";
		$message = "<html><head><title>PASTA Email</title></head><body>" . $parts[0] . " has logged a task on PASTA. Please log in for full details.<br />" . $parts[1] . "</body></html>";
		mail($eml, $subject, $message, $headers);
		break;
	}
	//return($message);
}

// Close a user session
function userClose($UN){
	global $MySQL_SVR, $MySQL_UN, $MySQL_PW, $MySQL_DB, $userLevel;
	include 'dbConnect1.php';
	if($pastaDBE){
		$title = "ERROR";
		$menu = "<a href=\"javascript:loadM(0)\" class=\"pastaNavI\">Back</a>";
		$content .= "<br /><br />A database connection error has occurred. Please be patient while our admin team works to fix the problem and try again later.";
	}else{
		switch($userLevel){
			case 1:
			$pastaSQL = "UPDATE `ppl` SET `LogoutTime`=" . time() . ", `Cookie`='CLOSED' WHERE `Username`='" . $UN . "'";
			break;
			case 4:
			$pastaSQL = "UPDATE `ppl` SET `LogoutTime`=" . time() . " WHERE `Username`='" . $UN . "'";
			break;
		}
		mysqli_query($pastaDBC, $pastaSQL);
		include 'dbDisconnect.php';
		setcookie("PASTA_User", "CLOSED", time() - 3600);
	}
}

// Verify new and current user sessions
function userPersist($IN){
	global $clientData, $cookieIn, $cookieOut, $debug, $delimit, $MySQL_SVR, $MySQL_UN, $MySQL_PW, $MySQL_DB, $userID, $userName, $userLevel;
	$valid = false;
	include 'dbConnect1.php';
	if($pastaDBE){
		$title = "ERROR";
		$menu = "<a href=\"javascript:loadM(0)\" class=\"pastaNavI\">Back</a>";
		$content .= "<br /><br />A database connection error has occurred. Please be patient while our admin team works to fix the problem and try again later.";
	}else{
		if($IN == 100 || $IN == 400){
			// Initial Login
			switch($IN){
				case 400:
				$pastaSQL = "SELECT `UserName`, `Level` FROM `ppl` WHERE `ID`=" . $clientData[1] . " AND `Cookie`='" . $clientData[2] . "'";
				if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
					while($pastaRow = mysqli_fetch_array($pastaDBR)){
						$userName = $pastaRow["UserName"];
						$userLevel = $pastaRow["Level"];
						if($pastaRow["Level"] == 4){
							$valid = true;
							$dbCookie = $clientData[2];
							$pastaSQL = "UPDATE `ppl` SET `LogonTime`=" . time() . " WHERE `Username`='" . $userName . "'";
							mysqli_query($pastaDBC, $pastaSQL);
						}
					}
					mysqli_free_result($pastaDBR);
				}
				break;
				case 100:
				$userName = strtolower($clientData[1]);
				$pastaSQL = "SELECT `ID`, `NaCl`, `Hash`, `Level` FROM `ppl` WHERE `Username`='" . $userName . "'";
				if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
					while($pastaRow = mysqli_fetch_array($pastaDBR)){
						$userID = $pastaRow["ID"];
						$salt = $pastaRow["NaCl"];
						$userLevel = $pastaRow["Level"];
						$prePwd = $clientData[2] . $salt . $clientData[2];
						$m5 = md5($prePwd);
						$s1 = sha1($prePwd);
						$hash0 = $pastaRow["Hash"];
						$hash1 = $m5 . $s1;
						if($hash0 == $hash1){
							$valid = true;
							$pastaSQL = "UPDATE `ppl` SET `LogonTime`=" . time() . " WHERE `Username`='" . $userName . "'";
							mysqli_query($pastaDBC, $pastaSQL);
						}
					}
					mysqli_free_result($pastaDBR);
				}
				break;
			}
		}else{
			// Validate an existing user session
			$cookieIn = urldecode($_COOKIE["PASTA_User"]);
			$cookieData = explode($delimit, $cookieIn);
			$userName = strtolower($cookieData[0]);
			$pastaSQL = "SELECT `ID`, `Level`, `Cookie` FROM `ppl` WHERE `Username`='" . $userName . "'";
			if($pastaDBR = mysqli_query($pastaDBC, $pastaSQL)){
				while($pastaRow = mysqli_fetch_array($pastaDBR)){
					$userID = $pastaRow["ID"];
					$dbCookie = $pastaRow["Cookie"];
					$userLevel = $pastaRow["Level"];
					if($dbCookie == $cookieData[1]){
						$valid = true;
					}
				}
				mysqli_free_result($pastaDBR);
			}
		}
		if($valid){
			switch($userLevel){
				case 1:
				$cookieOut = ranString(64);
				$pastaSQL = "UPDATE `ppl` SET `ActiveTime`=" . time() . ", `Cookie`='" . $cookieOut . "' WHERE `Username`='" . $userName . "'";
				break;
				case 4:
				$cookieOut = $dbCookie;
				$pastaSQL = "UPDATE `ppl` SET `ActiveTime`=" . time() . " WHERE `Username`='" . $userName . "'";
				break;
			}
			$cookieOut = urlencode($userName . $delimit . $cookieOut);
			mysqli_query($pastaDBC, $pastaSQL);
			setcookie("PASTA_User", $cookieOut, time() + 3600);
		}
		include 'dbDisconnect.php';
	}
	return($valid);
}

function hashGen($pwd){
	global $delimit;
	$output = ranString(128);
	$prePwd = $pwd . $output . $pwd;
	$m5 = md5($prePwd);
	$s1 = sha1($prePwd);
	$output .= $delimit . $m5 . $s1;
	return($output);
}

function ranString($length){
	$alphanum = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_~";
	$output = "";
	for($i = 0; $i < $length; $i++){
		$ranChar = mt_rand(0,63);
		$output .= substr($alphanum, $ranChar, 1);
	}
	return($output);
}
?>