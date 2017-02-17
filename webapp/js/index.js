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
    count: 0,
    add: function(msg){
      var item = '<div class="esc-bell-item esc-container" data-bell-id="' + msg.id + '">' +
                  '<div class="esc-bell-item-avatar"><img src="' +
                  msg.avatar + '"></div>' +
                  '<div class="esc-bell-item-text">' +
                  '<label>' + msg.firstName + ', ' + msg.age + '</label></div>' +
                  '<div class="w3-right-align esc-bell-item-delete"' +
                  'onclick="Bell.Messages.remove(' + msg.id + ')">' +
                  '<img src="img/delete-grey.png"></div></div>';
      this.count++;
      Bell.Badge.plus();
      $(".esc-bell-msg-ct").append(item);
      $(".esc-bell-msg-ct").show();
      $(".esc-bell-empty").hide();
    },
    remove: function(itemId){
      this.count--;
      Bell.Badge.minus();
      $(".esc-bell-item[data-bell-id=" + itemId + "]").remove();
      if(this.count == 0){
        $(".esc-bell-msg-ct").hide();
        if(Bell.Requests.count == 0){
          $(".esc-bell-empty").show();
        }
      }
    }
  },
  Requests: {
    count: 0,
    add: function(msg){
      var item = '<div class="esc-bell-item esc-container" data-bell-id="' + msg.id + '">' +
                  '<div class="esc-bell-item-avatar"><img src="' +
                  msg.avatar + '"></div>' +
                  '<div class="esc-bell-item-text">' +
                  '<label>' + msg.firstName + ', ' + msg.age + '</label></div>' +
                  '<div class="w3-right-align esc-bell-item-delete"' +
                  'onclick="Bell.Requests.remove(' + msg.id + ')">' +
                  '<img src="img/delete-grey.png"></div></div>';
      this.count++;
      Bell.Badge.plus();
      $(".esc-bell-req-ct").append(item);
      $(".esc-bell-req-ct").show();
      $(".esc-bell-empty").hide();
    },
    remove: function(itemId){
      this.count--;
      Bell.Badge.minus();
      $(".esc-bell-item[data-bell-id=" + itemId + "]").remove();
      if(this.count == 0){
        $(".esc-bell-req-ct").hide();
        if(Bell.Messages.count == 0){
          $(".esc-bell-empty").show();
        }
      }
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
        $(".esc-page").load("page/" + site + ".php" + params);
        break;
    }

    Sidebar.close();
  }
};
