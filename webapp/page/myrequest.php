<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.myrequest');
$db = DatabaseConnection::get();

$userService = new UserService($logger, $db);
$requestService = new RequestService($logger, $db);


$user = $userService->getProfile($user['id']);
$user['verifiedText'] = $user['verified'] ? "Verifiziert" : "";
$req = $requestService->getActiveRequest($user['id']);

?>

<div class="esc-req-container">
  <div class="esc-request-duration-ct">
    <label class="esc-request-duration">Läuft noch: 1:36:51</label>
  </div>

  <div class="esc-profile-ct">
    <div>
      <div class="esc-profile-header">
        <div class="esc-profile-header-avatar">
          <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $user['picture'] ?>" />
        </div>
        <div class="esc-profile-header-info">
          <div>
            <label class="esc-profile-name"><?php echo $user['firstName']; ?></label>
            <label class="esc-profile-age"><?php echo $user['age']; ?> Jahre</label>
            <label class="esc-profile-gender"><?php echo $user['genderText']; ?></label>
          </div>
          <div>
            <label class="esc-profile-verified"><?php echo $user['verifiedText']; ?></label>
          </div>
        </div>
      </div>

      <div class="esc-request-details">
        <label class="esc-request-day"><?php echo $req['targetTime']['date']; ?></label>
        <label class="esc-request-time"><?php echo $req['targetTime']['time']; ?></label>
      </div>

      <div class="esc-request-text">
        <?php echo $req['description']; ?>
      </div>

    </div>

    <div class="esc-button esc-red" onclick="CtxMenu.show();">
      Anfrage abbrechen
    </div>

  </div>

</div>

<div class="w3-modal" onclick="CtxMenu.promptNo();">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-modal-content-header">
      Sind Sie sicher, dass Sie die Anfrage abbrechen möchten?
    </div>
    <div>
      <div class="esc-button" onclick="CtxMenu.promptNo();">Abbrechen</div>
      <div class="esc-button esc-red" onclick="CtxMenu.promptYes();">Ja</div>
    </div>
  </div>
</div>

<style type="text/css" style="display: none !important;">
  
  .esc-req-container{
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .esc-request-duration-ct{
    padding: 5px 0.5cm;
    background-color: #ff9800;
    font-family: Roboto-Medium;
    font-size: 14px;
  }

  .esc-profile-ct{
    padding: 10px 0.5cm;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
  }

  .esc-profile-header{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    font-family: Roboto-Regular;
  }
  .esc-profile-header-avatar img{
    width: 2cm;
    height: 2cm;
    border-radius: 1cm;
  }
  .esc-profile-header-info{
    width: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    line-height: 1.2;
    margin-left: 10px;
  }
  .esc-profile-header-info label{
    display: block;
  }
  .esc-profile-name{
    font-size: 18px;
  }
  .esc-profile-age, .esc-profile-gender{
    font-size: 12px;
  }
  .esc-profile-verified{
    color: #4caf50;
  }


  .esc-request-details{
    font-size: 12px;
    margin-top: 20px;
    margin-bottom: 10px;
    line-height: 1.2;
    font-family: Roboto-Regular;
  }
  .esc-request-details label{
    display: block;
  }
  .esc-request-day{
    font-size: 18px;
  }
  .esc-request-text {
    
    font-family: Lora;
    line-height: 1.5;
  }

  .esc-red{
    margin-top: 10px;
    font-family: Roboto-Light;
  }


  .w3-modal{
    padding-top: 2cm;
  }
  .w3-modal-content{
    padding: 5px;
    border-radius: 5px;
  }
  .w3-modal-content-header {
    margin-bottom: 15px;
    margin-left: -5px;
    margin-right: -5px;
    margin-top: -5px;
    font-family: Roboto-Regular;
    color: #ECF0F1;
    background: #2C3E50;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
  }

</style>

<script type="text/javascript">
	Topbar.show();
  Topbar.setText("Anfrage Details");

  TimerTask = {
    rest: <?php echo $req['restTime']; ?>, //Resttime in seconds
    init: function(){
      window.Timer.handler =function(){
        TimerTask.run();
      };
      var time = this.format();
      $(".esc-request-duration").text("Läuft noch: " + time.h + ":" + time.m + ":" + time.s);
    },
    run: function(){
      this.rest--;
      if(this.rest < 0){
        this.clear();
        return;
      }
      var time = this.format();
      $(".esc-request-duration").text("Läuft noch: " + time.h + ":" + time.m + ":" + time.s);
    },
    format: function(){
      var hours = parseInt(this.rest / 3600);
      var remaining = this.rest % 3600;
      var minutes = parseInt(remaining / 60);
      minutes = minutes < 10 ? "0" + minutes : minutes;
      remaining = remaining % 60;
      var seconds = remaining < 10 ? "0" + remaining : remaining;
      return { h: hours, m: minutes, s: seconds };
    },
    clear: function(){
      Timer.unset();
      $(".esc-request-duration").text("Anfrage beendet");
    }
  };

  CtxMenu = {
    show: function(){
      $(".w3-modal").css("display", "block");
    },
    promptNo: function(){
      $(".w3-modal").css("display", "none");
    },
    promptYes: function(){
      $(".w3-modal").css("display", "none");
      TimerTask.clear();
      Ajax.post("ws/request-abort.php", {
        req_id: "<?php echo $req['id']; ?>"
      }, function(respData){
        goToSearch();
      });
    }
  };

  function goToSearch(){
    window.location.hash = "#search";
  }

  TimerTask.init();

</script>