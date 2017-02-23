<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();

$checked = "";
if($user['listening']){
  $checked = "checked";
}

?>

<div>
<div class="esc-active-ct">
  <div>Aktiv</div>
  <div>
    <label class="switch">
      <input type="checkbox" class="esc-input-active" onchange="Listening.toggle();" <?php echo $checked; ?>>
      <div class="slider round"></div>
    </label>
  </div>
</div>

<div class="esc-filter-ct">
  <div class="esc-active-description">
    Wenn du aktiv bist, dann erhälst du Benachrichtigungen,
    sobald jemand eine Anfrage stellt und du mit deinen
    Kriterien darauf gematched wirst.
  </div>

  <div>
    <label>Beschreibe was du bietest:</label>
    <textarea rows="3" class="w3-input esc-input-curriculum"></textarea>
  </div>

  <div class="esc-min-preis">
    <label>Min. Preis:</label>
    <input type="number" class="w3-input esc-input-minprice" />
  </div>

  <div class="esc-interesst-ct">
    <label>Interessiert an:</label>
    <div>
      <div>
        <div>
          <input type="checkbox" class="esc-input-genderm" />
          <label>Männer</label>
        </div>
        <div>
          <input type="checkbox" class="esc-input-genderf" />
          <label>Frauen</label>
        </div>
        <div>
          <input type="checkbox" class="esc-input-gendert" />
          <label>Transexuellen</label>
        </div>
      </div>
      <div>
        <div>
          <input type="radio" name="esc-input-level" value="A" class="esc-input-level-a" checked />
          <label>Alle</label>
        </div>
        <div>
          <input type="radio" name="esc-input-level" value="P" class="esc-input-level-p" />
          <label>Nur mit Profilbild</label>
        </div>
        <div>
          <input type="radio" name="esc-input-level" value="V" class="esc-input-level-v" />
          <label>Nur verifizerite User</label>
        </div>
      </div>
    </div>
  </div>

  <div>
    <label>Keywords:</label>
    <textarea class="w3-input esc-input-keywords"></textarea>
  </div>

</div>



<div class="esc-requests-ct">

  <div class="esc-jumbot">
    <label>Anfragen</label>
  </div>

  <div class="esc-list-ct">
    <div class="esc-list-item" data-msg-id="1" onclick="Listening.openRequest(1);">
      <div>
        <div class="esc-list-item-content">
          <div class="esc-list-item-avatar">
            <img src="data/profil-3.jpg" />
          </div>
          <div>
            <div class="esc-list-item-title">Daniel, 36</div>
            <div class="esc-list-item-text">Heute, 20:00</div>
          </div>
        </div>
      </div>
    </div>

    <div class="esc-list-item" data-msg-id="2" onclick="Listening.openRequest(2);">
        <div>
          <div class="esc-list-item-content">
            <div class="esc-list-item-avatar">
              <img src="data/profil-1.jpg" />
            </div>
            <div>
              <div class="esc-list-item-title">Jörg, 39</div>
              <div class="esc-list-item-text">Heute, 23:00</div>
            </div>
          </div>

          <div class="esc-waitforchat">
            Warten auf Chattanfrage
          </div>
        </div>
    </div>

    <div class="esc-list-item" data-msg-id="3" onclick="Listening.openRequest(3);">
        <div>
          <div class="esc-list-item-content">
            <div class="esc-list-item-avatar">
              <img src="data/profil-4.jpg" />
            </div>
            <div>
              <div class="esc-list-item-title">Richard, 80</div>
              <div class="esc-list-item-text">Heute, 18:30</div>
            </div>
          </div>
        </div>
    </div>
  </div>

</div>
</div>

<style type="text/css">

  .esc-active-ct{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0.5cm;
    font-family: Roboto-Regular;
    font-size: 20px;
    line-height: 1;
  }

  .esc-filter-ct{
    padding: 0px 0.5cm;
  }

  .esc-filter-ct > div {
    margin-bottom: 30px;
  }

  .esc-filter-ct > div:last-of-type{
    margin-bottom: 10px;
  }

  .esc-filter-ct > div label {
    font-size: 12px;
    line-height: 1;
  }

  .esc-active-description{
    font-size: 12px;
    font-family: Lora;
    line-height: 1.2;
    margin-top: -5px;
  }
  .esc-min-preis{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
  }
  .esc-min-preis label{
    width: 3cm;
  }
  .esc-interesst-ct > div{
    display: flex;
    flex-direction: row;
    margin-left: 5px;
  }
  .esc-interesst-ct > div > div{
    width: 100%;
    font-size: 12px;
    vertical-align: middle;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .esc-interesst-ct > div > div > div{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
    margin-top: 5px;
  }
  .esc-interesst-ct > div > div > div input{
    height: 20px;
    width: 20px;
    margin-right: 3px;
  }


  .esc-jumbot{
    text-align: center;
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

  .esc-waitforchat{
    background-color: #4caf50;
    color: #ECF0F1;
    max-width: 2cm;
    font-size: 10px;
    text-align: center;
    padding: 2px 5px;
    border-radius: 3px;
  }

  /* TOGGLE */
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  /* Hide default HTML checkbox */
  .switch input {display:none;}

  /* The slider */
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked + .slider {
    background-color: #2196F3;
  }

  input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }
</style>

<script type="text/javascript">
  Topbar.show();
  Topbar.setText("Lauschen");

  Listening = {
    init: function(){
      if(this.active())
        $(".esc-filter-ct").hide();
      else
        $(".esc-requests-ct").hide();
    },
    active: function(){
      return $(".esc-input-active:checked").length > 0;
    },
    toggle: function(){
      if(this.active())
        this.enable();
      else
        this.disable();
    },
    enable: function(){
      $(".esc-requests-ct").show();
      $(".esc-filter-ct").hide();

      var curriculum = $(".esc-input-curriculum").val();
      var price = $(".esc-input-minprice").val();
      var level = $("input[name=esc-input-level]:checked").val();
      var genderm = $(".esc-input-genderm").is(":checked");
      var genderf = $(".esc-input-genderf").is(":checked");
      var gendert = $(".esc-input-gendert").is(":checked");
      $.post("ws/listening.php", {
        listening: 1,
        curriculum: curriculum,
        minPrice: price,
        level: level,
        genderM: genderm,
        genderF: genderf,
        genderT: gendert
      });
    },
    disable: function(){
      $(".esc-requests-ct").hide();
      $(".esc-filter-ct").show();

      $.post("ws/listening.php", {listening: 0});
    },
    openRequest: function(usrId){
      window.location.hash = "#request?id=" + usrId;
    }
  };
  Listening.init();

</script>