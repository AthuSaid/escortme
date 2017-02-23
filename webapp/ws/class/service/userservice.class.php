<?php

/**
* 
*/
class UserService {
	
	private $logger;
	private $db;

	function __construct($logger, $db) {
		$this->logger = $logger;
        $this->db = $db;
	}

    function getProfile($userId){
        $result = $this->db->select("esc_user", [
            "[>]esc_profil_picture(pp)" => ["id" => "user_id"],
            "[>]esc_user_verification(vf)" => ["id" => "user_id"]
          ], [
            "id",
            "email",
            "firstName",
            "lastName",
            "dob",
            "gender",
            "listening",
            "pp.picture_id(picture)",
            "vf.picture_id(verified)"
          ], [
            "id" => $userId
          ]);

        $usr = null;
        if(count($result) > 0){
            $usr = $result[0];
            $usr['verified'] = $usr['verified'] ? 1 : 0;
            if(!$usr['picture']) $usr['picture'] = 0;
            $usr['gender'] = $this->convertGender($usr['gender']);
            $usr['age'] = $this->calcAge($usr['dob']);
        }
        return $usr;
    }

    public function calcAge($dob){
        //explode the date to get month, day and year
        $dob = explode("-", $dob);
        $birthDate = $dob[1]."/".$dob[2]."/".$dob[0];
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age;
    }

    public function convertGender($char){
        switch ($char) {
            case 'M':
                return "Mann";
                break;
            case 'F':
                return "Frau";
                break;
            case 'T':
                return "Transexuell";
                break;
            default:
                return " ";
                break;
        }
    }

}

?>