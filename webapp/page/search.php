<div class="esc-search-ct">

  <div>
    <label>Datum + Uhrzeit:</label>
    <div class="esc-date-time-ct">
      <div>
        <input type="date" class="w3-input" />
      </div>
      <div>
        <input type="time" class="w3-input" />
      </div>
    </div>
  </div>

  <div>
    <label>Altersbereich:</label>
    <div class="esc-age-range-ct">
      <input type="number" class="w3-input" />
      <label> bis </label> 
      <input type="number" class="w3-input" />
    </div>
  </div>

  <div>
    <select class="w3-select esc-input-sex">
      <option value="a">Alle</option>
      <option value="p">Nur mit Profilbild</option>
      <option value="v">Nur verifizierte User</option>
    </select>
  </div>

  <div class="esc-text-ct">
    <label>Was ich suche:</label>
    <textarea class="w3-input"></textarea>
  </div>

  <div>
    <label>Keywords</label>
    <input type="text" class="w3-input" />
  </div>

  <div>
    <label>Maximale Laufzeit: </label><label class="esc-running-time">2 Stunden</label>
    <input type="range" min="1" max="4" value="2" step="0.5" class="esc-running-time-range" />
  </div>

  <div>
    <div class="esc-button">Los</div>
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
  });

</script>