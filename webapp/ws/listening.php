<?php

# This will be called, when someone starts or stops listening
# starting: the service will be received and inserted into the db
# stoping: only the flag will be disabled

require 'class/loader.php';
classloader("../");



$user = SessionManager::user();
$logger = LogFactory::logger('ws.listening');
$db = DatabaseConnection::get();

$ls = new ListeningService($user, $logger, $db);

$active = $_REQUEST['listening'];

try{
    if($active){
        $ls->enable($_REQUEST);
    }
    else{
        $ls->disable();
    }
}
catch(Exception $e){
    $logger->err("Fehler beim Service: $e", $_REQUEST);
}

?>