<?php

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger("ws.notifications");
$db = DatabaseConnection::get();

$notifyService = new NotificationService($logger, $db);

$notifications = $notifyService->getNotifications($user['id']);

echo json_encode($notifications);
