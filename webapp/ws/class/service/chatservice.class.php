<?php

/**
* 
*/
class ChatService {
	
	private $logger;
	private $db;

	function __construct($logger, $db) {
		$this->logger = $logger;
		$this->db = $db;
	}

	public function create($usr1, $usr2){
		$chatId = Uuid::next();
        $this->db->insert("esc_chat", [
            "id" => $chatId,
            "user1_id" => $usr1,
            "user2_id" => $usr2
          ]);
        return $chatId;
	}

    public function getChats($usrId){

    }

    public function getMessages($chatId){

    }

    public function inserMessage($chatId, $msg){

    }

    public function delete($chatId){

    }

}

?>