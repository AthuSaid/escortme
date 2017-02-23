<?php

$email = "";
if(isset($_REQUEST['email']))
  $email = $_REQUEST['email'];
$pw = "";
if(isset($_REQUEST['pw']))
  $pw = $_REQUEST['pw'];

?>

<div class="esc-register-ct">
  <div class="esc-escortme-h1 w3-center">
    <h1>Registrieren</h1>
  </div>

  <div>
    <form>
    	<input type="text" class="w3-input" class="esc-input-name" placeholder="Name" />
    	<select class="w3-select esc-input-sex">
        <option value="" disabled selected>Geschlecht</option>
        <option value="m">Männlich</option>
        <option value="w">Weiblich</option>
        <option value="t">Transexuel</option>
      </select>
      <input type="date" class="w3-input" class="esc-input-dob" placeholder="Geburtstag" />
    	<div class="esc-button" onclick="nextPage();">Weiter →</div>
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

  var email = "<?php echo $email; ?>";
  var pw = "<?php echo $pw; ?>";

  function nextPage(){
    window.location.hash = "#home";
  }

</script>