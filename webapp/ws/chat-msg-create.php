<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.chat.create');
$db = DatabaseConnection::get();

$chatService = new ChatService($logger, $db);

$chatId = $_REQUEST['chat_id'];
$msg = $_REQUEST['msg'];

//TODO: Check Permissions
$chatService->insertMessage($chatId, $user['id'], $msg);

//Send Notification