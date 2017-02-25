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
    count: 0,
    add: function(msg){
      var item = '<div class="esc-bell-item-ct" data-bell-id="' + msg.id + '">' +
                    '<div class="esc-bell-item">' +
                      '<div class="esc-bell-item-left">' +
                        '<div class="esc-bell-item-avatar">' +
                          '<img src="' + msg.avatar +'" />' +
                        '</div>' +
                        '<div class="esc-bell-item-content">' +
                          '<div class="esc-bell-item-content-title">' + msg.firstName + ', ' + msg.age + '</div>' +
                          '<div class="esc-bell-item-content-text">' + msg.content + '</div>' +
                        '</div>' +
                      '</div>' +
                      '<div class="esc-bell-item-delete">' +
                        '<img src="img/delete-grey.png" onclick="Bell.Messages.remove(' + msg.id + ');" />' +
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
      this.count--;
      Bell.Badge.minus();
      $(".esc-bell-item-ct[data-bell-id=" + itemId + "]").remove();
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
      var item = '<div class="esc-bell-item-ct" data-bell-id="' + msg.id + '">' +
                    '<div class="esc-bell-item">' +
                      '<div class="esc-bell-item-left">' +
                        '<div class="esc-bell-item-avatar">' +
                          '<img src="' + msg.avatar +'" />' +
                        '</div>' +
                        '<div class="esc-bell-item-req-content">' +
                          '<div class="esc-bell-item-content-title">' + msg.firstName + ', ' + msg.age + '</div>' +
                        '</div>' +
                      '</div>' +
                      '<div class="esc-bell-item-delete">' +
                        '<img src="img/delete-grey.png" onclick="Bell.Requests.remove(' + msg.id + ');" />' +
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
