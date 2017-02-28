window.Global = {
  window: function(){
    var result = { };
    result.height = $(window).height();
    result.width = $(window).width();
    return result;
  },
  topbar: function(){
    var result = { };
    result.height = $(".esc-topbar").height();
    result.width = $(".esc-topbar").width();
    return result;
  }
};

window.Topbar = {
  init: function(){
    window.addEventListener("orientationchange", function(){
      Topbar.setText(Topbar.getText());
    });
  },
  setText: function(txt){
    $(".esc-title").text(txt);
    $(".esc-title").css("font-size", "28px");
    var escTitleRight = $(".esc-title").width() + $(".esc-title").offset().left;
    var bellLeft = $(".esc-bell").offset().left;
    var fontSize = parseInt($(".esc-title").css("font-size"));
    while(escTitleRight >= bellLeft){
      fontSize--;
      $(".esc-title").css("font-size", fontSize + "px");
      var escTitleRight = $(".esc-title").width() + $(".esc-title").offset().left;
      var bellLeft = $(".esc-bell").offset().left;
    }
  },
  getText: function(){
    return $(".esc-title").text();
  },
  show: function(){
    $(".esc-topbar").show();
    $(".esc-page").css("top", "1.5cm");
  },
  hide: function(){
    $(".esc-topbar").hide();
    $(".esc-page").css("top", "0cm");
  }
};


window.Sidebar = {
  visible: false,
  open: function(){
    if(Sidebar.visible) return;
    $(".esc-sidebar").animate({left: "+=300"}, 200);
    $(".esc-sidebar-hider").show();
    $(".esc-sidebar-hider").animate({opacity: "+=0.2"}, 200);
    Sidebar.visible = true;
  },
  close: function(){
    if(!Sidebar.visible) return;
    $(".esc-sidebar").animate({left: "-=300"}, 200);          
    $(".esc-sidebar-hider").animate({opacity: "-=0.2"}, 200, function(){ $(".esc-sidebar-hider").hide(); });
    Sidebar.visible = false;
  },
  refreshProfile: function(){
    Ajax.background("ws/sidebar-data.php", {}, function(data){
        $(".esc-profile .esc-profile-pic img").prop("src", "ws/picture.php?type=thumbnail&picture_id=" + data.picture);
        $(".esc-menu-name").text(data.firstName);
      }, "json");
  }
};

