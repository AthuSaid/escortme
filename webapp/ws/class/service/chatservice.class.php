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

    public function getChatPartner($chatId, $usrId){
        $chat = $this->db->get("esc_chat", [
            "user1_id",
            "user2_id"
          ], [
            "id" => $chatId
          ]);
        if(!$chat)
            return null;

        $profilId = $chat['user1_id'];
        if($profilId == $usrId)
            $profilId = $chat['user2_id'];

        $userSerice = new UserService($this->logger, $this->db);
        return $userSerice->getProfile($profilId);
    }

    public function getLastMessage($chat){
        $lastMsg = $this->db->get("esc_chat_msg", [
            "id",
            "sender_id",
            "content",
            "created"
          ], [
            "chat_id" => $chat['id'],
            "ORDER" => ["created" => "DESC"]
          ]);

        if(!$lastMsg)
            return null;
        $lastMsg['sender'] = "Du";
        if($lastMsg['sender_id'] == $chat['profile']['id'])
            $lastMsg['sender'] = $chat['profile']['firstName'];

        return $lastMsg;
    }

    /**
     * Reads all Messages of a chat.
     * Also sets the seen flag for the notification_bell
     * @param  [type] $chatId [description]
     * @param  [type] $usrId  [description]
     * @return [type]         [description]
     */
    public function getMessages($chatId, $usrId){
        $msgs = $this->db->select("esc_chat_msg", [
            "id",
            "sender_id",
            "content",
            "created"
          ], [
            "chat_id" => $chatId,
            "ORDER" => [ "created" => "ASC"]
          ]);

        $notifyService = new NotificationService($this->logger, $this->db);

        $result = array();
        foreach ($msgs as $msg) {
            $msg['isSender'] = $msg['sender_id'] == $usrId ? 1 : 0;
            $result[] = $msg;

            //Notification
            if(!$msg['isSender']){
                $notifyService->msgBellSeen($msg['id']);
            }
        }

        return $result;
    }

    public function insertMessage($chatId, $senderId, $msg){
        $msgId = Uuid::next();
        $this->db->insert("esc_chat_msg", [
            "id" => $msgId,
            "chat_id" => $chatId,
            "sender_id" => $senderId,
            "content" => $msg
          ]);

        return $msgId;
    }

    public function delete($chatId){
        //TODO: IMPLEMENT
    }

}

?>