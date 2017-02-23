<?php

/**
* 
*/
class ListeningService{
    
    private $user;
    private $logger;
    private $db;

    function __construct($user, $logger, $db){
        $this->user = $user;
        $this->logger = $logger;
        $this->db = $db;
    }

    public function enable($httpRequest){
        $this->logger->info('User is now active listening');
        $this->db->update("esc_user", ["listening" => 1], ["id" => $this->user["id"]]);

        $ss = new ServiceService($this->logger, $this->db);
        $latest = $ss->getLatestService($this->user["id"]);
        $current = $ss->fromHttp($httpRequest, $this->user["id"]);
        if($latest == null || !$ss->compare($latest, $current)){
            $ss->create($current);
        }
    }

    public function disable(){
        $this->logger->info('User is not anymore active listening');
        $this->db->update("esc_user", ["listening" => 0], ["id" => $this->user["id"]]);
    }
}

?>