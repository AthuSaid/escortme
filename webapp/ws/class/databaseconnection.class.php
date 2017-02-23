<?php

use Medoo\Medoo;

/**
* 
*/
class DatabaseConnection{
	
  private static $database = null;

	public static function get(){
    if(self::$database == null){
      self::$database = new Medoo([
        'database_type' => 'mysql',
        'database_name' => 'escortme',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8'
      ]);
    }

    return self::$database;
	}
}

?>