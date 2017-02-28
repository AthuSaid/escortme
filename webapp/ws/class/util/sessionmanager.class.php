<?php

/**
* 
*/
class SessionManager{
	
  public static function sendLoginScript(){
    echo "<script type='text/javascript'>
              window.location.hash = '#login';
          </script>";
    die();
  }

	public static function user(){

    if(!isset($_SESSION['esc-user-id'])){
      SessionManager::sendLoginScript();
      return null;
    }

    $db = DatabaseConnection::get();
    $id = $_SESSION['esc-user-id'];
    $usr = $db->get("esc_user", 
      ["email", "firstName", "lastName", "dob", "gender", "listening"],
      ["id" => $id]);
    $usr["id"] = $id;

    //Verified
    $usr["verified"] = false;
    $verified = $db->get("esc_user_verification", "user_id", ["user_id" => $id]);
    if($verified)
      $usr["verified"] = true;

    //Profil-Picture
    $usr["picture"] = null;
    $picture = $db->get("esc_profil_picture", "picture_id", ["user_id" => $id]);
    if($picture)
      $usr["picture"] = $picture;


		return $usr;
	}

  public static function login($usrId){
    $_SESSION['esc-user-id'] = $usrId;
  }

  public static function isLoggedIn(){
    return isset($_SESSION['esc-user-id']);
  }

  public static function logout(){
    unset($_SESSION['esc-user-id']);
  }

}

?>