<?php

# The Serverside script for SSE
# Returns in data an array of all open notifications

require 'class/loader.php';
classloader("../");

$notifications = array();
if(SessionManager::isLoggedIn()){
    $user = SessionManager::user();
    $logger = LogFactory::logger("ws.notifications");
    $db = DatabaseConnection::get();

    $notifyService = new NotificationService($logger, $db);

    $notifications = $notifyService->getNotifications($user['id']);
}

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

echo "id: " . time() . PHP_EOL;
echo "data: " . json_encode($notifications) . PHP_EOL;
echo PHP_EOL;
ob_flush();
flush();
