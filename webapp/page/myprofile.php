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
        <div class="esc-button esc-green" onclick="">Profil verifizieren</div>
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
      <img src="ws/picture.php?type=thumbnail&picture_id=<?php echo $picture_id; ?>" />
    </div>
    <?php } ?>

  </div>

  <label class="esc-input-picture-ct">
    <input type="file" class="esc-input-picture" />
    <div class="esc-picture-add-button esc-green">+</div>
  </label>
</div>


<!-- Modal -->
<div class="w3-modal esc-ctx-menu" onclick="ContextMenu.close();">
  <div class="w3-modal-content w3-animate-top">
    <div class="esc-button" onclick="ContextMenu.profile();">Als Profilbild festlegen</div>
    <div class="esc-button esc-red" onclick="ContextMenu.delete();">Löschen</div>
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

  .esc-ctx-menu{
    padding-top: 2cm;
  }
  .esc-ctx-menu > div{
    padding: 5px;
    border-radius: 5px;
  }
</style>

<script type="text/javascript">
	Topbar.show();
  Topbar.setText("Mein Profil");
  $(".esc-galerie-ct").hide();

  $(".esc-picture img").bind("taphold", function(event){
    ContextMenu.selected = event.target;
    ContextMenu.open();
  });

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
      $(".esc-ctx-menu").css("display",'block');
    },
    close: function(){
      $(".esc-ctx-menu").css("display",'none');
    },
    profile: function(){
      this.close();
    },
    delete: function(){
      $(this.selected).remove();
      this.close();
    }
  };

  Gallery = {
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
                    <img src='ws/picture.php?type=thumbnail&picture_id=" + picId + "' />\
                  </div>";
      $(".esc-picture-ct").append(node);
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

</script>