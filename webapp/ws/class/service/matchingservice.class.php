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
	public function matchServices($request){
		//TODO: IMPLEMENT
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