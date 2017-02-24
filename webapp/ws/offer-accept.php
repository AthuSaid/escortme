<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$os = new OfferService($logger, $db);
$rs = new RequestService($logger, $db);
$cs = new ChatService($logger, $db);

$profilId = $_REQUEST['user_id'];

$req = $rs->getActiveRequest($user['id']);

$os->accept($req['id'], $profilId);
$chatId = $cs->create($user['id'], $profilId);

$response = array("id" => $chatId);

echo json_encode($response);