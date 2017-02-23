<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.home');
$db = DatabaseConnection::get();

$data = array(
	"firstName" => $user['firstName'],
	"picture" => $user['picture']
);

header('Content-Type: application/json');
echo json_encode($data);

?>