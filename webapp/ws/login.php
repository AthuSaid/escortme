<?php

require 'class/loader.php';
classloader("../");

$logger = LogFactory::logger("ws.login");
$db = DatabaseConnection::get();

$userService = new UserService($logger, $db);

$email = $_REQUEST['email'];
$pw = $_REQUEST['pw'];

$id = $userService->getUser($email, $pw);

$result = array("success" => 0);

if($id != null){
	SessionManager::login($id);
	$result = array("success" => 1);
}

echo json_encode($result);


?>