<?php

session_start();

function classloader($pathToRoot){
  
  error_reporting(E_ALL);

  require $pathToRoot.'ws/vendor/autoload.php';

  require $pathToRoot.'ws/class/util/databaseconnection.class.php';
  require $pathToRoot.'ws/class/util/logger.class.php';
  require $pathToRoot.'ws/class/util/uuid.class.php';
  require $pathToRoot.'ws/class/util/sessionmanager.class.php';
  require $pathToRoot.'ws/class/util/datetimeformater.class.php';

  require $pathToRoot.'ws/class/service/serviceservice.class.php';
  require $pathToRoot.'ws/class/service/listeningservice.class.php';
  require $pathToRoot.'ws/class/service/requestservice.class.php';
  require $pathToRoot.'ws/class/service/matchingservice.class.php';
  require $pathToRoot.'ws/class/service/userservice.class.php';
  require $pathToRoot.'ws/class/service/pictureservice.class.php';
  require $pathToRoot.'ws/class/service/offerservice.class.php';
  require $pathToRoot.'ws/class/service/chatservice.class.php';
  require $pathToRoot.'ws/class/service/registerservice.class.php';
  require $pathToRoot.'ws/class/service/notificationservice.class.php';

  require $pathToRoot.'ws/class/lib/imagemanipulator.class.php';
}

?>