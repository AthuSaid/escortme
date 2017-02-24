<?php

require '../ws/class/loader.php';
classloader("../");

$user = SessionManager::user();
$logger = LogFactory::logger('page.search');
$db = DatabaseConnection::get();

$rs = new RequestService($logger, $db);

//There is already a request -> Go to offers
$goToOffers = "";
$request = $rs->getActiveRequest($user['id']);
if($request != null){
  $goToOffers = "goToOffers();";
}


//Fill the formular with the latest data
$today = date('Y-m-d');
$time = "20:00";
$agefrom = "20";
$ageto = "40";
$description = "";
$maxprice = 0.0;
$levelA = " selected";
$levelP = "";
$levelV = "";

$lr = $rs->getLatestRequest($user['id']); //print_r($lr);
if($lr != null){
  $targetTime = explode(" ", $lr['targetTime']);
  $timeParts = explode(":", $targetTime[1]);
  $time = $timeParts[0].":".$timeParts[1];
  $agefrom = $lr['ageFrom'];
  $ageto = $lr['ageTo'];
  $description = $lr['description'];
  $maxprice = $lr['maxPrice'];
  $levelA = $lr['level'] == "A" ? " selected" : "";
  $levelP = $lr['level'] == "P" ? " selected" : "";
  $levelV = $lr['level'] == "V" ? " selected" : "";
}


?>

<div class="esc-search-ct">

  <div>
    <label>Datum + Uhrzeit:</label>
    <div class="esc-date-time-ct">
      <div>
        <input type="date" class="w3-input esc-input-date" value="<?php echo $today; ?>" />
      </div>
      <div>
        <input type="time" class="w3-input esc-input-time" value="<?php echo $time; ?>" />
      </div>
    </div>
  </div>

  <div>
    <label>Altersbereich:</label>
    <div class="esc-age-range-ct">
      <input type="number" min="18" value="<?php echo $agefrom; ?>" class="w3-input esc-input-agefrom" />
      <label> bis </label> 
      <input type="number" max="80" value="<?php echo $ageto; ?>" class="w3-input esc-input-ageto" />
    </div>
  </div>

  <div>
    <select class="w3-select esc-input-level">
      <option value="A" <?php echo $levelA; ?>>Alle</option>
      <option value="P" <?php echo $levelP; ?>>Nur mit Profilbild</option>
      <option value="V" <?php echo $levelV; ?>>Nur verifizierte User</option>
    </select>
  </div>

  <div class="esc-max-preis">
    <label>Max. Preis: </label>
    <input type="number" class="w3-input esc-input-maxprice" value="<?php echo $maxprice; ?>" />
  </div>

  <div class="esc-text-ct">
    <label>Was ich suche:</label>
    <textarea class="w3-input  esc-input-description"><?php echo $description; ?></textarea>
  </div>

  <div>
    <label>Keywords</label>
    <input type="text" class="w3-input  esc-input-keywords" />
  </div>

  <div>
    <label>Maximale Laufzeit: </label><label class="esc-running-time">2 Stunden</label>
    <input type="range" min="1" max="4" value="2" step="0.5" class="esc-running-time-range  esc-input-duration" />
  </div>

  <div>
    <div class="esc-button" onclick="search();">Los</div>
  </div>

</div>