window.Bell = {
  visible: false,
  hiddenTitle: "",
  init: function(){
    var height = this.adjustHeight();
    $(".esc-bell-ct").css("bottom", height * (-1));
    this.visible = false;
    window.addEventListener("orientationchange", function(){
      Bell.adjustHeight();
    });
  },
  open: function(){
    var height = this.adjustHeight();
    strVal = "+=" + height;
    Bell.hiddenTitle = $(".esc-title").text();
    $(".esc-bell-ct").animate({bottom: strVal}, 300, function(){
      Topbar.setText("Benachrichtigungen");
    });
    this.visible = true;
  },
  close: function(){
    var height = this.adjustHeight();
    strVal = "-=" + height;
    $(".esc-bell-ct").animate({bottom: strVal}, 300, function(){Topbar.setText(Bell.hiddenTitle);});
    this.visible = false;
  },
  adjustHeight: function(){
    var height = Global.window().height - Global.topbar().height;
    $(".esc-bell-ct").height(height);
    if(!this.visible){
      $(".esc-bell-ct").css("bottom", height * (-1));
    }
    return height;
  },
  toggle: function(){
    if(this.visible)
      this.close();
    else
      this.open();
  },
  Badge: {
    count: 0,
    plus: function(){
      this.count++;
      $(".esc-bell-badge").text(this.count);
      if(this.count > 9){
        $(".esc-bell-badge").html("9<sup>+</sup>");
      }
      $(".esc-bell-badge").show();
    },
    minus: function(){
      this.count--;
      $(".esc-bell-badge").text(this.count);
      if(this.count == 0){
        this.clear();
      }
    },
    clear: function(){
      this.count = 0;
      $(".esc-bell-badge").hide();
    }
  },
  Messages: {
    lastDelete: 0,
    count: 0,
    add: function(msg){
      var item = '<div class="esc-bell-item-ct" data-bell-id="' + msg.id + '" data-chat-id="' + msg.data.chat_id + '" onclick="Bell.Messages.open(\'' + msg.data.chat_id + '\');">' +
                    '<div class="esc-bell-item">' +
                      '<div class="esc-bell-item-left">' +
                        '<div class="esc-bell-item-avatar">' +
                          '<img src="ws/picture.php?type=thumbnail&picture_id=' + msg.data.sender.picture +'" />' +
                        '</div>' +
                        '<div class="esc-bell-item-content">' +
                          '<div class="esc-bell-item-content-title">' + msg.data.sender.firstName + ', ' + msg.data.sender.age + '</div>' +
                          '<div class="esc-bell-item-content-text">' + msg.data.content + '</div>' +
                        '</div>' +
                      '</div>' +
                      '<div class="esc-bell-item-delete">' +
                        '<img src="img/delete-grey.png" onclick="Bell.Messages.remove(\'' + msg.id + '\');" />' +
                      '</div>' +
                    '</div>' +
                  '</div>';
      this.count++;
      Bell.Badge.plus();
      $(".esc-bell-msg-ct").append(item);
      $(".esc-bell-msg-ct").show();
      $(".esc-bell-empty").hide();
    },
    remove: function(itemId){
      this.lastDelete = (new Date()).getTime();
      this.count--;
      Bell.Badge.minus();
      SseManager.bellSeen(itemId);
      $(".esc-bell-item-ct[data-bell-id=" + itemId + "]").remove();
      if(this.count == 0){
        $(".esc-bell-msg-ct").hide();
        if(Bell.Requests.count == 0){
          $(".esc-bell-empty").show();
        }
      }
    },
    open: function(chatId){
      if((new Date()).getTime() - this.lastDelete == 0)
        return;
      var itemId = $(".esc-bell-item-ct[data-chat-id=" + chatId + "]").attr("data-bell-id");
      SseManager.bellSeen(itemId);
      this.remove(itemId);
      window.location.hash = "#chat?id=" + chatId;
      Bell.close();
    }
  },
  Offers: {
    lastDelete: 0,
    count: 0,
    add: function(offer){
      var item = '<div class="esc-bell-item-ct" data-bell-id="' + offer.id + '" data-offer-id="' + offer.data.offer_id + '" data-profile-id="' + offer.data.sender.user_id + '" onclick="Bell.Offers.open(\'' + offer.data.offer_id + '\');">' +
                    '<div class="esc-bell-item">' +
                      '<div class="esc-bell-item-left">' +
                        '<div class="esc-bell-item-avatar">' +
                          '<img src="ws/picture.php?type=thumbnail&picture_id=' + offer.data.sender.picture +'" />' +
                        '</div>' +
                        '<div class="esc-bell-item-offer-content">' +
                          '<div class="esc-bell-item-content-title">' + offer.data.sender.firstName + ', ' + offer.data.sender.age + '</div>' +
                        '</div>' +
                      '</div>' +
                      '<div class="esc-bell-item-delete">' +
                        '<img src="img/delete-grey.png" onclick="Bell.Offers.remove(\'' + offer.id + '\');" />' +
                      '</div>' +
                    '</div>' +
                  '</div>';
      this.count++;
      Bell.Badge.plus();
      $(".esc-bell-offer-ct").append(item);
      $(".esc-bell-offer-ct").show();
      $(".esc-bell-empty").hide();
    },
    remove: function(itemId){
      this.lastDelete = (new Date()).getTime();
      this.count--;
      Bell.Badge.minus();
      SseManager.bellSeen(itemId);
      $(".esc-bell-item-ct[data-bell-id=" + itemId + "]").remove();
      if(this.count == 0){
        $(".esc-bell-offer-ct").hide();
        if(Bell.Requests.count == 0){
          $(".esc-bell-empty").show();
        }
      }
    },
    open: function(offerId){
      if((new Date()).getTime() - this.lastDelete == 0)
        return;
      var itemId = $(".esc-bell-item-ct[data-offer-id=" + offerId + "]").attr("data-bell-id");
      var usrId = $(".esc-bell-item-ct[data-offer-id=" + offerId + "]").attr("data-profile-id");
      SseManager.bellSeen(itemId);
      this.remove(itemId);
      window.location.hash = "#profile?userid=" + usrId;
      Bell.close();
    }
  },
  Requests: {
    lastDelete: 0,
    count: 0,
    add: function(req){
      var item = '<div class="esc-bell-item-ct" data-bell-id="' + req.id + '" data-req-id="' + req.data.req_id + '" onclick="Bell.Requests.open(\'' + req.data.req_id + '\');">' +
                    '<div class="esc-bell-item">' +
                      '<div class="esc-bell-item-left">' +
                        '<div class="esc-bell-item-avatar">' +
                          '<img src="ws/picture.php?type=thumbnail&picture_id=' + req.data.sender.picture +'" />' +
                        '</div>' +
                        '<div class="esc-bell-item-content">' +
                          '<div class="esc-bell-item-content-title">' + req.data.sender.firstName + ', ' + req.data.sender.age + '</div>' +
                          '<div class="esc-bell-item-content-text">' + req.data.targetTime.date + ', ' + req.data.targetTime.time + '</div>' +
                        '</div>' +
                      '</div>' +
                      '<div class="esc-bell-item-delete">' +
                        '<img src="img/delete-grey.png" onclick="Bell.Messages.remove(\'' + req.id + '\');" />' +
                      '</div>' +
                    '</div>' +
                  '</div>';
      this.count++;
      Bell.Badge.plus();
      $(".esc-bell-req-ct").append(item);
      $(".esc-bell-req-ct").show();
      $(".esc-bell-empty").hide();
    },
    remove: function(itemId){
      this.lastDelete = (new Date()).getTime();
      this.count--;
      Bell.Badge.minus();
      SseManager.bellSeen(itemId);
      $(".esc-bell-item-ct[data-bell-id=" + itemId + "]").remove();
      if(this.count == 0){
        $(".esc-bell-req-ct").hide();
        if(Bell.Requests.count == 0){
          $(".esc-bell-empty").show();
        }
      }
    },
    open: function(reqId){
      if((new Date()).getTime() - this.lastDelete == 0)
        return;
      var itemId = $(".esc-bell-item-ct[data-req-id=" + reqId + "]").attr("data-bell-id");
      SseManager.bellSeen(itemId);
      this.remove(itemId);
      window.location.hash = "#request?id=" + reqId;
      Bell.close();
    }
  }
};


