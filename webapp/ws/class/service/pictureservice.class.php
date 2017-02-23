<?php


/**
* 
*/
class PictureService{
    
    private $logger;
    private $db;

    function __construct($logger, $db){
        $this->logger = $logger;
        $this->db = $db;
    }

    public function getGallery($userId){
        $pics = $this->db->select("esc_picture", "id", [
            "user_id" => $userId,
            "ORDER" => "created"
          ]);
        $gallery = array();
        if(count($pics) > 0)
            $gallery = $pics;
        return $gallery;
    }
    
}

?>