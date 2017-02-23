<?php

/**
* 
*/
class RequestService {
	
    private $logger;
    private $db;

    function __construct($logger, $db) {
        $this->logger = $logger;
        $this->db = $db;
    }

    public function getActiveRequest($userId){
        $result = $this->db->select("esc_request", "*", [
            "user_id" => $userId,
            "#expires[>]" => "NOW()",
            "aborted" => "FALSE"
        ]);
        $request = null;
        if(count($result) > 0){
            $request = $result[0];
            $request['restTime'] = $this->calcRestTime($request['expires']);
            $request['targetTime'] = $this->splitTargetTime($request['targetTime']);
        }
        return $request;
    }

    public function getLatestRequest($userId){
        $result = $this->db->select("esc_request", "*", [
            "user_id" => $userId,
            "ORDER" => [
                "created" => "DESC"
            ],
            "LIMIT" => "1"
        ]);
        $request = null;
        if(count($result) > 0){
            $request = $result[0];
            $request['restTime'] = $this->calcRestTime($request['expires']);
        }
        return $request;
    }

    public function fromHttp($http, $userId){
        $request = array();
        $request['user_id'] = $userId;
        $request['targetTime'] = $http['targetTime'];
        $request['ageFrom'] = $http['ageFrom'];
        $request['ageTo'] = $http['ageTo'];
        $request['maxPrice'] = $http['maxPrice'];
        $request['level'] = $http['level'];
        $request['expires'] = $this->clacExpireTime($http['duration']);
        $request['description'] = $http['description'];
        return $request;
    }

    public function clacExpireTime($duration){
        $date = new DateTime();
        $duration = floatval($duration);
        $durationMinTotal = $duration * 60;
        $date->add(new DateInterval('PT' . $durationMinTotal . 'M'));       
        return $date->format('Y-m-d H:i:s');
    }

    public function calcRestTime($expireTime){
        $expireDate = DateTime::createFromFormat('Y-m-d H:i:s', $expireTime);
        $nowDate = new DateTime();
        $diff = $expireDate->getTimestamp() - $nowDate->getTimestamp();
        return $diff;
    }

    public function splitTargetTime($fullDate){
        $parts = explode(" ", $fullDate);
        $date = DateTime::createFromFormat('Y-m-d H:i:s', $parts[0]." 00:00:00");
        $time = explode(":", $parts[1]);
        $time = $time[0].":".$time[1];
        return array('date' => $date, 'time' => $time);
    }

    public function validate($request){
        //TODO: Implement
    }

    public function create($request){
        $reqId = Uuid::next();
        $request['id'] = $reqId;
        $this->validate($request);
        $this->db->insert("esc_request", $request);
        return $request;
    }

}


?>