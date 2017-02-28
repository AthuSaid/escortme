<?php

#Loads the image of the data store
#
#IMPLEMENT: 
#	Permissions
#	Default Picture if no id is set (maybe logo)


$id = "default";
if(isset($_REQUEST['picture_id']))
	$id = $_REQUEST['picture_id'];

$type = "thumbnail";
if(isset($_REQUEST['type']))
	$type = $_REQUEST['type'];


$name = $id."-".$type.".jpg";
$path = '../data/'.$name;


//File exists
if(!file_exists($path))
	$path = '../data/default-'.$type.".jpg";

$fp = fopen($path, 'rb');

header("Content-Type: image/jpg");
header("Content-Length: " . filesize($path));

fpassthru($fp);