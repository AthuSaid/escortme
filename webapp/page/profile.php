<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.profile');
$db = DatabaseConnection::get();

$userService = new UserService($logger, $db);
$serviceService = new ServiceService($logger, $db);
$pictureService = new PictureService($logger, $db);

$profil_id = $_REQUEST['userid'];

$profile = $userService->getProfile($profil_id);
$profile['verifiedText'] = $profile['verified'] ? "Verifiziert" : "";
$svc = $serviceService->getLatestService($profil_id);
$pics = $pictureService->getGallery($profil_id);


?>

<div class="esc-container esc-tab-ct">
  <div class="esc-tab esc-tab-profile esc-tab-selected" onclick="Tabs.profile();">
    Profil
  </div>
  <div class="esc-tab esc-tab-galerie" onclick="Tabs.galerie();">
    Galerie
  </div>
</div>

<div class="esc-profile-ct">
  <div>
    <div class="esc-profile-header">
      <div class="esc-profile-header-avatar">
        <img src="ws/picture.php?type=thumbnail&picture_id=<?php echo $profile['picture'] ?>" />
      </div>
      <div class="esc-profile-header-info">
        <div>
          <label class="esc-profile-name"><?php echo $profile['firstName'] ?></label>
          <label class="esc-profile-age"><?php echo $profile['age'] ?> Jahre</label>
          <label class="esc-profile-gender"><?php echo $profile['genderText'] ?></label>
        </div>
        <div>
          <label class="esc-profile-verified"><?php echo $profile['verifiedText'] ?></label>
        </div>
      </div>
    </div>

    <div class="esc-curriculum">
      <?php echo $svc['curriculum']; ?>
    </div>
  </div>

  <div>
    <div class="esc-button esc-green" onclick="Offer.accept();">
      Chat starten
    </div>
    <div class="esc-button esc-red" onclick="Offer.remove();">
      Ablehnen
    </div>
  </div>

</div>

<div class="esc-picture-ct">

  <?php
    foreach($pics as $picture_id){
  ?>
  <div class="esc-picture" data-pic-id="<?php echo $picture_id; ?>">
    <img src="ws/picture.php?type=thumbnail&picture_id=<?php echo $picture_id; ?>" />
  </div>
  <?php } ?>

</div>



<div class="w3-modal" onclick="Offer.promptNo();">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-modal-content-header">
      Sind Sie sicher, dass Sie das Angebot von <?php echo $profile['firstName']; ?>
      unwiederuflich löschen möchten?
    </div>
    <div>
      <div class="esc-button" onclick="Offer.promptNo();">Abbrechen</div>
      <div class="esc-button esc-red" onclick="Offer.promptYes();">Ja</div>
    </div>
  </div>
</div>

<style type="text/css" style="display: none !important;">
  .esc-tab-ct{
    width: 100%;
  }
  .esc-tab{
    height: 1cm;
    width: 50%;
    background-color: #3498DB;
    line-height: 1cm;
    color: #ECF0F1;
    font-family: Roboto-Medium;
    font-size: 18px;
    text-align: center;
  }
  .esc-tab-selected{
    background-color: #2980B9;
  }

  .esc-profile-ct{
    height: 100%;
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    padding: 10px 0.5cm;
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
    font-size: 16px;
    font-family: Roboto-Medium;
  }
  .esc-profile-age, .esc-profile-gender{
    font-size: 12px;
  }
  .esc-profile-verified{
    color: #4caf50;
  }

  .esc-curriculum{
    margin: 30px 0px;
    font-family: Lora;
    line-height: 1.5;
  }

  .esc-picture-ct{
    padding: 0.5cm;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: flex-start;
    align-content: flex-start;
  }
  .esc-picture{
    margin: 5px;
  }
  .esc-picture img{
    width: 2cm;
    height: 2cm;
  }
  .esc-picture-selected img{
    border: 2px solid #3498DB;
  }

  .esc-picture-add-button{
    color: #ECF0F1;
    font-family: Roboto-Medium;
    font-size: 0.8cm;
    height: 1.5cm;
    width: 1.5cm;
    border-radius: 1cm;
    position: absolute;
    bottom: 0.5cm;
    right: 0.5cm;
    text-align: center;
    line-height: 1.5cm;
    box-shadow: 4px 5px 10px 0px rgba(0, 0, 0, 0.2);
  }

  .esc-ctx-menu{
    padding-top: 2cm;
  }
  .esc-ctx-menu > div{
    padding: 5px;
    border-radius: 5px;
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
  Topbar.setText("<?php echo $profile['firstName']; ?>");

  $(".esc-picture-ct").hide();

  Tabs = {
    galerie: function(){
      $(".esc-profile-ct").hide();
      $(".esc-picture-ct").show();
      $(".esc-tab-galerie").addClass("esc-tab-selected");
      $(".esc-tab-profile").removeClass("esc-tab-selected");

    },
    profile: function(){
      $(".esc-profile-ct").show();
      $(".esc-picture-ct").hide();
      $(".esc-tab-galerie").removeClass("esc-tab-selected");
      $(".esc-tab-profile").addClass("esc-tab-selected");
    }
  };

  Offer = {
    id: '<?php echo $profile['id']; ?>',
    remove: function(usrId){
      $(".w3-modal").css("display", "block");
    },
    promptYes: function(){
      $(".w3-modal").css("display", "none");

      var usrId = this.id;
      var data = {
        user_id: usrId
      };
      Ajax.post("ws/offer-reject.php", data, function(response){
        window.location.hash = "#offers";
      });
    },
    promptNo: function(){
      $(".w3-modal").css("display", "none");
    },
    accept: function(){
      var usrId = this.id;
      var data = {
        user_id: usrId
      };
      Ajax.post("ws/offer-accept.php", data, function(response){
        window.location.hash = "#chat?id=" + response.id;
      });
    }
  };

</script>