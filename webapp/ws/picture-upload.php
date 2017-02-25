<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.offer.reject');
$db = DatabaseConnection::get();

$pictureService = new PictureService($logger, $db);

try {
	$picId = $pictureService->upload($_FILES, $user['id']);
	$myGallery = $pictureService->getGallery($user['id']);
	if(count($myGallery) == 1){
		$pictureService->setProfilePicture($picId, $user['id']);
	}
} catch (Exception $e) {
	echo $e->getMessage();
}