-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 23, 2018 at 02:53 PM
-- Server version: 10.0.36-MariaDB-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `barcrco_pasta`
--

-- --------------------------------------------------------

--
-- Table structure for table `faultComments`
--

CREATE TABLE `faultComments` (
  `ID` int(10) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  `FaultID` int(10) UNSIGNED NOT NULL,
  `DateLogged` bigint(20) UNSIGNED NOT NULL,
  `Body` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faultComments`
--

INSERT INTO `faultComments` (`ID`, `userID`, `FaultID`, `DateLogged`, `Body`) VALUES
(1, 2, 1, 1542982080, 'Please can you install Encarta 97 on my PC?');

-- --------------------------------------------------------

--
-- Table structure for table `faults`
--

CREATE TABLE `faults` (
  `ID` int(10) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  `roomID` int(10) UNSIGNED NOT NULL,
  `assetID` int(10) UNSIGNED NOT NULL,
  `DateLogged` bigint(20) UNSIGNED NOT NULL,
  `DateModified` bigint(20) UNSIGNED NOT NULL,
  `DateClosed` bigint(20) UNSIGNED NOT NULL,
  `DateDeadline` bigint(20) UNSIGNED NOT NULL,
  `Severity` int(10) UNSIGNED NOT NULL,
  `FaultType` int(10) UNSIGNED NOT NULL,
  `AssignedTech` int(10) UNSIGNED NOT NULL,
  `ManagerTech` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faults`
--

INSERT INTO `faults` (`ID`, `userID`, `roomID`, `assetID`, `DateLogged`, `DateModified`, `DateClosed`, `DateDeadline`, `Severity`, `FaultType`, `AssignedTech`, `ManagerTech`) VALUES
(1, 2, 0, 0, 1542982080, 1542982080, 0, 0, 1, 3, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faultTypes`
--

CREATE TABLE `faultTypes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faultTypes`
--

INSERT INTO `faultTypes` (`ID`, `Name`) VALUES
(1, 'Hardware Fault'),
(2, 'Vandalism Report'),
(3, 'Software Install'),
(4, 'Hardware Install');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Instruction` smallint(5) UNSIGNED NOT NULL,
  `Title` tinytext NOT NULL,
  `MenuList` tinytext NOT NULL,
  `Content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`ID`, `Instruction`, `Title`, `MenuList`, `Content`) VALUES
(1, 0, 'Login', '0,1,2', '<div class=\"pastaForm\"><div class=\"pastaFormCenter\">Admin Logon</div><form id=\"loginForm\"><div class=\"pastaFormLeft\">Username</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" id=\"loginUN\" /></div><br /><div class=\"pastaFormLeft\">Password</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" type=\"password\" id=\"loginPW\" /></div><br /><br /><div class=\"pastaFormCenter\"><input type=\"button\" value=\"Login\" class=\"pastaButton\" onClick=\"loginForm();\" /></div></form></div><hr />Welcome to PASTA. If you are an administrator, please log in.<br />If you have registered to report faults, please use the link emailed to you.<br />If you have yet to register or have lost your registration email, please request access to our help desk using the relevant form below.<hr /><div class=\"pastaForm\"><div class=\"pastaFormCenter\">User Sign-up Request</div><form id=\"supForm\"><div class=\"pastaFormLeft\">email Address</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" id=\"supEML\" /></div><br /><div class=\"pastaFormLeft\">First Name</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" id=\"supFN\" /></div><br /><div class=\"pastaFormLeft\">Last Name</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" id=\"supSN\" /></div><br /><br /><div class=\"pastaFormCenter\"><input type=\"button\" value=\"Request\" class=\"pastaButton\" onClick=\"signUpForm();\" /></div></form></div>By submitting your details, you are agreeing with our terms of service, which may be found on our About page.<hr /><div class=\"pastaForm\"><div class=\"pastaFormCenter\">Recover Lost Login</div><form><div class=\"pastaFormLeft\">email Address</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" /></div><br /><br /><div class=\"pastaFormCenter\"><input type=\"button\" value=\"Recover\" class=\"pastaButton\" /></div></form></div>'),
(2, 1, 'About', '0,1,2', '<div class=\"pastaSubHead\">About PASTA</div>The Pro-Active System for Tracking Assets (or PASTA if you prefer) is an all-in-one asset register and service desk.<br />If you would like to discover more about PASTA, please visit our Contact Us page and fill in the form.<br /><br />Please note that this site is currently a work in progress. I will keep you updated of the site\'s progress on this page. Admin login functionality is now working. Task submission and user management features are now being added.<br /><br /><div class=\"pastaSubHead\">Cookies Policy</div>This site uses cookies to maintain login sessions. We do not permit the use of third-party cookies on this site; this protects our users and their data from unsolicited tracking and marketing. We do not collect or store any person details through the use of cookies.<br /><br /><div class=\"pastaSubHead\">How We use Your Data</div>If you have created an account with PASTA, we will have made a record of some of your personal details. It is our policy not to sell your personal details on to any third parties. At your request, we will give you a record of any personal data belonging to you, and delete it when instructed.'),
(3, 2, 'Contact Us', '0,1,2', '<div class=\"pastaForm\"><div class=\"pastaFormCenter\">Contact Us</div><form><div class=\"pastaFormLeft\">email Address</div><div class=\"pastaFormRight\"><input class=\"pastaFormInput\" /></div><br /><div class=\"pastaFormLeft\">Your Message</div><br /><div class=\"pastaFormCenter\"><textarea rows=\"8\" cols=\"45\"></textarea></div><br /><div class=\"pastaFormCenter\"><input type=\"button\" value=\"Send Message\" class=\"pastaButton\" /></div></form></div><hr />If you have a question, complaint or compliment regarding PASTA, please fill in the above form with your email address and message, and a member of our team will respond as soon as they are available.'),
(4, 400, 'Dashboard', '401,402,403,499', 'Welcome to PASTA. Please select one of the above options to begin.'),
(5, 100, 'Dashboard', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Tasks</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(106)\">Open Tasks (0)</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(107)\">Closed Tasks (0)</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(108)\">Severities</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(109)\">Types</a></div><br /><br /><div class=\"pastaSubHead\">Assets</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(110)\">Assets (0)</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(111)\">Manufacturers</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(112)\">Models</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(113)\">Types</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(114)\">RAM Capacities</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(115)\">Aspect Ratios</a></div><br /><br /><div class=\"pastaSubHead\">Premises</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(116)\">Maps</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(117)\">Rooms</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(118)\">VLANs</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(119)\">Network Ports</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(120)\">Network Switches</a></div><br /><br /><div class=\"pastaSubHead\">Users</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(121)\">Accounts</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(122)\">Contact Us</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(123)\">Sign Up Requests</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(124)\">My Account</a></div><br /><br /><div class=\"pastaSubHead\">Pages</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(125)\">Pages</a></div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(126)\">Forms</a></div>'),
(6, 401, 'Log Fault', '401,402,403,499', '<div class=\"pastaFormWide\"><div class=\"pastaFormCenter\">Log a Fault or Service Request</div><form><div class=\"pastaFormLeft\">Severity<select class=\"pastaFormInput\" id=\"LogFaultSev\" />##OPT:0##</select></div><div class=\"pastaFormRight\">Type<select class=\"pastaFormInput\" id=\"LogFaultTyp\" />##OPT:1##</select></div><br /><div class=\"pastaFormLeft\">Comments</div><br /><div class=\"pastaFormCenter\"><textarea rows=\"12\" cols=\"90\" id=\"LogFaultCom\"></textarea></div><br /><div class=\"pastaFormCenter\"><input type=\"button\" value=\"Inform Technicians\" class=\"pastaButton\" onClick=\"logFault();\" /></div></form></div><hr />Please provide as much information as possible, including the location of the fault, which item(s) of equipment is/are involved and any error messages or codes, and a member of our team will respond as soon as they are available.'),
(7, 402, 'Open Faults', '401,402,403,499', 'The following jobs have been logged by you and have yet to be resolved.'),
(8, 403, 'Closed Faults', '401,402,403,499', 'A LIST OF RESOLVED FAULTS WHICH WERE OPENED BY THIS USER.'),
(9, 101, 'Tasks', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Tasks</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(106)\">Open Tasks (0)</a></div>&nbsp;Manage incomplete tasks.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(107)\">Closed Tasks (0)</a></div>&nbsp;Manage complete tasks.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(108)\">Severities</a></div>&nbsp;Manage task severity levels.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(109)\">Types</a></div>&nbsp;Manage task types.'),
(10, 102, 'Assets', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Assets</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(110)\">Assets (0)</a></div>&nbsp;Manage asset inventory.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(111)\">Manufacturers</a></div>&nbsp;Manage manufacturer list.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(112)\">Models</a></div>&nbsp;Manage model list.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(113)\">Types</a></div>&nbsp;Manage asset type list.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(114)\">RAM Capacities</a></div>&nbsp;Manage RAM capacity list.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(115)\">Aspect Ratios</a></div>&nbsp;Manage display aspect ratio list.<br /><br />'),
(11, 103, 'Premises', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Premises</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(116)\">Maps</a></div>&nbsp;Manage building maps.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(117)\">Rooms</a></div>&nbsp;Manage room details.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(118)\">VLANs</a></div>&nbsp;Manage VLAN records.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(119)\">Network Ports</a></div>&nbsp;Manage network port list.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(120)\">Network Switches</a></div>&nbsp;Manage network switch records.<br /><br />'),
(12, 104, 'Users', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Users</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(121)\">Accounts</a></div>&nbsp;Manage user accounts.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(122)\">Contact Us</a></div>&nbsp;Read and respond to Contact Us messages.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(123)\">Sign Up Requests</a></div>&nbsp;Manage new user account requests.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(124)\">My Account</a></div>&nbsp;Manage your account details.<br /><br />'),
(13, 105, 'Pages', '101,102,103,104,105,199', '<div class=\"pastaSubHead\">Pages</div><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(125)\">Pages</a></div>&nbsp;Manage page content.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(126)\">Forms</a></div>&nbsp;Manage forms.<br /><br />'),
(14, 499, 'Log Out', '401,402,403,499', 'To log out, click on the Close Session button below. To stay logged in, use any of the options in the above menu.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(99)\">Close Session</a></div>'),
(15, 199, 'Log Out', '101,102,103,104,105,199', 'To log out, click on the Close Session button below. To stay logged in, use any of the options in the above menu.<br /><br /><div class=\"pastaDashLink\"><a class=\"pastaNavI\" href=\"javascript:loadM(99)\">Close Session</a></div>'),
(16, 106, 'Open Tasks', '101,106,107,108,109', 'OPEN TASK LIST.'),
(17, 107, 'Closed Tasks', '101,106,107,108,109', 'CLOSED TASK LIST.'),
(18, 108, 'Severities', '101,106,107,108,109', 'SEVERITY LIST.'),
(19, 109, 'Types', '101,106,107,108,109', 'FAULT TYPE LIST.'),
(20, 110, 'Assets', '102,110,111,112,113,114,115', 'ASSET REGISTER.'),
(21, 111, 'Manufacturers', '102,110,111,112,113,114,115', 'LIST OF MANUFACTURERS.'),
(22, 112, 'Models', '102,110,111,112,113,114,115', 'LIST OF MODELS.'),
(23, 113, 'Types', '102,110,111,112,113,114,115', 'LIST OF ASSET TYPES.'),
(24, 114, 'RAM Capacities', '102,110,111,112,113,114,115', 'RAM CAPACITY LIST.'),
(25, 115, 'Aspect Ratios', '102,110,111,112,113,114,115', 'LIST OF DISPLAY ASPECT RATIOS.'),
(26, 116, 'Maps', '103,116,117,118,119,120', 'LIST OF MAPS.'),
(27, 117, 'Rooms', '103,116,117,118,119,120', 'LIST OF ROOMS.'),
(28, 118, 'VLANs', '103,116,117,118,119,120', 'LIST OF VIRTUAL NETWORKS.'),
(29, 119, 'Network Ports', '103,116,117,118,119,120', 'LIST OF NETWORK PORTS.'),
(30, 120, 'Network Switches', '103,116,117,118,119,120', 'LIST OF NETWORK SWITCHES.'),
(31, 121, 'Accounts', '104,121,122,123,124', 'Use the list below to manage active user accounts.'),
(32, 122, 'Contact Us', '104,121,122,123,124', 'READ AND RESPOND TO MESSAGES.'),
(33, 123, 'Sign Up Requests', '104,121,122,123,124', 'Use the list below to manage account requests.'),
(34, 124, 'My Account', '104,121,122,123,124', 'MANAGE YOUR ACCOUNT HERE.'),
(35, 125, 'Pages', '105,125,126', 'MANAGE PAGE CONTENT.'),
(36, 126, 'Forms', '105,125,126', 'MANAGE FORMS.'),
(37, 99, 'Logged Out', '0,1,2', 'Thank you for using PASTA. You are now logged out.'),
(38, 3, 'Sign Up Request', '0,1,2', 'Thank you, your sign-up request has been received.<br />Please check your email inbox for a link to confirm your email address.<br />Our Admin team will grant you access to our services once they have verified your details.'),
(39, 4, 'Email Confirmed', '0,1,2', 'Thank you for confirming your email address.<br /><br />You will receive an email from our Admin team once they have verified your details.<br />Once you have received this email, you will be able to use our services.'),
(40, 404, 'Task Logged', '401,402,403,499', 'Thank you for logging your job. Our technicians have been informed.');

-- --------------------------------------------------------

--
-- Table structure for table `ppl`
--

CREATE TABLE `ppl` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Username` tinytext NOT NULL,
  `NaCl` tinytext NOT NULL,
  `Hash` tinytext NOT NULL,
  `OrgID` int(10) UNSIGNED NOT NULL,
  `Level` int(10) UNSIGNED NOT NULL,
  `Email` tinytext NOT NULL,
  `EmailConf` tinyint(1) NOT NULL,
  `Created` bigint(20) UNSIGNED NOT NULL,
  `LogonTime` bigint(20) UNSIGNED NOT NULL,
  `ActiveTime` bigint(20) UNSIGNED NOT NULL,
  `LogoutTime` bigint(20) UNSIGNED NOT NULL,
  `Cookie` tinytext NOT NULL,
  `Title` tinytext NOT NULL,
  `FirstName` tinytext NOT NULL,
  `Surname` tinytext NOT NULL,
  `Telephone` tinytext NOT NULL,
  `Mobilephone` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ppl`
--

INSERT INTO `ppl` (`ID`, `Username`, `NaCl`, `Hash`, `OrgID`, `Level`, `Email`, `EmailConf`, `Created`, `LogonTime`, `ActiveTime`, `LogoutTime`, `Cookie`, `Title`, `FirstName`, `Surname`, `Telephone`, `Mobilephone`) VALUES
(1, 'blackt', '8fhVuhjFSopUqlLbJoNykj2I0voTocWwxeuwh,7CofkJDcOEsys7F9ZcsVBdNByJFoxo1B.qkN884XSC1NrYPsVtLohlKdV6uIfZ6mqI4Oi.wEa3OTsXCW,GdFOsJCxm', 'b780fae6874c9288e1944d2908837ed545c34226d84100b2c15959b88f3bbba93946ac6f', 0, 1, 'anthony.w.black@outlook.com', 1, 0, 1542972345, 1542972350, 1542972350, 'CLOSED', 'Mr', 'Tony', 'Black', '01302??????', '07949739335'),
(2, 'blacka', '', '', 0, 4, 'combatking0@hotmail.com', 1, 1542292293, 1542982045, 1542983840, 1542972471, 'KIT6eV5UMI4RhEBoSBTp7tOt615IdB4t', '', 'Anthony', 'Black', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `severities`
--

CREATE TABLE `severities` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Name` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `severities`
--

INSERT INTO `severities` (`ID`, `Name`) VALUES
(1, 'Single User'),
(2, 'Multiple Users'),
(3, 'Multiple Rooms'),
(4, 'Whole Organisation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faultComments`
--
ALTER TABLE `faultComments`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faults`
--
ALTER TABLE `faults`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `faultTypes`
--
ALTER TABLE `faultTypes`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ppl`
--
ALTER TABLE `ppl`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `severities`
--
ALTER TABLE `severities`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faultComments`
--
ALTER TABLE `faultComments`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faults`
--
ALTER TABLE `faults`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faultTypes`
--
ALTER TABLE `faultTypes`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `ppl`
--
ALTER TABLE `ppl`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `severities`
--
ALTER TABLE `severities`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
