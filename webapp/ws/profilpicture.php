<?php

# Sets the given picture as profil picture of the user

require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.profilpicture');
$db = DatabaseConnection::get();

$pictureService = new PictureService($logger, $db);

$picId = $_REQUEST['picture_id'];

$pictureService->setProfilePicture($picId, $user['id']);