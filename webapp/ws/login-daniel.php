<?php

require 'class/loader.php';
classloader("../");

/*
Log::warn('Das ist eine Warnung!');
Log::error("Na toll, jetzt ist ein Fehler passiert..");
Log::info('Is the info working?');
Log::debug('Lil bit debug in my life, a  lil bit monica by my side');
Log::critical('OH MY GOD NO D:');
Log::emergency("Now its all over, we are dead!");




Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());
Log::info(Uuid::next());

*/

$myid = "b0cc2642-f904-11e6-b0df-d3f657d113e9"; //Daniel
$myid = "11fa6218-f905-11e6-b0df-d3f657d113e9"; //Lisa

SessionManager::login($myid);
//SessionManager::logout();

?>