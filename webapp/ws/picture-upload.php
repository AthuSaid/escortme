<?php


require 'class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('ws.offer.reject');
$db = DatabaseConnection::get();

$pictureService = new PictureService($logger, $db);

$result = ["success" => 0];

try {
	$picId = $pictureService->upload($_FILES, $user['id']);
	$myGallery = $pictureService->getGallery($user['id']);
	if(count($myGallery) == 1){
		$pictureService->setProfilePicture($picId, $user['id']);
	}

	$result["success"] = 1;
	$result["picture"] = $picId;
} catch (Exception $e) {
	$result["success"] = 0;
	$result["msg"] = $e->getMessage();
}

echo json_encode($result);