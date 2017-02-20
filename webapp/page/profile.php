<div class="esc-container esc-tab-ct">
  <div class="esc-tab esc-tab-profile esc-tab-selected" onclick="Tabs.profile();">
    Profil
  </div>
  <div class="esc-tab esc-tab-galerie" onclick="Tabs.galerie();">
    Galerie
  </div>
</div>

<div class="esc-profile-ct">
  <div class="esc-profile-header">
    <div class="esc-profile-header-avatar">
      <img src="data/profil-3.jpg" />
    </div>
    <div class="esc-profile-header-info">
      <div>
        <label class="esc-profile-name">Lisa</label>
        <label class="esc-profile-age">25 Jahre</label>
        <label class="esc-profile-gender">Frau</label>
      </div>
      <div>
        <label class="esc-profile-verified">Verifiziert</label>
      </div>
    </div>
  </div>

  <div class="esc-curriculum">
    Mein Name ist Lisa, ich bin 31 Jahre alt und versuche hier etwas Geld
    zu verdienen neben meinem Studium. Was ich mache:<br /><br />
    * Sex: 200 €<br />
    * Blasen: 100 €</br />
    * Escort-Service: 50 € / Stunde
  </div>

  <div class="esc-button esc-green">
    Chat starten
  </div>
  <div class="esc-button esc-red">
    Ablehnen
  </div>

</div>

<div class="esc-picture-ct">
  <div class="esc-picture">
    <img src="data/profil-1.jpg" />
  </div>
  <div class="esc-picture">
    <img src="data/profil-2.jpg" />
  </div>
  <div class="esc-picture esc-picture-selected">
    <img src="data/profil-3.jpg" />
  </div>
  <div class="esc-picture">
    <img src="data/profil-4.jpg" />
  </div>
  <div class="esc-picture">
    <img src="data/profil-5.jpg" />
  </div>
  <div class="esc-picture">
    <img src="data/profil-6.jpg" />
  </div>
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
</style>

<script type="text/javascript">
	Topbar.show();
  Topbar.setText("Lisa");

  $(".esc-picture-ct").hide();

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
  }

</script>