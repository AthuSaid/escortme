<?php

# This will be called, after a notification got seen
# so the flag will be set 

require 'class/loader.php';
classloader("../");



$user = SessionManager::user();
$logger = LogFactory::logger('ws.listening');
$db = DatabaseConnection::get();

$bellId = $_REQUEST['bell_id'];

$notifyService = new NotificationService($logger, $db);
$notifyService->seen($bellId);