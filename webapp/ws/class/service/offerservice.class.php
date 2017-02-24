<?php


/**
* 
*/
class OfferService {
	
    private $logger;
    private $db;

    function __construct($logger, $db) {
        $this->logger = $logger;
        $this->db = $db;
    }

    public function create($reqId, $userId){
        //TODO: Check permissions
        $offerId = Uuid::next();
        $this->db->insert("esc_offer", [
            "id" => $offerId,
            "user_id" => $userId,
            "req_id" => $reqId
          ]);
        return $offerId;
    }

    /**
     * Looks if there is already an offer to this request
     * by this user.
     * @param  [uuid] $reqId  [the request where an offer could be]
     * @param  [uuid] $userId [the user which wants to make an offer]
     * @return [boolean]         [0 if not exists, otherwise 1]
     */
    public function exists($reqId, $userId){
        $result = $this->db->select("esc_offer", "*", [
            "req_id" => $reqId,
            "user_id" => $userId
          ]);

        return count($result) > 0 ? 1 : 0;
    }

    /**
     * Returns a List of the Profiles of the user
     * which made an offer to the given request
     * @param  [uuid] $reqId [Request]
     * @return [array]        [List of Profiles]
     */
    public function getOffers($reqId){
        $result = $this->db->select("esc_offer", "user_id", [
            "req_id" => $reqId,
            "accepted" => 0,
            "rejected" => 0
          ]);

        $userService = new UserService($this->logger, $this->db);
        $offers = array();
        foreach ($result as $usrId) {
            $profile = $userService->getProfile($usrId);
            $offers[] = $profile;
        }

        return $offers;
    }

    public function accept($reqId, $userId){
        $this->db->update("esc_offer", [
            "accepted" => 1
          ], [
            "req_id" => $reqId,
            "user_id" => $userId
          ]);
    }

    public function reject($reqId, $userId){
        $this->db->update("esc_offer", [
            "rejected" => 1
          ], [
            "req_id" => $reqId,
            "user_id" => $userId
          ]);
    }
}