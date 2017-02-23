<?php

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$rs = new RequestService($logger, $db);

//Create Request
$request = $rs->fromHttp($_REQUEST, $user['id']);
$request = $rs->create($request);

//Pass request to MatchingService and send Notifications

?>