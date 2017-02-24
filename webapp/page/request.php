<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.myrequest');
$db = DatabaseConnection::get();

$userService = new UserService($logger, $db);
$requestService = new RequestService($logger, $db);
$offerService = new OfferService($logger, $db);

$reqId = $_REQUEST['id'];

$req = $requestService->getRequest($reqId);
$profile = $userService->getProfile($req['user_id']);
$profile['verifiedText'] = $profile['verified'] ? "Verifiziert" : "";


?>

<div class="esc-profile-ct">
  <div>
    <div class="esc-profile-header">
      <div class="esc-profile-header-avatar">
        <img src="ws/picture.php?type=thumbnail&picture_id=<?php echo $profile['picture'] ?>" />
      </div>
      <div class="esc-profile-header-info">
        <div>
          <label class="esc-profile-name"><?php echo $profile['firstName']; ?></label>
          <label class="esc-profile-age"><?php echo $profile['age']; ?> Jahre</label>
          <label class="esc-profile-gender"><?php echo $profile['gender']; ?></label>
        </div>
        <div>
          <label class="esc-profile-verified"><?php echo $profile['verifiedText']; ?></label>
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

  <?php if(!$offerService->exists($req['id'], $user['id'])){ ?>
  <div class="esc-button esc-button-offer esc-green" onclick="Offer.make('<?php echo $req['id']; ?>');">
    Angebot senden
  </div>
  <?php } ?>

</div>

<style type="text/css" style="display: none !important;">
  
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

  .esc-green{
    font-family: Roboto-Medium;
    margin-top: 10px;
  }

</style>

<script type="text/javascript">
	Topbar.show();
  Topbar.setText("<?php echo $profile['firstName']; ?>");

  Offer = {
    make: function(reqId){
      var data = {
        req_id: reqId
      };
      Ajax.post("ws/offer-create.php", data, function(response){
        $(".esc-button-offer").hide();
        Snackbar.show("Angebot gesendet");
      });
    }
  };

</script>