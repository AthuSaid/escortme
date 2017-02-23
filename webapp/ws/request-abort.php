<?php

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$rs = new RequestService($logger, $db);

$reqId = $_REQUEST['req_id'];
$rs->abort($reqId, $user['id']);