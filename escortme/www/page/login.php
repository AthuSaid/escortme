<div class="esc-login-ct">
  <div class="esc-escortme-h1 w3-center">
    <h1>Login</h1>
  </div>

  <div>
    <div class="esc-container esc-login-social-ct">
    	<div class="w3-center"><img src="img/facebook-logo.png" onclick="loginFB();" /></div>
    	<div class="w3-center"><img src="img/google-plus-logo.png" onclick="loginGP();" /></div>
    </div>
    oder
    <form>
    	<input type="email" class="w3-input esc-input-email" placeholder="Email" />
    	<input type="password" class="w3-input esc-input-pw" placeholder="Passwort" />
    	<div class="esc-button" onclick="login();">Login</div>
    </form>
  </div>
</div>


<div class="esc-skyline-bg">
  <img src="img/skyline-bg.jpg" />
</div>
<style type="text/css" style="display: none !important;">
  .esc-skyline-bg {
	z-index: -1;
	opacity: 0.7;
	position: fixed;
	width: 100%;
	height: 100%;
	left: 0px;
	top: 0px;
  }
  .esc-skyline-bg img {
  	width: 100%;
  	height: 100%;
  }
  .esc-escortme-h1{
  	width: 100%;
  	color: #ECF0F1;
  }
  .esc-escortme-h1 h1{
  	font-family: Roboto-Light;
  }
  .esc-login-social-ct{
  	width: 100%;
  }
  .esc-login-social-ct div{
  	width: 50%;
  }
  .esc-login-social-ct img{
  	width: 2cm;
  	height: 2cm;
  }

  form{
  	margin-top: 30px;
  }

  .esc-login-ct{
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0.5cm;
    text-align: center;
    color: #fff;
  }

</style>
<script type="text/javascript">
	Topbar.hide();

  function loadData(){
    var email = DataStore.email();
    var pw = DataStore.password();
    $(".esc-input-email").val(email);
    $(".esc-input-pw").val(pw);
    if(DataStore.autoLogin() == 1)
      login();
  }

  function login(){
    var mail = $(".esc-input-email").val();
    var pass = $(".esc-input-pw").val();

    var data = {
      email: mail,
      pw: pass
    };

    Ajax.get("ws/login.php", data, function(response){
      if(response.success == 1){
        DataStore.email(mail);
        DataStore.password(pass);
        DataStore.autoLogin(1);
        nextPage();
      }
      else
        Snackbar.show("Falsche Daten");
    });
	}

	function loginFB(){
    Snackbar.show("Not available ...");
	}

	function loginGP(){
		Snackbar.show("Not available ...");
	}

  function nextPage(){
    window.location.hash = "#home";
  }

  loadData();

</script>