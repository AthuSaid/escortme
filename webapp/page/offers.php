<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$rs = new RequestService($logger, $db);
$offerService = new OfferService($logger, $db);

$req = $rs->getActiveRequest($user['id']);
$offers = $offerService->getOffers($req['id']);

$goToSearch = "";
if($req == null){
  $goToSearch = "goToSearch();";
}

?>

<div class="esc-request-duration-ct" onclick="openMyRequest();">
  <label class="esc-request-duration">Läuft noch: 1:36:51</label>
</div>

<div class="esc-jumbot">
  <label>Angebote</label>
</div>

<div>
  <div class="esc-list-ct">

    <?php foreach ($offers as $ofr) { ?>
      <div class="esc-list-item" data-usr-id="<?php echo $ofr['id']; ?>" onclick="Offers.openProfile('<?php echo $ofr['id']; ?>');">
        <div>
          <div class="esc-list-item-content">
            <div class="esc-list-item-avatar">
              <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $ofr['picture']; ?>" />
            </div>
            <div class="esc-list-item-title"><?php echo $ofr['firstName']; ?>, <?php echo $ofr['age']; ?></div>
          </div>
          <div class="esc-list-item-delete">
            <img src="img/delete-grey.png" onclick="Offers.remove('<?php echo $ofr['id']; ?>');" />
          </div>
        </div>
      </div>
    <?php } ?>

  </div>
</div>

<div class="w3-modal" onclick="Offers.promptNo();">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-modal-content-header">
      Sind Sie sicher, dass Sie das Angebot von <span class="esc-propmt-name">Name</span>
      unwiederuflich löschen möchten?
    </div>
    <div>
      <div class="esc-button" onclick="Offers.promptNo();">Abbrechen</div>
      <div class="esc-button esc-red" onclick="Offers.promptYes();">Ja</div>
    </div>
  </div>
</div>

<style type="text/css">

  .esc-req-container{
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .esc-request-duration-ct:active{
    background-color: #e68a00;
    color: #ECF0F1;
  }

  .esc-request-duration-ct{
    padding: 5px 0.5cm;
    background-color: #ff9800;
    font-family: Roboto-Medium;
    font-size: 14px;
  }

  .esc-jumbot{
    text-align: center;
    display: none;
  }

  .esc-list-item > div{
    margin-left: 0.5cm;
    margin-right: 0.5cm;
    border-bottom: 2px solid #d8d8d8;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px;
    padding-bottom: 5px;
    font-family: Roboto-Regular;
    color: #47525e;
  }
  .esc-list-item:last-of-type > div{
    border-bottom: 0px;
  }
  .esc-list-item:active{
    background-color: #3498DB;
  }
  .esc-list-item:active > div{
    border-bottom: 0px;
    margin-bottom: 2px;
    color: #ECF0F1;
  }
  .esc-list-item-content{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    height: 1.5cm;
    overflow-y: hidden;
  }
  .esc-list-item-avatar{
    margin-right: 5px;
  }
  .esc-list-item-avatar img{
    height: 1.5cm;
    width: 1.5cm;
    border-radius: 1cm;
  }
  .esc-list-item-title{
    font-size: 18px;
  }
  .esc-list-item-text{
    font-size: 12px;
    line-height: 1.2;
  }
  .esc-list-item-delete{
    margin-left: 5px;
  }
  .esc-list-item-delete img{
    height: 0.8cm;
    width: 0.8cm;
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
  Topbar.setText("Anfragen");

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
  TimerTask.init();

  window.Offers = {
    selected: null,
    receivedOffer: function(offer){
      console.log("Offers::receivedOffer", offer)
      var node = "<div class='esc-list-item' data-usr-id='" + offer.data.sender.user_id + "' onClick='Offers.openProfile(\"" + offer.data.sender.user_id + "\");'>\
                    <div>\
                      <div class='esc-list-item-content'>\
                        <div class='esc-list-item-avatar'>\
                          <img src='https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=" + offer.data.sender.picture + "' />\
                        </div>\
                        <div class='esc-list-item-title'>" + offer.data.sender.firstName + ", " + offer.data.sender.age + "</div>\
                      </div>\
                      <div class='esc-list-item-delete'>\
                        <img src='img/delete-grey.png' onclick='Offers.remove(\"" + offer.data.sender.user_id + "\");' />\
                      </div>\
                    </div>\
                  </div>";
      $(".esc-list-ct").append(node);

    },
    remove: function(usrId){
      this.selected = usrId;
      var name = $(".esc-list-item[data-usr-id=" + usrId + "] .esc-list-item-title").text();
      $(".esc-propmt-name").text(name);
      $(".w3-modal").css("display", "block");
    },
    promptYes: function(){
      var profilId = this.selected;
      $(".esc-list-item[data-usr-id=" + this.selected + "]").remove();
      $(".w3-modal").css("display", "none");
      this.selected = null;

      var data = {
        user_id: profilId
      };
      Ajax.background("ws/offer-reject.php", data);
    },
    promptNo: function(){
      $(".w3-modal").css("display", "none");
      this.selected = null;
    },
    openProfile: function(usrId){
      if(this.selected == null)
        window.location.hash = "#profile?userid=" + usrId;
    }
  };

  function openMyRequest(){
    window.location.hash = "#myrequest";
  }

  function goToSearch(){
    window.location.hadh = "#search";
  }
  <?php echo $goToSearch; ?>

</script>