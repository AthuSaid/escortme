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

    public function getRequest($reqId){
        $result = $this->db->select("esc_request", "*", [
            "id" => $reqId
          ]);
        $request = null;
        if(count($result) > 0){
            $request = $result[0];
            $request['restTime'] = $this->calcRestTime($request['expires']);
            $request['targetTime'] = $this->splitTargetTime($request['targetTime']);
        }
        return $request;
    }

    /**
     * Reads all active Requests which are not of the given User,
     * or the given User is blocked by the owner
     * 
     * @param  [uuid] $userId [user which wants the requests]
     * @return [array]         [requests]
     */
    public function getAllActive($userId){
        $result = $this->db->select("esc_request", "*", [
            "aborted" => 0,
            "#expires[>]" => "NOW()",
            "user_id[!]" => $userId
          ]);
        return $result;
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
        $request['genderM'] = $http['genderM'] == "true" ? 1 : 0;
        $request['genderF'] = $http['genderF'] == "true" ? 1 : 0;
        $request['genderT'] = $http['genderT'] == "true" ? 1 : 0;
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
        $date = DateTimeFormater::formatDate($date);
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

    public function abort($reqId, $userId){
        $this->db->update("esc_request", [
            "aborted" => 1
          ], [
            "id" => $reqId,
            "user_id" => $userId
          ]);
    }
}


?>