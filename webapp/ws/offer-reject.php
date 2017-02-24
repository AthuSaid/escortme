<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.offer.reject');
$db = DatabaseConnection::get();

$os = new OfferService($logger, $db);
$rs = new RequestService($logger, $db);

$profilId = $_REQUEST['user_id'];

$req = $rs->getActiveRequest($user['id']);

$os->reject($req['id'], $profilId);