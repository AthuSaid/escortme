<?php

# Inserts a ChatMessage
# Sets a ChatMessage-Notification

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.chat.create');
$db = DatabaseConnection::get();

$chatService = new ChatService($logger, $db);
$ns = new NotificationService($logger, $db);

$chatId = $_REQUEST['chat_id'];
$msg = $_REQUEST['msg'];

//TODO: Check Permissions
$msgId = $chatService->insertMessage($chatId, $user['id'], $msg);

//Send Notification
$ns->createForChatMsg($msgId);