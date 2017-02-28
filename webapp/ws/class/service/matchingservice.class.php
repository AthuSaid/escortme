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

    /**
     * Will be called, after a request was created to see
     * which services of an active user will match on it
     * @param  [object] $request [the new created request]
     * @return [type]          [description]
     */
	public function matchServices($req){
		$services = $this->db->query("SELECT * FROM esc_service s INNER JOIN esc_user u ON s.user_id=u.id WHERE s.created=
            (SELECT MAX(ss.created) FROM esc_service ss WHERE ss.user_id=s.user_id) AND u.listening=1 AND s.user_id!='".$req['user_id']."'")->fetchAll();
        
        $userService = new UserService($this->logger, $this->db);
        $owner = $userService->getProfile($req['user_id']);

        //Sort by price and load Profile and extend request by targetTime
        $priceOk = array();
        foreach ($services as $svc) {
            if($svc['minPrice'] <= $req['maxPrice'] ||
                $svc['minPrice'] == 0 ||
                $req['maxPrice'] == 0){
                $svc['user'] = $userService->getProfile($svc['user_id']);
                $priceOk[] = $svc;
            }
        }

        //Check age, svcGender, svcLevel
        $targetOk = array();
        foreach ($priceOk as $svc) {
            
            //Age
            if($svc['user']['age'] >= $req['ageFrom'] &&
                $svc['user']['age'] <= $req['ageTo']){

                //SvcGender
                if($req['genderM'] && $svc['user']['gender'] == "M" ||
                    $req['genderF'] && $svc['user']['gender'] == "F" ||
                    $req['genderT'] && $svc['user']['gender'] == "T"){

                    //SvcLevel
                    if($req['level'] == "A" ||
                        $req['level'] == "P" && $svc['user']['picture'] ||
                        $req['level'] == "V" && $svc['user']['verified']){

                        $targetOk[] = $svc;
                    }
                }
            }
        }

        //Check selfGender, selfLevel
        $result = array();
        foreach ($targetOk as $svc) {
            
            //SelfGender
            if($svc['genderM'] && $owner['gender'] == "M" ||
                $svc['genderF'] && $owner['gender'] == "F" ||
                $svc['genderT'] && $owner['gender'] == "T"){

                //SelfLevel
                if($svc['level'] == "A" ||
                    $svc['level'] == "P" && $owner['picture'] ||
                    $svc['level'] == "V" && $owner['verified']){

                    $result[] = $svc;
                }
            }
        }

        return $result;

	}

	public function matchRequests($service){
		//Get All Active Requests
        $reqService = new RequestService($this->logger, $this->db);
        $requests = $reqService->getAllActive($service['user_id']);

        //Sort by price and load Profile and extend request by targetTime
        $userService = new UserService($this->logger, $this->db);
        $priceOk = array();
        foreach ($requests as $req) {
            if($service['minPrice'] <= $req['maxPrice'] ||
                $service['minPrice'] == 0 ||
                $req['maxPrice'] == 0){
                $req['user'] = $userService->getProfile($req['user_id']);
                $req['restTime'] = $reqService->calcRestTime($req['expires']);
                $req['targetTime'] = $reqService->splitTargetTime($req['targetTime']);
                $priceOk[] = $req;
            }
        }

        //Check Age, selfGender, selfLevel
        $owner = $userService->getProfile($service['user_id']);
        $selfOk = array();
        foreach ($priceOk as $req){

            //Age
            if($req['ageFrom'] <= $owner['age'] &&
                $req['ageTo'] >= $owner['age']){
                
                //Gender
                if($req['genderM'] && $owner['gender'] == "M" ||
                    $req['genderF'] && $owner['gender'] == "F" ||
                    $req['genderT'] && $owner['gender'] == "T"){
                
                    //LevelSelf
                    if($req['level'] == "A" ||
                        ($req['level'] == "P" && $owner['picture']) ||
                        ($req['level'] == "V" && $owner['verified'])){

                        //Passed the self-checks
                        $selfOk[] = $req;
                    }
                }

            }
        }

        //Check targetGender, targetLevel
        $result = array();
        foreach ($selfOk as $req) {
            //Gender
            if($service['genderM'] && $req['user']['gender'] == "M" ||
                $service['genderF'] && $req['user']['gender'] == "F" ||
                $service['genderT'] && $req['user']['gender'] == "T"){
                
                //Level
                if($service['level'] == "A" ||
                    ($service['level'] == "P" && $req['user']['picture']) ||
                    ($service['level'] == "V" && $req['user']['verified'])){

                    //Passed the target-checks
                    $result[] = $req;
                }
            }
        }

        return $result;

	}

}

?>