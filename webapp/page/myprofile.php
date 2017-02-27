<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.myprofile');
$db = DatabaseConnection::get();

$pictureService = new PictureService($logger, $db);

$pics = $pictureService->getGallery($user['id']);

$genderM = $user['gender'] == "M" ? "selected" : "";
$genderF = $user['gender'] == "F" ? "selected" : "";
$genderT = $user['gender'] == "T" ? "selected" : "";


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
    <input type="text" class="w3-input esc-input-name" placeholder="Name" value="<?php echo $user['firstName']; ?>" />

    <select class="w3-select esc-input-gender">
      <option value="M" <?php echo $genderM; ?> >Männlich</option>
      <option value="F" <?php echo $genderF; ?> >Weiblich</option>
      <option value="T" <?php echo $genderT; ?> >Transexuel</option>
    </select>

    <input type="date" class="w3-input esc-input-dob" placeholder="Geburtstag" value="<?php echo $user['dob']; ?>" />

    <div class="esc-button" onclick="updateUser();">Speichern</div>

    <?php if(!$user['verified']){ ?>
      <div class="esc-verify-ct">
        <div class="esc-button esc-green" onclick="verify();">Profil verifizieren</div>
        <label>
          Wenn Sie Ihr Profil verifizieren erhöhen Sie Ihre Chancen,
          dass andere mit Ihnen Kontakt aufnehmen möchten!
        </label>
      </div>
    <?php } ?>
  </div>
  <div class="esc-next-bon">
    Nächster Bon: <label>3 Tage, 2:41:09</label>
  </div>
</div>

<div class="esc-galerie-ct">
  <div class="esc-picture-ct">
    
    <?php
      foreach($pics as $picture_id){
    ?>
    <div class="esc-picture" data-pic-id="<?php echo $picture_id; ?>">
      <img src="ws/picture.php?type=thumbnail&picture_id=<?php echo $picture_id; ?>" onclick="Gallery.open('<?php echo $picture_id; ?>');" />
    </div>
    <?php } ?>

  </div>

  <label class="esc-input-picture-ct">
    <input type="file" class="esc-input-picture" accept="image/*" />
    <div class="esc-picture-add-button esc-green">+</div>
  </label>
</div>

<div class="esc-fullscreen">
  <div class="esc-fullscreen-topbar">
    <div class="esc-fullscreen-topbar-delete" onclick="ContextMenu.open();"><img src="img/remove.png" /></div>
    <div class="esc-fullscreen-topbar-close" onclick="Gallery.close();"><img src="img/delete-white.png" /></div>
  </div>
  <div class="esc-fullscreen-image">
    <div class="esc-fullscreen-image-counter">0/0</div>
    <img src="ws/picture.php?type=thumbnail&picture_id=e7e5188b-f907-11e6-b0df-d3f657d113e9" />
    <a class="esc-fullscreen-image-prev esc-fullscreen-image-arrow" onclick="Gallery.slide(-1);">←</a>
    <a class="esc-fullscreen-image-next esc-fullscreen-image-arrow" onclick="Gallery.slide(1);">→</a>
  </div>
  <div class="esc-button esc-button-profilepic" onclick="Gallery.setProfilePicture();">Als Profilbild festlegen</div>
</div>