window.Navigation = {
  init: function(){
    $(window).on('hashchange', Navigation.hashTagChanged);
    Navigation.hashTagChanged();
  },
  hashTagChanged: function(){
    //Parameter
    var ioh = location.href.indexOf("?");
    var params = "";
    if (ioh > 0)
        params = location.href.substring(ioh);
    
    //Hash
    ioh = location.hash.indexOf("?");
    var hash = location.hash;
    if (ioh > 0)
        hash = location.hash.substring(0, ioh);
    if(hash == "" || hash == "#_=_"){
      hash = "#startview";
    }
    
    //Navigation ladet content
    switch (hash) {
      default:
        var site = hash.substring(1);
        Ajax.load(".esc-page", "page/" + site + ".php" + params);
        //$(".esc-page").load("page/" + site + ".php" + params);
        break;
    }

    Sidebar.close();
  },
  getUrlParams: function(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  }
};

window.Timer = {
  tmr: null,
  handler: null,
  init: function(){
    window.Timer.tmr = setInterval(function(){
      if(window.Timer.handler != null){
        window.Timer.handler();
      }
    }, 1000);
  },
  unset: function(){
    window.Timer.handler = null;
  }
};

window.Snackbar = {
  show: function(msg){
    $(".esc-snackbar").text(msg);
    $(".esc-snackbar").addClass("esc-snackbar-show");
    setTimeout(function(){
      $(".esc-snackbar").removeClass("esc-snackbar-show");
    }, 3000);
  }
};

