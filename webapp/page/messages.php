<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.messages');
$db = DatabaseConnection::get();

$chatService = new ChatService($logger, $db);

$chats = $chatService->getChats($user['id']);

?>

<div class="esc-list-ct">

  <?php
  foreach ($chats as $chat) {
    $lastMsg = "Noch keine Nachrichten";
    if($chat['lastMsg'])
      $lastMsg = $chat['lastMsg']['sender'].": ".$chat['lastMsg']['content'];
  ?>
    <div class="esc-list-item" data-cht-id="<?php echo $chat['id']; ?>" onclick="ChatList.open('<?php echo $chat['id']; ?>');">
      <div>
        <div class="esc-list-item-content">
          <div class="esc-list-item-avatar">
            <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $chat['profile']['picture']; ?>" />
          </div>
          <div>
            <div class="esc-list-item-title"><?php echo $chat['profile']['firstName']; ?>, <?php echo $chat['profile']['age']; ?></div>
            <div class="esc-list-item-text">
              <?php echo $lastMsg ?>
            </div>
          </div>
        </div>
        <div class="esc-list-item-delete">
          <img src="img/delete-grey.png" onclick="ChatList.remove('<?php echo $chat['id']; ?>');" />
        </div>
      </div>
    </div>
  <?php } ?>

</div>


<div class="w3-modal" onclick="ChatList.promptNo();">
  <div class="w3-modal-content w3-animate-top">
    <div class="w3-modal-content-header">
      Sind Sie sicher, dass Sie den Chatverlauf mit <span class="esc-propmt-name">Name</span>
      unwiederuflich löschen möchten?
    </div>
    <div>
      <div class="esc-button" onclick="ChatList.promptNo();">Abbrechen</div>
      <div class="esc-button esc-red" onclick="ChatList.promptYes();">Ja</div>
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
  Topbar.setText("Nachrichten");

  ChatList = {
    selected: null,
    add: function(chat){

    },
    remove: function(chatId){
      this.selected = chatId;
      var name = $(".esc-list-item[data-cht-id=" + chatId + "] .esc-list-item-title").text();
      $(".esc-propmt-name").text(name);
      $(".w3-modal").css("display", "block");
    },
    promptYes: function(){
      $(".esc-list-item[data-cht-id=" + this.selected + "]").remove();
      $(".w3-modal").css("display", "none");
      this.selected = null;
      
      var chtId = this.selected;
      var data = {
        chat_id: chtId
      };
      Ajax.background("ws/chat-delete.php", data);
    },
    promptNo: function(){
      $(".w3-modal").css("display", "none");
      this.selected = null;
    },
    open: function(chatId){
      if(this.selected == null)
        window.location.hash = "#chat?id=" + chatId;
    }
  };

</script>