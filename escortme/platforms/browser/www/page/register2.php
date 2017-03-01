<?php


?>

<div class="esc-register-ct">
  <div class="esc-escortme-h1 w3-center">
    <h1>Registrieren</h1>
  </div>

  <div>
    <form>
    	<input type="text" class="w3-input esc-input-name" placeholder="Name" />
    	<select class="w3-select esc-input-gender">
        <option value="" disabled selected>Geschlecht</option>
        <option value="M">Männlich</option>
        <option value="F">Weiblich</option>
        <option value="T">Transexuel</option>
      </select>
      <input type="date" class="w3-input esc-input-dob" placeholder="Geburtstag" />
    	<div class="esc-button" onclick="register();">Weiter →</div>
      <div class="esc-register-counter w3-center">2/3</div>
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
  .esc-register-counter{
    width: 100%;
    font-size: 10px;
    color: #ECF0F1;
  }

  .esc-register-ct{
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

  function register(){
    var fullName = $(".esc-input-name").val();
    var gender = $(".esc-input-gender").val();
    var dob = $(".esc-input-dob").val();

    var data = {
      name: fullName,
      gender: gender,
      dob: dob
    };

    Ajax.get("ws/register.php", data, function(response){
      if(response.success == 1){
        DataStore.email(response.email);
        DataStore.password(response.pw);
        nextPage();
      }
      else{
        Snackbar.show("Fehler beim Registrieren");
      }
    });
  }

  function nextPage(){
    window.location.hash = "#home";
  }

</script>