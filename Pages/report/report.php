<?php
session_start();
 
  include("../../DB-connection/connect_php.php");
  include("../function_log.php");

 $user_data = check_login($conn);

 $dataPoints = array(
	array("label"=> "January", "y"=> 6.0),
	array("label"=> "February", "y"=> 8.5),
	array("label"=> "March", "y"=> 20.6),
	array("label"=> "April", "y"=> 40.4),
	array("label"=> "May", "y"=> 60.9),
	array("label"=> "June", "y"=> 35.8),
	array("label"=> "July", "y"=> 20.5),
	array("label"=> "August", "y"=> 50.5),
	array("label"=> "September", "y"=> 20.3),
	array("label"=> "October", "y"=> 34.9),
	array("label"=> "November", "y"=> 40.8),
    array("label"=> "December", "y"=> 50.8)
);


?>


<!DOCTYPE html>
<html>
 <head>
	<title>Dashboard page</title>
  <link rel="stylesheet" href="report.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2&display=swap" rel="stylesheet">


<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Fund Flow Chart - 2023"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
        yValueFormatString: "#,##0\"%\"",
		indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>


 </head>
 <body>

  <div class="container" id="main-page">
    <div class="menubar">
      
      <!-- ---------------LOGO------------------ -->
      <span class="outer-box">
        <h3 class="trusted">TRUSTED</h3>
        <span class="fund-foundation">
          <h3 class="fund">FUND</h3>
          <h3 class="foundation">FOUNDATION</h3>
      </span></span>
      <!---------------- user details ------------------ -->
      <h3>Welcome <b>[ <?php echo $user_data['user_name'];?> ]</b></h3> 
    </div>
    <nav>
      <div class="menu-list">
        <ul>
          <li><a href="../dashboard/dashboard.php"><i class="uil uil-estate"></i>Home</a></li>
          <li><a href="../customer/customer.php"><i class="uil uil-users-alt"></i>Customer</a></li>
          <li><a href="../Amount/amount.php"><i class="uil uil-usd-circle"></i>Amount</a></li>
          <li><a href="../report/report.php"><i class="uil uil-file-alt"></i>Report</a></li>
        </ul>
      </div>
      <div class="log-out">
        <a href="../Logout.php">Logout<i class="uil uil-signout"></i></a>
      </div>
    </nav>
    <div class="container_1">
      <div class="disp">
      <h1>DASHBOARD</h1>
      </div>
      
<div id="chartContainer" style="height: 370px; width: 100%;"></div>

   <script src="dashboard.js"></script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
 </body>
</html>
