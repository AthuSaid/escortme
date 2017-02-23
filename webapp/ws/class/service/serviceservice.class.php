<?php


/**
* 
*/
class ServiceService{
    
    private $logger;
    private $db;

    function __construct($logger, $db){
        $this->logger = $logger;
        $this->db = $db;
    }

    public function getLatestService($userId){
        $result = null;
        $service = $this->db->select("esc_service", "*", [
            "user_id" => $userId,
            "ORDER" => [
                "created" => "DESC"
            ],
            "LIMIT" => "1"
        ]);
        if($service && count($service) > 0)
            $result = $service[0];
        return $result;
    }

    public function compare($one, $two){
        return $one["user_id"] == $two["user_id"] &&
            $one["curriculum"] == $two["curriculum"] &&
            $one["minPrice"] == $two["minPrice"] &&
            $one["level"] == $two["level"] &&
            $one["genderM"] == $two["genderM"] &&
            $one["genderF"] == $two["genderF"] &&
            $one["genderT"] == $two["genderT"];
    }

    public function validate($service){
        if($service['level'] != 'A' && $service['level'] != 'P' &&
            $service['level'] != 'V'){
            throw new Exception('No valid Level');
        }
        if(!$service['genderM'] && !$service['genderF'] &&
            !$service['genderT']){
            throw new Exception('No gender selected');
        }
    }

    public function fromHttp($http, $userId){
        $service = array();
        $service["user_id"] = $userId;
        $service["curriculum"] = $http['curriculum'];
        $service["minPrice"] = floatval($http['minPrice']);
        $service["level"] = $http['level'];
        $service["genderM"] = $http['genderM'] == "true" ? 1 : 0;
        $service["genderF"] = $http['genderF'] == "true" ? 1 : 0;
        $service["genderT"] = $http['genderT'] == "true" ? 1 : 0;
        return $service;
    }

    public function create($service){
        $id = Uuid::next();
        $service["id"] = $id;
        $this->validate($service);
        $this->db->insert("esc_service", $service);
        return $service;
    }
}

?>