<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
* 
*/
class LogFactory{
	
	protected static $log = null;

	public static function get(){
		if(self::$log == null){
			self::$log = new Logger('escortme');
			self::$log->pushHandler(new StreamHandler('../log/escorme.log'), Logger::WARNING);
		}
		return self::$log;
	}

	public static function logger($channel){
		$logger = new Logger($channel);
		$logger->pushHandler(new StreamHandler('../log/escorme.log'), Logger::WARNING);
		return $logger;
	}

	public static function warn($msg){
		self::get()->warn($msg);
	}

	public static function error($msg){
		self::get()->err($msg);
	}

	public static function info($msg){
		self::get()->info($msg);
	}

	public static function critical($msg){
		self::get()->crit($msg);
	}

	public static function debug($msg){
		self::get()->debug($msg);
	}

	public static function emergency($msg){
		self::get()->emerg($msg);
	}
}

?>