<!-- Modal -->
<div class="w3-modal" onclick="ContextMenu.promptNo();">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-modal-content-header">
      Sind Sie sicher, dass Sie das ausgewählte Bild löschen möchten?
    </div>
    <div>
      <div class="esc-button" onclick="ContextMenu.promptNo();">Abbrechen</div>
      <div class="esc-button esc-red" onclick="ContextMenu.promptYes();">Ja</div>
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

  .esc-verify-ct{
    margin-top: 30px;
  }
  .esc-verify-ct label{
    font-family: Lora;
    font-size: 12px;
    line-height: 1;
  }

  .esc-next-bon{
    font-size: 12px;
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

  .esc-input-picture-ct{
    right: 0.5cm;
    bottom: 0.5cm;
    position: fixed;
    display: inline-block;
  }
  .esc-input-picture-ct input{
    display: none;
  }
  .esc-picture-add-button{
    color: #ECF0F1;
    font-family: Roboto-Medium;
    font-size: 0.8cm;
    height: 1.5cm;
    width: 1.5cm;
    border-radius: 1cm;
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
  
  .w3-modal{
    padding-top: 2cm;
    z-index: 30;
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
  Topbar.setText("Mein Profil");
  $(".esc-galerie-ct").hide();

  Tabs = {
    galerie: function(){
      $(".esc-profile-ct").hide();
      $(".esc-galerie-ct").show();
      $(".esc-tab-galerie").addClass("esc-tab-selected");
      $(".esc-tab-profile").removeClass("esc-tab-selected");

    },
    profile: function(){
      $(".esc-profile-ct").show();
      $(".esc-galerie-ct").hide();
      $(".esc-tab-galerie").removeClass("esc-tab-selected");
      $(".esc-tab-profile").addClass("esc-tab-selected");
    }
  };

  TimerTask = {
    rest: 266410, //Resttime in seconds
    init: function(){
      window.Timer.handler =function(){
        TimerTask.run();
      };
      var time = this.format();
      var text = time.h + ":" + time.m + ":" + time.s;
      if(time.d !== undefined){
        var strUnity = " Tage, ";
        if(time.d == 1)
          strUnity = " Tag, ";
        text = time.d + strUnity + text;
      }
      $(".esc-next-bon label").text(text);
    },
    run: function(){
      this.rest--;
      if(this.rest < 0){
        this.clear();
        return;
      }
      var time = this.format();
      var text = time.h + ":" + time.m + ":" + time.s;
      if(time.d !== undefined){
        var strUnity = " Tage, ";
        if(time.d == 1)
          strUnity = " Tag, ";
        text = time.d + strUnity + text;
      }
      $(".esc-next-bon label").text(text);
    },
    format(){
      var days = parseInt(this.rest / 86400);
      var remaining = this.rest % 86400;
      var hours = parseInt(remaining / 3600);
      remaining = this.rest % 3600;
      var minutes = parseInt(remaining / 60);
      minutes = minutes < 10 ? "0" + minutes : minutes;
      remaining = remaining % 60;
      var seconds = remaining < 10 ? "0" + remaining : remaining;
      var result = { h: hours, m: minutes, s: seconds };
      if(days > 0)
        result.d = days;
      return result;
    },
    clear: function(){
      Timer.unset();
      $(".esc-next-bon").hide();;
    }
  };
  TimerTask.init();

  ContextMenu = {
    selected: null,
    open: function(){
      $(".w3-modal").css("display",'block');
    },
    close: function(){
      $(".w3-modal").css("display",'none');
    },
    promptNo: function(){
      this.close();
    },
    promptYes: function(){
      Snackbar.show("Noch nicht verfügbar ...");
      this.close();
    }
  };

  Gallery = {
    currIndex: null,
    init: function(){
      $(".esc-input-picture").on('change', function(){
        var file_data = $('.esc-input-picture').prop('files')[0];

        if(file_data == null)
          return;
        var form_data = new FormData();
        form_data.append('picture', file_data);

        Ajax.pictureUpload(form_data, function(response){
          if(response.success == 1){
            Gallery.add(response.picture);
            Sidebar.refreshProfile();
          }
          else{
            Snackbar.show(response.msg);
          }
        });

      });
    },
    add: function(picId){
      var node = "<div class='esc-picture' data-pic-id='" + picId + "'>\
                    <img src='ws/picture.php?type=thumbnail&picture_id=" + picId + "' onclick=\"Gallery.open('" + picId + "');\" />\
                  </div>";
      $(".esc-picture-ct").append(node);
    },
    open: function(picId){
      $(".esc-fullscreen").show();
      $(".esc-fullscreen-image img").attr("src", "ws/picture.php?type=full&picture_id=" + picId);
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
      $(".esc-fullscreen-image img").attr("src", "ws/picture.php?type=full&picture_id=" + picId);
      $(".esc-fullscreen-image-counter").text(this.currIndex + "/" + total);
    },
    setProfilePicture: function(){
      var picId = $(".esc-picture-ct .esc-picture:nth-child(" + this.currIndex + ")").attr("data-pic-id");
      var data = {
        picture_id: picId
      };
      Ajax.background("ws/profilpicture.php", data, function(response){
        Sidebar.refreshProfile();
      });
      Snackbar.show("Änderung wird durchgeführt ...");
    }
  };
  Gallery.init();


  function updateUser(){
    var name = $(".esc-input-name").val();
    var gender = $(".esc-input-gender").val();
    var dob = $(".esc-input-dob").val();

    var data = {
      firstName: name,
      gender: gender,
      dob: dob
    };

    Ajax.post("ws/profil-update.php", data, function(){
      Snackbar.show("Änderungen gespeichert");
    });

  }

  function verify(){
    Snackbar.show("Noch nicht verfügbar ...");
  }

</script>