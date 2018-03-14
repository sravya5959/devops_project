<!-- need phpseclib installed-->
<?php
$ip = $_POST['ip'];
$uname = $_POST['uname'];
$pass = $_POST['psw'];
set_include_path('phpseclib');
include('Net/SSH2.php');

$ssh = new Net_SSH2($ip);
if (!$ssh->login($uname, $pass)) {
    exit('Login Failed');
}
else
{
?>	
<!DOCTYPE html>
<html>
<title>online stats</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Logo</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
   
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
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
    
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
   
      <div class="w3-twothird">
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
          
            <td>CPU USED</td>
            <td><i><?php 
			
			echo  $ssh->exec('grep \'cpu \' /proc/stat | awk \'{usage=($2+$4)*100/($2+$4+$5)} END {print usage "%"}\'');
			?></i></td>
          </tr>
          <tr>
          
            <td>MEMORY LEFT</td>
            <td><i><?php 
			 echo $ssh->exec('cat /proc/meminfo | grep MemFree');
			?></i></td>
          </tr>
          <tr>
           
            <td>DISK SPACE LEFT</td>
            <td><i><?php 
			 echo $ssh->exec("df --output=avail | awk '{n += $1}; END{print n }'");
			 echo "kB";
			?></i></td>
          </tr>
         
        </table>
      </div>
    </div>
  </div>
  <hr>
 
  <!-- End page content -->
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
