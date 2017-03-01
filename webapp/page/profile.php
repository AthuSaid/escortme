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
        <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $profile['picture'] ?>" />
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
    <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $picture_id; ?>" onclick="Gallery.open('<?php echo $picture_id; ?>');" />
  </div>
  <?php } ?>

</div>


<div class="esc-fullscreen">
  <div class="esc-fullscreen-topbar">
    <div> </div>
    <div class="esc-fullscreen-topbar-close" onclick="Gallery.close();"><img src="img/delete-white.png" /></div>
  </div>
  <div class="esc-fullscreen-image">
    <div class="esc-fullscreen-image-counter">0/0</div>
    <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=e7e5188b-f907-11e6-b0df-d3f657d113e9" />
    <a class="esc-fullscreen-image-prev esc-fullscreen-image-arrow" onclick="Gallery.slide(-1);">←</a>
    <a class="esc-fullscreen-image-next esc-fullscreen-image-arrow" onclick="Gallery.slide(1);">→</a>
  </div>
</div>


<!-- Modal -->
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

  .esc-fullscreen{
    position: fixed;
    bottom: 0px;
    right: 0px;
    left: 0px;
    top: 1.5cm;
    background-color: #47525e;
    display: none;
    z-index: 20;
  }
  .esc-fullscreen-topbar{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 10px 10px;
  }
  .esc-fullscreen-topbar img{
    height: 0.8cm;
    width: 0.8cm;
  }
  .esc-fullscreen-image-counter{
    color: #ECF0F1;
    position: absolute;
    font-size: 12px;
    padding-left: 3px;
  }
  .esc-fullscreen-image img{
    width: 100%;
    max-width: 800px;
    height: 100%;
    max-height: 100%;
  }
  .esc-fullscreen-image-arrow{
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    padding: 16px;
    margin-top: -50px;
    color: #ECF0F1;
    font-size: 20px;
  }
  .esc-fullscreen-image-prev{
    left: 10px;
  }
  .esc-fullscreen-image-next{
    right: 10px;
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
      Ajax.get("ws/offer-accept.php", data, function(response){
        window.location.hash = "#chat?id=" + response.id;
      });
    }
  };

  Gallery = {
    currIndex: null,
    open: function(picId){
      $(".esc-fullscreen").show();
      $(".esc-fullscreen-image img").attr("src", "https://andreasfend.at/escortme/webapp/ws/picture.php?type=full&picture_id=" + picId);
      var total = $(".esc-picture-ct .esc-picture").length;
      var index = 1;
      for(var i=1;i<=total;i++){
        if($(".esc-picture-ct .esc-picture:nth-child(" + i + ")").attr("data-pic-id") == picId){
          index = i;
        }
      }
      $(".esc-fullscreen-image-counter").text(index + "/" + total);
      this.currIndex = index;
    },
    close: function(){
      $(".esc-fullscreen").hide();
    },
    slide: function(direction){
      this.currIndex += direction;
      var total = $(".esc-picture-ct .esc-picture").length;
      if(this.currIndex == 0)
        this.currIndex = total;
      if(this.currIndex > total)
        this.currIndex = 1;

      var picId = $(".esc-picture-ct .esc-picture:nth-child(" + this.currIndex + ")").attr("data-pic-id");
      $(".esc-fullscreen-image img").attr("src", "https://andreasfend.at/escortme/webapp/ws/picture.php?type=full&picture_id=" + picId);
      $(".esc-fullscreen-image-counter").text(this.currIndex + "/" + total);
    }
  };

</script>