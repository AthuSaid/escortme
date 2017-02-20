<div class="esc-active-ct">
  <div>Aktiv</div>
  <div>
    <label class="switch">
      <input type="checkbox">
      <div class="slider round" onclick="Listening.toggle();"></div>
    </label>
  </div>
</div>

<div class="esc-jumbot">
  <label>Anfragen</label>
</div>

<div class="esc-list-ct">
  <div class="esc-list-item" data-msg-id="1" onclick="Listening.openRequest(1);">
    <div>
      <div class="esc-list-item-content">
        <div class="esc-list-item-avatar">
          <img src="data/avatar-1.png" />
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
            <img src="data/avatar-1.png" />
          </div>
          <div>
            <div class="esc-list-item-title">Jörg, 39</div>
            <div class="esc-list-item-text">Heute, 23:00</div>
          </div>
        </div>
      </div>
  </div>

  <div class="esc-list-item" data-msg-id="3" onclick="Listening.openRequest(3);">
      <div>
        <div class="esc-list-item-content">
          <div class="esc-list-item-avatar">
            <img src="data/avatar-1.png" />
          </div>
          <div>
            <div class="esc-list-item-title">Richard, 80</div>
            <div class="esc-list-item-text">Heute, 18:30</div>
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
    active: false,
    toggle: function(){
      this.active = !this.active;
    },
    openRequest: function(usrId){
      window.location.hash = "#request?id=" + usrId;
    }
  };

</script>