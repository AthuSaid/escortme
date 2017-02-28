<?php

# Creates a new Request

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.request.create');
$db = DatabaseConnection::get();

$rs = new RequestService($logger, $db);
$ms = new MatchingService($logger, $db);
$ns = new NotificationService($logger, $db);

//Create Request
$request = $rs->fromHttp($_REQUEST, $user['id']);
$request = $rs->create($request);

//Pass request to MatchingService and send Notifications
$services = $ms->matchServices($request);
foreach ($services as $svc) {
	$ns->createForRequest($request, $svc['user_id']);
}

?>