window.DataStore = {
  email: function(val){
    return DataStore.process("esc_user_email", val);
  },
  password: function(val){
    return DataStore.process("esc_user_pw", val);
  },
  autoLogin: function(val){
    return DataStore.process("esc_user_autologin", val);
  },
  process: function(id, val){
    if(val === undefined){
      var result = localStorage.getItem(id);
      if(result !== undefined)
        return result;
      return null;
    }
    localStorage.setItem(id, val);
  }
};

window.Ajax = {
  background: function(url, data, success){
    $.post(url, data, success);
  },
  post: function(url, data, success){
    Ajax.showCurtain();
    $.post(url, data).done(function(response){
      Ajax.hideCurtain();
      if(success !== undefined)
        success(response);
    });
  },
  get: function(url, data, success){
    Ajax.showCurtain();
    $.post(url, data, function(response){
      Ajax.hideCurtain();
      if(success !== undefined)
        success(response);
    }, "json");
  },
  load: function(container, url){
    Ajax.showCurtain();
    $(container).load(url, function(response){
      Ajax.hideCurtain();
    });
  },
  pictureUpload: function(data, success){
    $.ajax({
        url: "ws/picture-upload.php?",
        dataType: 'json',
        cache: false,
        processData: false,
        data: data,
        contentType: false,
        type: 'POST',
        success: function(response){
          Ajax.hideCurtain();
          if(success !== undefined)
            success(response);
        }
      });
    Ajax.showCurtain();
  },
  showCurtain: function(){
    $(".esc-ajax-curtain").show();
    $(".esc-ajax-loader").show();
  },
  hideCurtain: function(){
    $(".esc-ajax-curtain").hide();
    $(".esc-ajax-loader").hide();
  }
};

window.SseManager = {
  source: null,
  init: function(){
    this.source = new EventSource("ws/notifications.php");
    this.source.onmessage = function(event){
      SseManager.received(event);
    }
  },
  received: function(event){
    var data = $.parseJSON(event.data);
    for (var i = 0; i < data.length; i++) {
      this.processBell(data[i]);
    }
  },
  processBell: function(bell){
    if($(".esc-bell-item-ct[data-bell-id=" + bell.id + "]").length > 0)
      return;

    if(bell.type == "R")
      this.processRequestBell(bell);
    if(bell.type == "O")
      this.processOfferBell(bell);
    if(bell.type == "M")
      this.processMsgBell(bell);
  },
  processRequestBell: function(reqBell){
    if(window.location.hash == "#listening"){
      window.ListeningReceiver.receivedReq(reqBell);
      SseManager.bellSeen(reqBell.id);
    }
    else{
      Bell.Requests.add(reqBell);
    }
  },
  processOfferBell: function(offerBell){
    if(window.location.hash == "#offers"){
      window.Offers.receivedOffer(offerBell);
      SseManager.bellSeen(offerBell.id);
    }
    else{
      Bell.Offers.add(offerBell);
    }
  },
  processMsgBell: function(msgBell){
    if(window.location.hash == "#chat?id=" + msgBell.data.chat_id){
      window.ChatManager.receivedMsg(msgBell);
      SseManager.bellSeen(msgBell.id);
    }
    else{
      Bell.Messages.add(msgBell);
    }
  },
  bellSeen: function(bellId){
    var data = { bell_id: bellId };
    window.Ajax.background("ws/notification-seen.php", data);
  }
};