<?php
session_start();
$ip = $_POST['ip'];
$uname = $_POST['uname'];
$pass = $_POST['psw'];
$_SESSION['ip']=$ip;
$_SESSION['uname']=$uname;
$_SESSION['pass']=$pass;
set_include_path('phpseclib');
include('Net/SSH2.php');

$ssh = new Net_SSH2($ip);
if (!$ssh->login($uname, $pass)) {
    exit('Login Failed');
}
else
{
	require_once('hicounter.php');
?>
<!DOCTYPE html>
<html>
<head>
<title>online stats</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}

</style>
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">HARVEY</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
    <!--  <img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px"> -->
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo $uname;?></strong></span><br>

    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="term.php" class="w3-bar-item w3-button w3-padding"  target="_blank"><i class="fa fa-users fa-fw"></i>  TERMINAL</a>
    <a href=<?php echo "http://$ip:6080/vnc.html?host=$ip&port=6080";?> class="w3-bar-item w3-button w3-padding"  target="_blank"><i class="fa fa-users fa-fw"></i>  GUI</a>
	<a href="logout.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  LOGOUT</a>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>


  <div class="w3-panel">
    <div class="w3-row-padding" style="margin:0 -16px">


	<script>
	window.onload = function () {

var dps = []; // dataPoints
var chart = new CanvasJS.Chart("chartContainer", {
	title :{
		text: "CPU STATS"
	},
	axisY: {
		includeZero: false
	},
	data: [{
		type: "line",
		dataPoints: dps
	}]
});
var dps2 = []; // dataPoints
var chart2 = new CanvasJS.Chart("chartContainer2", {
	title :{
		text: "MEMORY STATS"
	},
	axisY: {
		includeZero: false
	},
	data: [{
		type: "line",
		dataPoints: dps2
	}]
});
var xVal = 0;
var yVal = 10;
var updateInterval = 1000;
var dataLength = 20; // number of dataPoints visible at any point

var updateChart = function (count) {

	count = count || 1;

	for (var j = 0; j < count; j++) {

		yVal=0;
		yVal = yVal +  <?php echo $ssh->exec('grep \'cpu \' /proc/stat | awk \'{usage=($2+$4)*100/($2+$4+$5)} END {print usage}\'');?>;
		dps.push({
			x: xVal,
			y: yVal
		});
		xVal++;
	}

	if (dps.length > dataLength) {
		dps.shift();
	}

	chart.render();
};
var updateChart2 = function (count) {

	count = count || 1;

	for (var j = 0; j < count; j++) {

		yVal=0;
		yVal = yVal +  <?php echo $ssh->exec('free -m | awk \'NR==2{printf "%.2f", $3*100/$2 }\'');?>;
		dps2.push({
			x: xVal,
			y: yVal
		});
		xVal++;
	}

	if (dps2.length > dataLength) {
		dps2.shift();
	}

	chart2.render();
};
updateChart(dataLength);
setInterval(function(){updateChart()}, updateInterval);
updateChart2(dataLength);
setInterval(function(){updateChart2()}, updateInterval);

}
	</script>




      <div class="w3-half">

        <h5>Feeds</h5>
        <table class="w3-table w3-striped w3-white">

          <tr>

            <td>HOSTNAME</td>

            <td><i><?php
			 echo $ssh->exec('hostname');
			?></i></td>
          </tr>
          <tr>

            <td>NUMBER OF USERS LOGGED IN</td>
            <td><i><?php
			 echo $ssh->exec('users | wc -w');
			?></i></td>
          </tr>
          <tr>

            <td>SYSTEM UPTIME</td>
            <td><i><?php
			echo $ssh->exec('uptime');
			?></i></td>
          </tr>

          <tr>

            <td>DISK SPACE LEFT</td>
            <td><i><?php
			 echo $ssh->exec("df --output=avail | awk '{n += $1}; END{print n }'");
			 echo "kB";
			?></i></td>
          </tr>


		<tr>
		<td>SERVICES UP</td>
		<td><i><?php
			 echo $ssh->exec("service --status-all | grep [+] ");
			?></i></td>
		</tr>
		<tr>
		<td>SERVICES DOWN</td>
		<td><i><?php
			 echo $ssh->exec("service --status-all | grep -v [+] ");

			?></i></td>
		</tr>
		</table>
      </div>
	  <div class="w3-third">
		<table>
		<tr>
				<td>
				<div id="chartContainer" style="height: 300px; width:30%;"></div>
				<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				</td>
		</tr>
		<tr>
				<td>
				<div id="chartContainer2" style="height: 300px; width:30%;"></div>
				<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				</td>
		</tr>
		</table>

	  </div>
    </div>
  </div>
  <hr>

</div>


<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}


</script>



<?php

}

?>

</body>
</html>
