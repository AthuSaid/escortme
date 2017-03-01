<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.messages');
$db = DatabaseConnection::get();

$chatService = new ChatService($logger, $db);

$chatId = $_REQUEST['id'];

$profile = $chatService->getChatPartner($chatId, $user['id']);
$msgs = $chatService->getMessages($chatId, $user['id']);

?>

<div class="esc-msg-ct">

  <?php
  foreach ($msgs as $msg) {
    if($msg['isSender']){
      $msgClass = "esc-msg-right";
      $picture = $user['picture'];
      $onClick = "";
    }
    else{
      $msgClass = "esc-msg-left";
      $picture = $profile['picture'];
      $onClick = " onClick=\"ChatManager.openProfile('".$profile['id']."');\"";
    }
  ?>
  <div class="<?php echo $msgClass; ?>">
    <div class="esc-msg">
      <div class="esc-msg-avatar" <?php echo $onClick; ?>>
        <img src="https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=<?php echo $picture; ?>" />
      </div>
      <div class="esc-msg-content">
        <?php echo $msg['content']; ?>
      </div>
    </div>
  </div>
  <?php } ?>

</div>

<div class="esc-input-ct">
  <div class="esc-input-msg">
    <textarea rows="1" placeholder="Schreibe etwas ..."></textarea>
  </div>
  <div class="esc-input-send">
    <div class="esc-input-send-btn">
      <img src="img/send.png" onclick="ChatManager.sendMsg();" />
    </div>
  </div>
</div>


<style type="text/css">
  .esc-input-ct{
    position: fixed;
    bottom: 0px;
    left: 0px;
    right: 0px;
    background-color: #3498DB;
    padding: 5px 0.5cm;
    display: flex;
    align-items: center;
  }
  .esc-input-msg{
    width: 100%;
    display: flex;
  }
  .esc-input-msg textarea{
    width: 100%;
    padding-left: 5px;
    padding-right: 5px;
    border-radius: 5px;
  }
  .esc-input-send{
    margin-left: 10px;
  }
  .esc-input-send-btn{
    background-color: #2980B9;
    height: 1cm !important;
    width: 1cm !important;
    border-radius: 1cm;
    padding: 0.18cm 0.28cm;
  }
  .esc-input-send-btn:active{
    background-color: #E74C3C;
  }
  .esc-input-send-btn img{
    height: 0.5cm;
    width: 0.5cm;
  }

  .esc-msg-ct{
    padding: 10px 0.5cm 10px 0.5cm;
    margin-bottom: 1cm;
  }
  .esc-msg-ct > div{
    margin-bottom: 10px;
  }

  .esc-msg{
    max-width: 90%;
    color: #ECF0F1;
    font-family: Roboto-Light;
    font-size: 12px;
    line-height: 1.2;
    display: inline-flex;
    justify-content: space-between;
    border-radius: 10px;
    padding: 5px;
  }
  .esc-msg-left > div{
    background-color: #3498DB;
  }
  .esc-msg-right > div{
    background-color: #4caf50;
    flex-direction: row-reverse;
  }
  .esc-msg-right .esc-msg-avatar{
    margin-right: 0px;
    margin-left: 5px;
  }
  .esc-msg-right{
    display: flex;
    justify-content: flex-end;
  }
  .esc-msg-avatar{
    margin-right: 5px;
    min-height: 0.8cm;
  }
  .esc-msg-avatar img{
    height: 0.8cm;
    width: 0.8cm;
    border-radius: 0.5cm;
  }
  .esc-msg-content{
    padding-left: 3px;
    padding-right: 3px;
  }
</style>

<script type="text/javascript">
  Topbar.show();
  Topbar.setText("<?php echo $profile['firstName']; ?>");

  var myPicture = "<?php echo $user['picture']; ?>";

  window.ChatManager = {
    openProfile: function(profileId) {
      window.location.hash = "#profile?userid=" + profileId;
    },
    sendMsg: function(){
      var chatId = Navigation.getUrlParams()["id"];
      var content = $(".esc-input-msg textarea").val();
      if(content.length == 0)
        return;

      //Send
      var data = {
        chat_id: chatId,
        msg: content
      };
      Ajax.background("ws/chat-msg-create.php", data);

      //Insert Msg into msg-ct
      $(".esc-input-msg textarea").val("");
      var node = "<div class='esc-msg-right'>\
                    <div class='esc-msg'>\
                      <div class='esc-msg-avatar'>\
                        <img src='https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=" + myPicture + "' />\
                      </div>\
                      <div class='esc-msg-content'>" + content + "</div>\
                    </div>\
                  </div>";
      $(".esc-msg-ct").append(node);
    },
    receivedMsg: function(msg){
      var node = "<div class='esc-msg-left'>\
                  <div class='esc-msg'>\
                    <div class='esc-msg-avatar' onClick='ChatManager.openProfile(\'" + msg.data.sender.user_id + "\');'>\
                      <img src='https://andreasfend.at/escortme/webapp/ws/picture.php?type=thumbnail&picture_id=" + msg.data.sender.picture + "' />\
                    </div>\
                    <div class='esc-msg-content'>" + 
                      msg.data.content +
                    "</div>\
                  </div>\
                </div>";
      $(".esc-msg-ct").append(node);
    }
  };

</script>