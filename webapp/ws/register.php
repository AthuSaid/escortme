<?php


require 'class/loader.php';
classloader("../");

$logger = LogFactory::logger('ws.register');
$db = DatabaseConnection::get();

$regService = new RegisterService($logger, $db);


$ok = $regService->setData($_REQUEST);

if($ok && $regService->allSet()){
    $usrId = $regService->register();

    if($usrId != null){
        //Credit Card
        if($regService->creditSet()){
            $regService->registerCredit($usrId);
        }

        $regService->clear();

        //Login
        SessionManager::login($usrId);

        //Result
        $result = [
            "success" => 1,
            "email" => $regService->get(RegisterService::EMAIL),
            "pw" => $regService->get(RegisterService::PW)
        ];
        echo json_encode($result);
        die();
    }

    $result = ["success" => 0];
    echo json_encode($result);
    die();
}

$result = ["success" => 0];
if($ok)
    $result = ["success" => 1];

echo json_encode($result);