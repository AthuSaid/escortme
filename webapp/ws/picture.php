<?php

#Loads the image of the data store
#
#IMPLEMENT: Permissions

$id = $_REQUEST['picture_id'];
$type = $_REQUEST['type'];

//TODO: RESET:
$type = "full";

$name = $id."-".$type.".jpg";


$path = '../data/'.$name;
$fp = fopen($path, 'rb');

header("Content-Type: image/jpg");
header("Content-Length: " . filesize($path));

fpassthru($fp);