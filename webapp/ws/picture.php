<?php

#Loads the image of the data store
#
#IMPLEMENT: 
#	Permissions
#	Default Picture if no id is set (maybe logo)
#	Check if file exists, else Default


$id = "default";
if(isset($_REQUEST['picture_id']))
	$id = $_REQUEST['picture_id'];

$type = "thumbnail";
if(isset($_REQUEST['type']))
	$type = $_REQUEST['type'];


//TODO: RESET:
$type = "full";


$name = $id."-".$type.".jpg";
$path = '../data/'.$name;

$fp = fopen($path, 'rb');

header("Content-Type: image/jpg");
header("Content-Length: " . filesize($path));

fpassthru($fp);