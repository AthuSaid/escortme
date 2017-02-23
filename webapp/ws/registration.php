<?php

require 'class/loader.php';

define("EMAIL", "registration::email", true);
define("PASSWORD", "registration::pw", true);
define("FIRSTNAME", "registration::firstname", true);
define("LASTNAME", "registration::lastname", true);
define("GENDER", "registration::gender", true);
define("DOB", "registration::dob", true);

$email = isset($_SESSION[EMAIL]) ? $_SESSION[EMAIL] : null;
$password = isset($_SESSION[PASSWORD]) ? $_SESSION[PASSWORD] : null;
$firstname = isset($_SESSION[FIRSTNAME]) ? $_SESSION[FIRSTNAME] : null;
$lastname = isset($_SESSION[LASTNAME]) ? $_SESSION[LASTNAME] : null;
$gender = isset($_SESSION[GENDER]) ? $_SESSION[GENDER] : null;
$dob = isset($_SESSION[DOB]) ? $_SESSION[DOB] : null;

if(isset($_REQUEST[EMAIL])) $email = $_REQUEST[EMAIL];
if(isset($_REQUEST[PASSWORD])) $email = $_REQUEST[PASSWORD];
if(isset($_REQUEST[FIRSTNAME])) $email = $_REQUEST[FIRSTNAME];
if(isset($_REQUEST[LASTNAME])) $email = $_REQUEST[LASTNAME];
if(isset($_REQUEST[GENDER])) $email = $_REQUEST[GENDER];
if(isset($_REQUEST[DOB])) $email = $_REQUEST[DOB];

if($email != null &&
	$password != null &&
	$firstname != null &&
	$lastname != null &&
	$gender != null &&
	$dob != null){
	
}

?>