<style type="text/css">
	
	.esc-search-ct{
    padding: 10px 0.5cm;
    line-height: 1;
	}

  .esc-search-ct > div{
    margin-bottom: 30px;
  }
  .esc-search-ct > div:last-of-type{
    margin-bottom: 0px;
  }

  .esc-search-ct label{
    line-height: 1;
    font-size: 12px;
  }

  .esc-date-time-ct{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .esc-age-range-ct{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }
  .esc-age-range-ct label{
    padding-left: 10px;
    padding-right: 10px;
    text-align: center;
    font-size: 16px;
  }
  .esc-max-preis{
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
    align-items: center;
  }
  .esc-max-preis label{
    width: 3cm;
  }


  /* RANGE-SLIDER */
  input[type=range] {
    -webkit-appearance: none;
    margin: 10px 0;
    width: 100%;
  }
  input[type=range]:focus {
    outline: none;
  }
  input[type=range]::-webkit-slider-runnable-track {
    width: 100%;
    height: 3px;
    cursor: pointer;
    animate: 0.2s;
    box-shadow: 0px 0px 0px #000000;
    background: #3498DB;
    border-radius: 0px;
    border: 0px solid #000000;
  }
  input[type=range]::-webkit-slider-thumb {
    box-shadow: 0px 0px 0px #000000;
    border: 1px solid #ce4335;
    height: 18px;
    width: 18px;
    border-radius: 20px;
    background: #E74C3C;
    cursor: pointer;
    -webkit-appearance: none;
    margin-top: -8px;
  }
  input[type=range]:focus::-webkit-slider-runnable-track {
    background: #3498DB;
  }
  input[type=range]::-moz-range-track {
    width: 100%;
    height: 3px;
    cursor: pointer;
    animate: 0.2s;
    box-shadow: 0px 0px 0px #000000;
    background: #3498DB;
    border-radius: 0px;
    border: 0px solid #000000;
  }
  input[type=range]::-moz-range-thumb {
    box-shadow: 0px 0px 0px #000000;
    border: 1px solid #ce4335;
    height: 18px;
    width: 18px;
    border-radius: 20px;
    background: #E74C3C;
    cursor: pointer;
  }
  input[type=range]::-ms-track {
    width: 100%;
    height: 3px;
    cursor: pointer;
    animate: 0.2s;
    background: transparent;
    border-color: transparent;
    color: transparent;
  }
  input[type=range]::-ms-fill-lower {
    background: #3498DB;
    border: 0px solid #000000;
    border-radius: 0px;
    box-shadow: 0px 0px 0px #000000;
  }
  input[type=range]::-ms-fill-upper {
    background: #3498DB;
    border: 0px solid #000000;
    border-radius: 0px;
    box-shadow: 0px 0px 0px #000000;
  }
  input[type=range]::-ms-thumb {
    box-shadow: 0px 0px 0px #000000;
    border: 1px solid #ce4335;
    height: 18px;
    width: 18px;
    border-radius: 20px;
    background: #E74C3C;
    cursor: pointer;
  }
  input[type=range]:focus::-ms-fill-lower {
    background: #3498DB;
  }
  input[type=range]:focus::-ms-fill-upper {
    background: #3498DB;
  }
</style>

<script type="text/javascript">
  
  Topbar.show();
  Topbar.setText("Anfragen");

  $(".esc-running-time-range").on("change mousemove", function(){
    var val = $(this).val();
    var strStunden = " Stunden";
    if(val == 1)
      strStunden = " Stunde";
    $(".esc-running-time").text(val + strStunden);

    var percent = parseInt(((val-1) * 100) / 3);
    /* Background-color:

background: -moz-linear-gradient(left,  #3498DB 49%, #3498DB 49%, #E74C3C 50%);
background: -webkit-linear-gradient(left,  #3498DB 49%,#3498DB 49%,#E74C3C 50%); 
background: linear-gradient(to right,  #3498DB 49%,#3498DB 49%,#E74C3C 50%); 
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3498DB', endColorstr='#E74C3C',GradientType=1 );

     */
  });

  $(".esc-input-agefrom, .esc-input-ageto").change(function(){
    var max = $(".esc-input-ageto").val();
    var min = $(".esc-input-agefrom").val();
    $(".esc-input-agefrom").prop('max', max);
    $(".esc-input-ageto").prop('min', min);
  });

  function search(){
    var datum = $(".esc-input-date").val();
    var time = $(".esc-input-time").val();
    var agefrom = $(".esc-input-agefrom").val();
    var ageto = $(".esc-input-ageto").val();
    var level = $(".esc-input-level").val();
    var maxprice = $(".esc-input-maxprice").val();
    var description = $(".esc-input-description").val();
    var duration = $(".esc-input-duration").val();

    var params = {
      targetTime: datum + " " + time + ":00",
      ageFrom: agefrom,
      ageTo: ageto,
      level: level,
      maxPrice: maxprice,
      description: description,
      duration: duration
    };

    if(!validate(params))
      return;

    Ajax.post("ws/request-create.php", params, function(resp){
      goToOffers();
    });
  }

  function validate(request){
    if(request.ageFrom > request.ageTo){
      alert("Alter ist inkorrekt!");
      return false;
    }

    return true;
  }

  function goToOffers(){
    window.location.hash = "#offers";
  }
  <?php echo $goToOffers; ?>

</script>