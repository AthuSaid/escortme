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
        $result = $this->db->select("esc_chat", [
            "id",
            "user1_id",
            "user2_id",
            "created"
          ], [
            "OR" => [
              "user1_id" => $usrId,
              "user2_id" => $usrId
            ]
          ]);

        $userSerice = new UserService($this->logger, $this->db);
        $chats = array();
        foreach ($result as $chat) {
            $profilId = $chat['user1_id'];
            if($chat['user1_id'] == $usrId)
                $profilId = $chat['user2_id'];
            $chat['profile'] = $userSerice->getProfile($profilId);
            $chat['lastMsg'] = $this->getLastMessage($chat);
            $chats[] = $chat;
        }

        return $chats;
    }

    public function getLastMessage($chat){
        $lastMsg = $this->db->get("esc_chat_msg", [
            "id",
            "sender_id",
            "content",
            "created"
          ], [
            "chat_id" => $chat['id']
          ]);

        if(!$lastMsg)
            return null;
        $lastMsg['sender'] = "Du";
        if($lastMsg['sender_id'] == $chat['profile']['id'])
            $lastMsg['sender'] = $chat['profile']['firstName'];

        return $lastMsg;
    }

    public function getMessages($chatId){

    }

    public function insertMessage($chatId, $msg){

    }

    public function delete($chatId){
        //TODO: IMPLEMENT
    }

}

?>