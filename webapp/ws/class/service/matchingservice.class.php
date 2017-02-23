<?php

/**
* 
*/
class MatchingService {
	
	private $logger;
	private $db;

	function __construct($logger, $db) {
		$this->logger = $logger;
		$this->db = $db;
	}

	public function getServices($request){
		return $this->db->select("esc_service", [
			"[><]esc_user" => ["user_id"=>"id"]
		],[
			""
		]);
	}

	public function getRequests($service){
		return $this->db->select("esc_request", [
			"[><]esc_user" => ["user_id"=>"id"]
		],[
			""
		]);
	}

}

?>