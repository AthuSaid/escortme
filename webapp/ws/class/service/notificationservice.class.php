<?php

/**
* 
*/
class NotificationService {
	
    private $logger;
    private $db;

    function __construct($logger, $db) {
        $this->logger = $logger;
        $this->db = $db;
    }

    /**
     * Creates a BaseNotification and returns the id
     * @param  [uuid] $usrId [The user who needs to see the notification]
     * @return [uuid]        [Id of new created Notification]
     */
    private function createNotification($usrId){
        $id = Uuid::next();
        $this->db->insert("esc_bell", [
            "id" => $id,
            "user_id" => $usrId
        ]);
        return $id;
    }

    /**
     * Creates a new RequestNotification
     * @param  [array] $req [Needs to contain the id and user_id]
     * @return [uuid]      [Id of new created Notification]
     */
    public function createForRequest($req){
    	$bellId = $this->createNotification($req['user_id']);
        $this->db->insert("esc_bell_request", [
            "bell_id" => $bellId,
            "req_id" => $req['id']
        ]);
        return $bellId;
    }


    public function createForOffer($offerId){
        //DEBUG
        $reqId = $this->db->get("esc_offer", "req_id", ["id"=>$offerId]);
        $usrId = $this->db->get("esc_request", "user_id", ["id"=>$reqId]);
        $bellId = $this->createNotification($usrId);
        $this->db->insert("esc_bell_offer", [
            "bell_id" => $bellId,
            "offer_id" => $offerId
        ]);
        return $bellId;
    }

    public function createForChatMsg($msgId){
        $senderId = $this->db->get("esc_chat_msg",
            "sender_id", ["id" => $msgId]);
        $chatId = $this->db->get("esc_chat_msg", "chat_id", ["id"=>$msgId]);
        $users = $this->db->get("esc_chat", [
            "user1_id(user_1)",
            "user2_id(user_2)"
        ], [
            "id" => $chatId
        ]);
        $usrId = $users['user_1'];
        if($usrId == $senderId)
            $usrId = $users['user_2'];

        $bellId = $this->createNotification($usrId);
        $this->db->insert("esc_bell_msg", [
            "bell_id" => $bellId,
            "msg_id" => $msgId
        ]);
        return $bellId;
    }

    public function getNotifications($usrId){
        $notifications = $this->db->select("esc_bell", ["id", "created"], [
            "user_id" => $usrId //TODO: Implement seen is null
        ]);

        $userService = new UserService($this->logger, $this->db);
        $reqService = new RequestService($this->logger, $this->db);



        foreach ($notifications as &$bell) {
            //Request
            $reqId = $this->db->get("esc_bell_request", "req_id", [
                "bell_id" => $bell['id']
            ]);
            if($reqId){
                $bell['type'] = "R";
                $request = $reqService->getRequest($reqId);
                $profile = $userService->getProfile($request['user_id']);
                $bell['data'] = [
                    "req_id" => $reqId,
                    "targetTime" => $request['targetTime'],
                    "description" => $request['description'],
                    "sender" => [
                        "user_id" => $profile['id'],
                        "firstName" => $profile['firstName'],
                        "age" => $profile['age'],
                        "picture" => $profile['picture']
                    ]
                ];
                continue;
            }


            //Offer
            $offerId = $this->db->get("esc_bell_offer", "offer_id", [
                "bell_id" => $bell['id']
            ]);
            if($offerId){
                $bell['type'] = "O";
                $usrId = $this->db->get("esc_offer", "user_id",[
                    "id" => $offerId
                ]);
                $profile = $userService->getProfile($usrId);
                $bell['data'] = [
                    "offer_id" => $offerId,
                    "sender" => [
                        "user_id" => $profile['id'],
                        "firstName" => $profile['firstName'],
                        "age" => $profile['age'],
                        "picture" => $profile['picture']
                    ]
                ];
                continue;
            }
            


            //Msg
            $msgId = $this->db->get("esc_bell_msg", "msg_id", [
                "bell_id" => $bell['id']
            ]);
            if($msgId){
                $bell['type'] = "M";
                $data = $this->db->get("esc_chat_msg",
                    ["content", "chat_id", "sender_id"],
                    ["id" => $msgId]);

                $profile = $userService->getProfile($data['sender_id']);
                $bell['data'] = [
                    "chat_id" => $data['chat_id'],
                    "content" => $data['content'],
                    "sender" => [
                        "user_id" => $profile['id'],
                        "firstName" => $profile['firstName'],
                        "age" => $profile['age'],
                        "picture" => $profile['picture']
                    ]
                ];
                continue;
            }
        }

        return $notifications;
    }

    public function seen($bellId){
        $this->db->update("esc_bell",
            ["seen" => "NOW()"],
            ["id" => $bellId]);
    }


}