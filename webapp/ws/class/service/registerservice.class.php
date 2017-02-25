<?php


/**
* 
*/
class RegisterService {
	
    const REGISTER = 'esc_register';
    const EMAIL = 'esc_reg_email';
    const PW = 'esc_reg_pw';
    const NAME = 'esc_reg_name';
    const GENDER = 'esc_reg_gender';
    const DOB = 'esc_reg_dob';
    const CREDIT_OWNER = 'esc_reg_credit_owner';
    const CREDIT_NUMBER = 'esc_reg_credit_number';
    const CREDIT_EXPIRE_MONTH = 'esc_reg_credit_expire_month';
    const CREDIT_EXPIRE_YEAR = 'esc_reg_credit_expire_year';
    const CREDIT_SIG = 'esc_reg_credit_sig';

    private $logger;
    private $db;

    function __construct($logger, $db) {
        $this->logger = $logger;
        $this->db = $db;
    }

    public function get($var){
        if(isset($_SESSION[$var]))
            return $_SESSION[$var];
        return null;
    }

    /**
     * Saves the given data in the session.register
     * @param [array] $data [the array of $_REQUEST]
     * @return [boolean] [if all is ok]
     */
    public function setData($data){
        $store = array();
        if(isset($_SESSION[self::REGISTER]))
            $store = $_SESSION[self::REGISTER];


        if(isset($data['email'])){
            $store[self::EMAIL] = $data['email'];
        }
        if(isset($data['pw'])){
            $store[self::PW] = $data['pw'];
        }
        if(isset($data['name'])){
            $store[self::NAME] = $data['name'];
        }
        if(isset($data['gender'])){
            $store[self::GENDER] = $data['gender'];
        }
        if(isset($data['dob'])){
            $store[self::DOB] = $data['dob'];
        }

        $_SESSION[self::REGISTER] = $store;

        //TODO: Proof email, dob, pw
        
        
        return true;
    }

    /**
     * If all needed data is in the session.register
     * then it returns true else false
     * @return [boolean] [If all data is set]
     */
    public function allSet(){
        return isset($_SESSION[self::REGISTER][self::EMAIL]) &&
               isset($_SESSION[self::REGISTER][self::PW]) &&
               isset($_SESSION[self::REGISTER][self::NAME]) &&
               isset($_SESSION[self::REGISTER][self::GENDER]) &&
               isset($_SESSION[self::REGISTER][self::DOB]);
    }

    /**
     * If all needed credit data is in the session.register
     * then it returns true else false
     * @return [boolean] [If all credit data is set]
     */
    public function creditSet(){
        return isset($_SESSION[self::CREDIT_OWNER]) &&
               isset($_SESSION[self::CREDIT_NUMBER]) &&
               isset($_SESSION[self::CREDIT_EXPIRE_MONTH]) &&
               isset($_SESSION[self::CREDIT_EXPIRE_YEAR]) &&
               isset($_SESSION[self::CREDIT_SIG]);
    }

    /**
     * Saves the given data in session.register
     * in the db
     * @return [uuid] [The uuid of the saved userId]
     */
    public function register(){
        $usrId = Uuid::next();
        $nameParts = explode(" ", $_SESSION[self::REGISTER][self::NAME], 2);
        $firstName = $nameParts[0];
        $lastName = "";
        if(count($nameParts) > 1)
            $lastName = $nameParts[1];

        $usr = array(
            "id" => $usrId,
            "email" => $_SESSION[self::REGISTER][self::EMAIL],
            "firstName" => $firstName,
            "lastName" => $lastName,
            "gender" => $_SESSION[self::REGISTER][self::GENDER],
            "dob" => $_SESSION[self::REGISTER][self::DOB]
        );

        $pw = array(
            "user_id" => $usrId,
            "value" => $_SESSION[self::REGISTER][self::PW]
        );

        $this->db->insert("esc_user", $usr);
        $this->db->insert("esc_user_pw", $pw);

        return $usrId;
    }

    /**
     * Registers the credit card which should be saved in
     * session.register.credit.
     * @return [boolean] [If the Registration online was an success]
     */
    public function registerCredit($usrId){
        $this->db->insert("esc_user_credit", [
            "user_id" => $usrId,
            "owner" => $_SESSION[self::CREDIT_OWNER],
            "cardNumber" => $_SESSION[self::CREDIT_NUMBER],
            "expireMonth" => $_SESSION[self::CREDIT_EXPIRE_MONTH],
            "expireYear" => $_SESSION[self::CREDIT_EXPIRE_YEAR],
            "signaory" => $_SESSION[self::CREDIT_SIG]
          ]);

        //TODO: Proof if the card is accepted by API
        return true;
    }

    /**
     * Unsets all the session.register entrys
     * @return [void] 
     */
    public function clear(){

        unset($_SESSION[self::REGISTER]);

        /*
        unset($_SESSION['esc_reg_email']); 
        unset($_SESSION['esc_reg_pw']);
        unset($_SESSION[self::NAME]);
        unset($_SESSION[self::GENDER]);
        unset($_SESSION[self::DOB]);
        unset($_SESSION[self::CREDIT_OWNER]);
        unset($_SESSION[self::CREDIT_NUMBER]);
        unset($_SESSION[self::CREDIT_EXPIRE_MONTH]);
        unset($_SESSION[self::CREDIT_EXPIRE_YEAR]);
        unset($_SESSION[self::CREDIT_SIG]);
        */
	}
}