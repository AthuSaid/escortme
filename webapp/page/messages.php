<div class="esc-list-item" data-msg-id="1">
	<div>
	  <div class="esc-list-item-content">
	  	<div class="esc-list-item-avatar">
	  	  <img src="data/avatar-1.png" />
	  	</div>
	  	<div>
	  	  <div class="esc-list-item-title">Birgit, 36</div>
	  	  <div class="esc-list-item-text">
	  	  	Hallo du geiler Hengst, hast du lust dass ich dich reite und schön in mir abspritzt?
	  	  </div>
	  	</div>
	  </div>
	  <div class="esc-list-item-delete">
	  	<img src="img/delete-grey.png" onclick="MessageList.remove(1);" />
	  </div>
	</div>
</div>

<div class="esc-list-item" data-msg-id="2">
    <div>
      <div class="esc-list-item-content">
        <div class="esc-list-item-avatar">
          <img src="data/avatar-1.png" />
        </div>
        <div>
          <div class="esc-list-item-title">No Name, 18</div>
          <div class="esc-list-item-text">
            Hallo du geiler Hengst, hast du lust dass ich dich reite und schön in mir abspritzt?
          </div>
        </div>
      </div>
      <div class="esc-list-item-delete">
        <img src="img/delete-grey.png" onclick="MessageList.remove(2);" />
      </div>
    </div>
</div>

<div class="esc-list-item" data-msg-id="3">
    <div>
      <div class="esc-list-item-content">
        <div class="esc-list-item-avatar">
          <img src="data/avatar-1.png" />
        </div>
        <div>
          <div class="esc-list-item-title">Marina, 25</div>
          <div class="esc-list-item-text">
            Hallo du geiler Hengst, hast du lust dass ich dich reite und schön in mir abspritzt?
          </div>
        </div>
      </div>
      <div class="esc-list-item-delete">
        <img src="img/delete-grey.png" onclick="MessageList.remove(3);" />
      </div>
    </div>
</div>


<style type="text/css">

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
  .esc-list-item-delete{
  	margin-left: 5px;
  }
  .esc-list-item-delete img{
  	height: 0.8cm;
  	width: 0.8cm;
  }
</style>

<script type="text/javascript">
  Topbar.show();
  Topbar.setText("Nachrichten");

  MessageList = {
    add: function(msg){

    },
    remove: function(msgId){
      $(".esc-list-item[data-msg-id=" + msgId + "]").remove();
    }
  };

</script>