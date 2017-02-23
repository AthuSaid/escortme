<?php

# This will be called, when someone starts or stops listening
# starting: the service will be received and inserted into the db
# stoping: only the flag will be disabled

require 'class/loader.php';
classloader("../");



$user = SessionManager::user();
$logger = LogFactory::logger('ws.listening');
$db = DatabaseConnection::get();

$userService = new UserService($logger, $db);

$user['firstName'] = $_REQUEST['firstName'];
$user['gender'] = $_REQUEST['gender'];
$user['dob'] = $_REQUEST['dob'];

$userService->update($user);