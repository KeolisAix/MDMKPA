<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
$base = pg_connect("host=192.168.207.22 dbname=cellules_compteuses user=postgres password=postgres");
$mois = $_GET['Mois'];
$validation = $_GET['submit'];
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Tableau des Cellules Compteuses</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
		<script src="js/modernizr.custom.63321.js"></script>
        <style>
          @import url(http://fonts.googleapis.com/css?family=Ubuntu:400,700);
			body {
				background: #563c55 url(images/blurred.jpg) no-repeat center top;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				background-size: cover;
			}
            
.pretty-table
{
  padding: 0;
  margin: 0;
  border-collapse: collapse;
  border: 1px solid #333;
  font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;
  font-size: 0.9em;
  color: #000;
  background: #bcd0e4 url("http://www.elated.com/res/File/articles/authoring/css/styling-tables-with-css/widget-table-bg.jpg") top left repeat-x;
}

.pretty-table caption
{
  caption-side: bottom;
  font-size: 0.9em;
  font-style: italic;
  text-align: center;
  padding: 0.5em 0;
}

.pretty-table th, .pretty-table td
{
  border: 1px dotted #666;
  padding: 0.5em;
  text-align: center;
  color: #632a39;
}

.pretty-table th[scope=col]
{
  color: #000;
  background-color: #8fadcc;
  text-transform: uppercase;
  font-size: 0.9em;
  border-bottom: 2px solid #333;
  border-right: 2px solid #333;
}

.pretty-table th+th[scope=col]
{
  color: #fff;
  background-color: #7d98b3;
  border-right: 1px dotted #666;
}

.pretty-table th[scope=row]
{
  background-color: #b8cfe5;
  border-right: 2px solid #333;
}

.pretty-table tr.alt th, .pretty-table tr.alt td
{
  color: #2a4763;
}

.pretty-table tr:hover th[scope=row], .pretty-table tr:hover td
{
  background-color: #632a2a;
  color: #fff;
}
            
.progress {
    height: 22px;
    background: #ebebeb;
    border-left: 1px solid transparent;
    border-right: 1px solid transparent;
    border-radius: 10px;
    visibility: hidden;
}
.progress > span {
    position: relative;
    float: left;
    margin: 0 -1px;
    min-width: 30px;
    line-height: 18px;
    text-align: center;
    background: #cccccc;
    border: 1px solid;
    border-color: #bfbfbf #b3b3b3 #9e9e9e;
    border-radius: 10px;
    background-image: -webkit-linear-gradient(top, #f0f0f0, #dbdbdb 70%, #cccccc);
    background-image: -moz-linear-gradient(top, #f0f0f0, #dbdbdb 70%, #cccccc);
    background-image: -o-linear-gradient(top, #f0f0f0, #dbdbdb 70%, #cccccc);
    background-image: linear-gradient(to bottom, #f0f0f0, #dbdbdb 70%, #cccccc);
    -webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px rgba(255, 255, 255, 0.3), 0 1px 2px rgba(0, 0, 0, 0.2);
}
.progress > span > span {
    padding: 0 8px;
    font-size: 11px;
    font-weight: bold;
    color: #404040;
    color: rgba(0, 0, 0, 0.7);
    text-shadow: 0 1px rgba(255, 255, 255, 0.4);
}
.progress > span:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1;
    height: 18px;
    background: url("http://www.jqueryscript.net/demo/Smooth-Progress-Bar-Loading-Effect-With-jQuery/images/progress.png") 0 0 repeat-x;
    border-radius: 10px;
}
.progress .green {
    background: #85c440;
    border-color: #78b337 #6ba031 #568128;
    background-image: -webkit-linear-gradient(top, #b7dc8e, #99ce5f 70%, #85c440);
    background-image: -moz-linear-gradient(top, #b7dc8e, #99ce5f 70%, #85c440);
    background-image: -o-linear-gradient(top, #b7dc8e, #99ce5f 70%, #85c440);
    background-image: linear-gradient(to bottom, #b7dc8e, #99ce5f 70%, #85c440);
}
.progress .red {
    background: #db3a27;
    border-color: #c73321 #b12d1e #8e2418;
    background-image: -webkit-linear-gradient(top, #ea8a7e, #e15a4a 70%, #db3a27);
    background-image: -moz-linear-gradient(top, #ea8a7e, #e15a4a 70%, #db3a27);
    background-image: -o-linear-gradient(top, #ea8a7e, #e15a4a 70%, #db3a27);
    background-image: linear-gradient(to bottom, #ea8a7e, #e15a4a 70%, #db3a27);
}
.progress .orange {
    background: #f2b63c;
    border-color: #f0ad24 #eba310 #c5880d;
    background-image: -webkit-linear-gradient(top, #f8da9c, #f5c462 70%, #f2b63c);
    background-image: -moz-linear-gradient(top, #f8da9c, #f5c462 70%, #f2b63c);
    background-image: -o-linear-gradient(top, #f8da9c, #f5c462 70%, #f2b63c);
    background-image: linear-gradient(to bottom, #f8da9c, #f5c462 70%, #f2b63c);
}
.progress .blue {
    background: #5aaadb;
    border-color: #459fd6 #3094d2 #277db2;
    background-image: -webkit-linear-gradient(top, #aed5ed, #7bbbe2 70%, #5aaadb);
    background-image: -moz-linear-gradient(top, #aed5ed, #7bbbe2 70%, #5aaadb);
    background-image: -o-linear-gradient(top, #aed5ed, #7bbbe2 70%, #5aaadb);
    background-image: linear-gradient(to bottom, #aed5ed, #7bbbe2 70%, #5aaadb);
}

        </style>
        <script>
            function generate_excel(tableid) {
                var table = document.getElementById(tableid);
                var html = table.outerHTML;
                window.open('data:application/vnd.ms-excel;base64,' + base64_encode(html));
            }
            function pro() {
                document.getElementById("progressCont").style.visibility = "visible";
                setInterval(update, 1000);                
            }
            var status = Number(0);
            function update() {
                status = Number(status) + Number(1);
                loading(status + '%');
                if(status > Number(35)){
                    document.getElementById("pro").style.textAlign = "center";
                }
                else{
                    document.getElementById("pro").style.textAlign = "left";
                }

            }
            function base64_encode(data) {
                var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
                var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
                            ac = 0,
                            enc = "",
                            tmp_arr = [];

                if (!data) {
                    return data;
                }

                do { // pack three octets into four hexets
                    o1 = data.charCodeAt(i++);
                    o2 = data.charCodeAt(i++);
                    o3 = data.charCodeAt(i++);

                    bits = o1 << 16 | o2 << 8 | o3;

                    h1 = bits >> 18 & 0x3f;
                    h2 = bits >> 12 & 0x3f;
                    h3 = bits >> 6 & 0x3f;
                    h4 = bits & 0x3f;

                    // use hexets to index into b64, and append result to encoded string
                    tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
                } while (i < data.length);

                enc = tmp_arr.join('');

                var r = data.length % 3;

                return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

            }
        </script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type='text/javascript'>
function loading(percent){
    $('.progress span').animate({width:percent},1000,function(){
    $(this).children().html(percent);
    if(percent=='100%'){
         $(this).children().html('Chargement terminé affichage du tableau...');
        }
    })
}
</script>
    </head>
    <body>
      <div class="container">
			<section class="main">
                <form action="" method="get" class="form-3">
                    <p class="clearfix">
				        <label for="login">Mois des CC</label>
				        <input type="text" name="Mois" id="Mois" value="Janvier" style="text-align: center">
				    </p>
				    <p class="clearfix">
				        <input type="submit" name="submit" value="Valider" onclick="pro();"><br>
                        <?php if($mois){ echo "<input name=\"Export\" type=\"button\" onClick=\"generate_excel('Tableau');\" value=\"Export Excel\" />"; } ?>
                        <div class="progress" style="margin-top: 5px" id="progressCont"> <span class="orange" id="pro"><span>0%</span></span> </div>
				    </p>       
				</form>​
              </section>
            </div>
        <?php
            if($validation == "Valider"){
                $nbmois;
                if($mois == "Janvier") { $nbmois = "01";}	
                if($mois == "Fevrier") { $nbmois = "02";}	
                if($mois == "Mars") { $nbmois = "03";}	
                if($mois == "Avril") { $nbmois = "04";}	
                if($mois == "Mai") { $nbmois = "05";}	
                if($mois == "Juin") { $nbmois = "06";}	
                if($mois == "Juillet") { $nbmois = "07";}	
                if($mois == "Aout") { $nbmois = "08";}	
                if($mois == "Septembre") { $nbmois = "09";}	
                if($mois == "Octobre") { $nbmois = "10";}	
                if($mois == "Novembre") { $nbmois = "11";}	
                if($mois == "Décembre") { $nbmois = "12";}	
                echo "<table border='1' class='pretty-table' id='Tableau'>";
                $sqlDay = 'SELECT distinct "date" FROM "public"."CC" WHERE "date" LIKE \'%/'.$nbmois.'/%\' ORDER BY "date" ASC';
                $reqDay = pg_query($base ,$sqlDay);
                $nb=pg_num_rows($reqDay);
                echo "<tr><th scope='col' style='white-space: nowrap;'>Numéro</th><th scope='col' style='white-space: nowrap;'>Ligne</th><th scope='col' style='white-space: nowrap;'>Girouette</th><th scope='col' style='white-space: nowrap;'>Girouette</th>";
                for ($i = 1; $i <= $nb; $i++){
                    echo "<th scope='col' style='white-space: nowrap;'>".$i."/".$nbmois."/15</th>";
                }
                echo "<th scope='col' style='white-space: nowrap;'>Total</th></tr>";

                $sqlLigne = 'SELECT * FROM "Girouette" ORDER BY "code" ASC';
                $reqLigne = pg_query($base ,$sqlLigne);
                $dateCal = 01; 
               while ($dataLigne = pg_fetch_array($reqLigne)) {
                    $sqlFreq1 = 'SELECT * FROM "CC" WHERE "date"=\'01/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq1 = pg_query($base ,$sqlFreq1);
                    $totalFreq1 = 0;
                    while ($dataFreq1 = pg_fetch_array($reqFreq1)){
                        $totalFreq1 = $totalFreq1 + $dataFreq1["frequentation"];
                    }
                    // 2
                    $sqlFreq2 = 'SELECT * FROM "CC" WHERE "date"=\'02/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq2 = pg_query($base ,$sqlFreq2);
                    $totalFreq2 = 0;
                    while ($dataFreq2 = pg_fetch_array($reqFreq2)){
                        $totalFreq2 = $totalFreq2 + $dataFreq2["frequentation"];
                    }
                    //3
                    $sqlFreq3 = 'SELECT * FROM "CC" WHERE "date"=\'03/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq3 = pg_query($base ,$sqlFreq3);
                    $totalFreq3 = 0;
                    while ($dataFreq3 = pg_fetch_array($reqFreq3)){
                        $totalFreq3 = $totalFreq3 + $dataFreq3["frequentation"];
                    }
                    //4
					$sqlFreq4 = 'SELECT * FROM "CC" WHERE "date"=\'04/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq4 = pg_query($base ,$sqlFreq4);
                    $totalFreq4 = 0;
                    while ($dataFreq4 = pg_fetch_array($reqFreq4)){
                        $totalFreq4 = $totalFreq4 + $dataFreq4["frequentation"];
                    }
                    //5
					$sqlFreq5 = 'SELECT * FROM "CC" WHERE "date"=\'05/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq5 = pg_query($base ,$sqlFreq5);
                    $totalFreq5 = 0;
                    while ($dataFreq5 = pg_fetch_array($reqFreq5)){
                        $totalFreq5 = $totalFreq5 + $dataFreq5["frequentation"];
                    }
                    //6
					$sqlFreq6 = 'SELECT * FROM "CC" WHERE "date"=\'06/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq6 = pg_query($base ,$sqlFreq6);
                    $totalFreq6 = 0;
                    while ($dataFreq6 = pg_fetch_array($reqFreq6)){
                        $totalFreq6 = $totalFreq6 + $dataFreq6["frequentation"];
                    }
                    //7
					$sqlFreq7 = 'SELECT * FROM "CC" WHERE "date"=\'07/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq7 = pg_query($base ,$sqlFreq7);
                    $totalFreq7 = 0;
                    while ($dataFreq7 = pg_fetch_array($reqFreq7)){
                        $totalFreq7 = $totalFreq7 + $dataFreq7["frequentation"];
                    }
                    //8
					$sqlFreq8 = 'SELECT * FROM "CC" WHERE "date"=\'08/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq8 = pg_query($base ,$sqlFreq8);
                    $totalFreq8 = 0;
                    while ($dataFreq8 = pg_fetch_array($reqFreq8)){
                        $totalFreq8 = $totalFreq8 + $dataFreq8["frequentation"];
                    }
                    //9
					$sqlFreq9 = 'SELECT * FROM "CC" WHERE "date"=\'09/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq9 = pg_query($base ,$sqlFreq9);
                    $totalFreq9 = 0;
                    while ($dataFreq9 = pg_fetch_array($reqFreq9)){
                        $totalFreq9 = $totalFreq9 + $dataFreq9["frequentation"];
                    }
                    //10
					$sqlFreq10 = 'SELECT * FROM "CC" WHERE "date"=\'10/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq10 = pg_query($base ,$sqlFreq10);
                    $totalFreq10 = 0;
                    while ($dataFreq10 = pg_fetch_array($reqFreq10)){
                        $totalFreq10 = $totalFreq10 + $dataFreq10["frequentation"];
                    }
                    //11
					$sqlFreq11 = 'SELECT * FROM "CC" WHERE "date"=\'11/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq11 = pg_query($base ,$sqlFreq11);
                    $totalFreq11 = 0;
                    while ($dataFreq11 = pg_fetch_array($reqFreq11)){
                        $totalFreq11 = $totalFreq11 + $dataFreq11["frequentation"];
                    }
                    					                    //12
					$sqlFreq12 = 'SELECT * FROM "CC" WHERE "date"=\'12/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq12 = pg_query($base ,$sqlFreq12);
                    $totalFreq12 = 0;
                    while ($dataFreq12 = pg_fetch_array($reqFreq12)){
                        $totalFreq12 = $totalFreq12 + $dataFreq12["frequentation"];
                    }
					                    //13
					$sqlFreq13 = 'SELECT * FROM "CC" WHERE "date"=\'13/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq13 = pg_query($base ,$sqlFreq13);
                    $totalFreq13 = 0;
                    while ($dataFreq13 = pg_fetch_array($reqFreq13)){
                        $totalFreq13 = $totalFreq13 + $dataFreq13["frequentation"];
                    }
					                    //14
					$sqlFreq14 = 'SELECT * FROM "CC" WHERE "date"=\'14/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq14 = pg_query($base ,$sqlFreq14);
                    $totalFreq14 = 0;
                    while ($dataFreq14 = pg_fetch_array($reqFreq14)){
                        $totalFreq14 = $totalFreq14 + $dataFreq14["frequentation"];
                    }
					                    //15
					$sqlFreq15 = 'SELECT * FROM "CC" WHERE "date"=\'15/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq15 = pg_query($base ,$sqlFreq15);
                    $totalFreq15 = 0;
                    while ($dataFreq15 = pg_fetch_array($reqFreq15)){
                        $totalFreq15 = $totalFreq15 + $dataFreq15["frequentation"];
                    }
					                    //16
					$sqlFreq16 = 'SELECT * FROM "CC" WHERE "date"=\'16/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq16 = pg_query($base ,$sqlFreq16);
                    $totalFreq16 = 0;
                    while ($dataFreq16 = pg_fetch_array($reqFreq16)){
                        $totalFreq16 = $totalFreq16 + $dataFreq16["frequentation"];
                    }
					                    //17
					$sqlFreq17 = 'SELECT * FROM "CC" WHERE "date"=\'17/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq17 = pg_query($base ,$sqlFreq17);
                    $totalFreq17 = 0;
                    while ($dataFreq17 = pg_fetch_array($reqFreq17)){
                        $totalFreq17 = $totalFreq17 + $dataFreq17["frequentation"];
                    }
					                    //18
					$sqlFreq18 = 'SELECT * FROM "CC" WHERE "date"=\'18/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq18 = pg_query($base ,$sqlFreq18);
                    $totalFreq18 = 0;
                    while ($dataFreq18 = pg_fetch_array($reqFreq18)){
                        $totalFreq18 = $totalFreq18 + $dataFreq18["frequentation"];
                    }
					                    //19
					$sqlFreq19 = 'SELECT * FROM "CC" WHERE "date"=\'19/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq19 = pg_query($base ,$sqlFreq19);
                    $totalFreq19 = 0;
                    while ($dataFreq19 = pg_fetch_array($reqFreq19)){
                        $totalFreq19 = $totalFreq19 + $dataFreq19["frequentation"];
                    }
					                    //20
					$sqlFreq20 = 'SELECT * FROM "CC" WHERE "date"=\'20/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq20 = pg_query($base ,$sqlFreq20);
                    $totalFreq20 = 0;
                    while ($dataFreq20 = pg_fetch_array($reqFreq20)){
                        $totalFreq20 = $totalFreq20 + $dataFreq20["frequentation"];
                    }
					                    //21
					$sqlFreq21 = 'SELECT * FROM "CC" WHERE "date"=\'21/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq21 = pg_query($base ,$sqlFreq21);
                    $totalFreq21 = 0;
                    while ($dataFreq21 = pg_fetch_array($reqFreq21)){
                        $totalFreq21 = $totalFreq21 + $dataFreq21["frequentation"];
                    }
					                    //22
					$sqlFreq22 = 'SELECT * FROM "CC" WHERE "date"=\'22/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq22 = pg_query($base ,$sqlFreq22);
                    $totalFreq22 = 0;
                    while ($dataFreq22 = pg_fetch_array($reqFreq22)){
                        $totalFreq22 = $totalFreq22 + $dataFreq22["frequentation"];
                    }
					                    //23
					$sqlFreq23 = 'SELECT * FROM "CC" WHERE "date"=\'23/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq23 = pg_query($base ,$sqlFreq23);
                    $totalFreq23 = 0;
                    while ($dataFreq23 = pg_fetch_array($reqFreq23)){
                        $totalFreq23 = $totalFreq23 + $dataFreq23["frequentation"];
                    }
					                    //24
					$sqlFreq24 = 'SELECT * FROM "CC" WHERE "date"=\'24/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq24 = pg_query($base ,$sqlFreq24);
                    $totalFreq24 = 0;
                    while ($dataFreq24 = pg_fetch_array($reqFreq24)){
                        $totalFreq24 = $totalFreq24 + $dataFreq24["frequentation"];
                    }
					                    //25
					$sqlFreq25 = 'SELECT * FROM "CC" WHERE "date"=\'25/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq25 = pg_query($base ,$sqlFreq25);
                    $totalFreq25 = 0;
                    while ($dataFreq25 = pg_fetch_array($reqFreq25)){
                        $totalFreq25 = $totalFreq25 + $dataFreq25["frequentation"];
                    }
					                    //26
					$sqlFreq26 = 'SELECT * FROM "CC" WHERE "date"=\'26/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq26 = pg_query($base ,$sqlFreq26);
                    $totalFreq26 = 0;
                    while ($dataFreq26 = pg_fetch_array($reqFreq26)){
                        $totalFreq26 = $totalFreq26 + $dataFreq26["frequentation"];
                    }
					                    //27
					$sqlFreq27 = 'SELECT * FROM "CC" WHERE "date"=\'27/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq27 = pg_query($base ,$sqlFreq27);
                    $totalFreq27 = 0;
                    while ($dataFreq27 = pg_fetch_array($reqFreq27)){
                        $totalFreq27 = $totalFreq27 + $dataFreq27["frequentation"];
                    }
					                    //28
					$sqlFreq28 = 'SELECT * FROM "CC" WHERE "date"=\'28/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                    $reqFreq28 = pg_query($base ,$sqlFreq28);
                    $totalFreq28 = 0;
                    while ($dataFreq28 = pg_fetch_array($reqFreq28)){
                        $totalFreq28 = $totalFreq28 + $dataFreq28["frequentation"];
                    }
					                    //29
	if ($nbmois <> "02"){				
                        $sqlFreq29 = 'SELECT * FROM "CC" WHERE "date"=\'29/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                        $reqFreq29 = pg_query($base ,$sqlFreq29);
                        $totalFreq29 = 0;
                        while ($dataFreq29 = pg_fetch_array($reqFreq29)){
                            $totalFreq29 = $totalFreq29 + $dataFreq29["frequentation"];
                        }
					                        //30
					    $sqlFreq30 = 'SELECT * FROM "CC" WHERE "date"=\'30/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                        $reqFreq30 = pg_query($base ,$sqlFreq30);
                        $totalFreq30 = 0;
                        while ($dataFreq30 = pg_fetch_array($reqFreq30)){
                            $totalFreq30 = $totalFreq30 + $dataFreq30["frequentation"];
                        }
					                        //31
                if (($nbmois <> "04") || ($nbmois <> "06") || ($nbmois <> "09") || ($nbmois <> "11")){
					        $sqlFreq31 = 'SELECT * FROM "CC" WHERE "date"=\'31/'.$nbmois.'/15\' AND "girouette"=\''.$dataLigne["code"].'\'';
                            $reqFreq31 = pg_query($base ,$sqlFreq31);
                            $totalFreq31 = 0;
                            while ($dataFreq31 = pg_fetch_array($reqFreq31)){
                                $totalFreq31 = $totalFreq31 + $dataFreq31["frequentation"]; 
                            }
                        }
					}
                    echo "<tr><th scope='row'>".$dataLigne["num_ligne"]."</th><th scope='row'>".$dataLigne["ligne"]."</th><th scope='row'>".$dataLigne["code"]."</th><th scope='row'>".$dataLigne["code"]."</th><td>".$totalFreq1."</td><td>".$totalFreq2."</td><td>".$totalFreq3."</td><td>".$totalFreq4."</td><td>".$totalFreq5."</td><td>".$totalFreq6."</td><td>".$totalFreq7."</td><td>".$totalFreq8."</td><td>".$totalFreq9."</td><td>".$totalFreq10."</td><td>".$totalFreq11."</td><td>".$totalFreq12."</td><td>".$totalFreq13."</td><td>".$totalFreq14."</td><td>".$totalFreq15."</td><td>".$totalFreq16."</td><td>".$totalFreq17."</td><td>".$totalFreq18."</td><td>".$totalFreq19."</td><td>".$totalFreq20."</td><td>".$totalFreq21."</td><td>".$totalFreq22."</td><td>".$totalFreq23."</td><td>".$totalFreq24."</td><td>".$totalFreq25."</td><td>".$totalFreq26."</td><td>".$totalFreq27."</td><td>".$totalFreq28."</td>";
                   if ($nbmois <> "02"){ 
                    echo "<td>".$totalFreq29."</td>";
                    if (($nbmois <> "04") || ($nbmois <> "06") || ($nbmois <> "09") || ($nbmois <> "11")){
                        echo "<td>".$totalFreq30."</td><td>".$totalFreq31."</td>";
                        }
                   }
                   echo "<tr>";
                }
                echo "</table>";
                }
        ?>
    </body>
</html>
