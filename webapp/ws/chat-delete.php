<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.chat.delete');
$db = DatabaseConnection::get();

$chatService = new ChatService($logger, $db);

$chatId = $_REQUEST['chat_id'];

//TODO: Check Permissions
$chatService->delete($chatId);