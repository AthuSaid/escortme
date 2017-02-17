<div class="esc-container esc-tab-ct">
  <div class="esc-tab w3-center esc-tab-selected">
    Profil
  </div>
  <div class="esc-tab w3-center">
    Galerie
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

<div class="esc-picture-add-button esc-green">
  +
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
  }
  .esc-tab-selected{
    background-color: #2980B9;
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


  $(".esc-picture img").bind("taphold", function(event){
    ContextMenu.selected = event.target;
    ContextMenu.open();
  });

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
  }
</script>