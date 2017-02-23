<?php

# Returns all Requests which are matched to the latest service
# of the loggedin-user

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.listening-requests');
$db = DatabaseConnection::get();

//Get Matching Requests
$svcService = new ServiceService($logger, $db);
$matService = new MatchingService($logger, $db);

$svc = $svcService->getLatestService($user['id']);
$matches = $matService->matchRequests($svc);

header('Content-Type: application/json');
echo json_encode($matches);