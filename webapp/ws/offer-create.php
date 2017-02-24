<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$os = new OfferService($logger, $db);

$reqId = $_REQUEST['req_id'];

$os->create($reqId, $user['id']);