<?php

# Returns a list of all Pictures of a given user

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.gallery');
$db = DatabaseConnection::get();

$picService = new PictureService($logger, $db);


?>