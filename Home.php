<?php include("password_protect.php"); ?>
<!DOCTYPE html>
<html>

<style type="text/css" media="screen">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,600,300);
html *
{
  font-family: 'Open Sans', sans-serif; !important;
  
}


</style>



<?php
require 'dbconfig_BlipWip.php';

//Test 
$new = "select LocationID from Host where New=0";
$newHost = mysql_query($new,$dblink);

//For rented Items
$rentmac = "select serial_number from inventory where item like'Mackbook' and rented=1";
$rentmactotal = mysql_query($rentmac,$dblink);
$rentipad = "select serial_number from inventory where item like'ipad' and rented=1";
$rentipadtotal = mysql_query($rentipad,$dblink);
$renthp = "select serial_number from inventory where item like'HP Laptop' and rented=1";
$renthptotal = mysql_query($renthp,$dblink);

//functions to select entries from DB to view
//new orders
$openorders = "select * from orders where active=0";
$resultopeno_orders= mysql_query($openorders,$dblink);
//rented/checkedout
$rentedorders = "select * from orders where checkedout=1";
$resultrented_orders= mysql_query($rentedorders,$dblink);
//emailed
$emailedorders = "select * from orders where emailed=1";
$resultemailed_orders= mysql_query($emailedorders,$dblink);
//returned
$returnedorders = "select * from orders where returned=1";
$resultreturned_orders= mysql_query($returnedorders,$dblink);
//view scheduled function
$scheduledorders = "select * from orders where scheduled=1";
$resultscheduled_orders= mysql_query($scheduledorders,$dblink);
//all orders
$allorders = "select * from orders";
$resultall_orders= mysql_query($allorders,$dblink);
////////////////////////  Check Out Function //////////////////////////////////
if(isset($_POST['update'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	if(empty($_POST["serial"])){
		$Error .= "<li>Missing Serial Number!</li>";
		$usrnamebad = 1;
	}
	if(empty($_POST["amount"])){
		$Error .= "<li>Missing Amount!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders set amtPaid= '$_POST[amount]', serialnumber = '$_POST[serial]', active = '1', checkedout = '1', scheduled = '0', 
		comp = '$_POST[comp]', emailed = '0',outofstock = '0', returndate = '$_POST[returndate]', dateout = '$_POST[outdate]'WHERE order_id = '$_POST[order]'";
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
}
////////////////////////  Return Function //////////////////////////////////
if(isset($_POST['return'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	if(empty($_POST["serial"])){
		$Error .= "<li>Missing Serial Number!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders SET active = '1', returned = '1', checkedout = '0', outofstock = '0' WHERE order_id = '$_POST[order]'";
	
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		$result2 = "UPDATE inventory SET rented = '0' WHERE serial_number = '$_POST[serial]'";
		
		if (!mysql_query($result2,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
}
////////////////////////  emailed function  //////////////////////////////////
if(isset($_POST['emailed'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders SET active = '1', emailed = '1',outofstock = '0' WHERE order_id = '$_POST[order]'";
	
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
	
}
////////////////////////  outofstock function  //////////////////////////////////
if(isset($_POST['outofstock'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders SET active = '1', outofstock = '1', emailed = '0' WHERE order_id = '$_POST[order]'";
	
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
	
}
////////////////////////  Late Fee Function  //////////////////////////////////
if(isset($_POST['latefee'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	if(empty($_POST["latefeeamount"])){
		$Error .= "<li>Missing FEE!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders SET latefee= '$_POST[latefeeamount]' WHERE order_id = '$_POST[order]'";
	
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
	
}
////////////////////////  scheduled function //////////////////////////////////
if(isset($_POST['scheduled'])){
	$Error= "";
	
	if(empty($_POST["order"])){
		$Error .= "<li>Missing Order Number!</li>";
		$usrnamebad = 1;
	}
	
	
	if(empty($Error)){
		
		if(!$dblink)
			{
				die('Could not connect: '. mysql_error());
			}

		$result = "UPDATE orders SET active = '1', emailed = '0', outofstock = '0', scheduled = '1', appointment = '$_POST[date]' WHERE order_id = '$_POST[order]'";
	
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		
		
		mysql_close($dblink);
		
		header('Location: administrator.php');
		
	

	}
	else {
		echo '<br /> Information missing: <ul>'.$Error. '</ul>';
	}
}

	$disp_fname  = isset($_POST['fname'])?$_POST['fname']:'';
	$disp_lname  = isset($_POST['lname'])?$_POST['lname']:'';
	$disp_email  = isset($_POST['email'])?$_POST['email']:'';
	$disp_otter  = isset($_POST['otter'])?$_POST['otter']:'';
?>

<header>
   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="http://www.techboymonterey.com/mike/styles.css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="http://www.techboymonterey.com/mike/script.js"></script>

	<link rel="shortcut icon" type="image/ico" href="icon.png">


</map>
</div>

</header>

<body background="BG.png">
<!-- /////////////////////////////////                      /////////////////////////////////////// -->
<!-- /////////////////////////////////         Menu         /////////////////////////////////////// -->
<!-- /////////////////////////////////                      /////////////////////////////////////// -->

<div class="fixmenu">
<div id='cssmenu' align='center'>
<ul>
<li class='active'><a href='administrator.php'><span><img src="TROtter.png" "100" width="100"> </li>
 <li class='has-sub'><a href='#'><span>TR Orders</span></a>
      <ul>
   <li><a href='administrator.php'><span>Newest Orders</span></a></li>
   <li><a href='emailed.php'><span>Emailed Orders</span></a></li>
   <li><a href='outofstock.php'><span>Out of Stock Orders</span></a></li>
   <li><a href='Scheduled.php'><span>Scheduled Orders</span></a></li>
   <li><a href='checkedout.php'><span>Checked Out Orders</span></a></li>
   <li><a href='Rented.php'><span>Returned Orders</span></a></li>
   <li><a href='superpanel.php'><span>Super Panel</span></a></li>
      </ul>
   <li class='has-sub'><a href='#'><span>Product Views</span></a>
      <ul>
         <li><a href='macview.php'><span>MacBooks</span></a></li>
         <li><a href='ipadview.php'><span>iPads</span></a></li>
         <li><a href='hpview.php'><span>HP Laptops</span></a></li>
         <li><a href='clickerview.php'><span>Clickers</span></a></li>
         <li><a href='dslrview.php'><span>Canon DSLR</span></a></li>
         <li><a href='canonview.php'><span>Canon Camcorder</span></a></li>
         <li><a href='sonyview.php'><span>Sony Camcorder</span></a></li>
         <li><a href='nikonview.php'><span>Nikon Camera</span></a></li>
         <li><a href='tripodview.php'><span>Tripod</span></a></li>
         <li><a href='livescribeview.php'><span>Live Scribe</span></a></li>
         <li><a href='wacomview.php'><span>Wacom tablet</span></a></li>
         <li><a href='kodakview.php'><span>Kodak Pocket Cam</span></a></li>
         <li><a href='bcalcview.php'><span>Business Calc</span></a></li>
         <li><a href='ti89view.php'><span>Ti89 Calc</span></a></li>
         <li><a href='scalcview.php'><span>Scientific Calc</span></a></li>
         <li><a href='projector.php'><span>Projector</span></a></li>
         <li class='last'><a href='clickerclassview.php'><span>Clicker Class Set</span></a></li>
      </ul>
   </li>
      <li class='has-sub'><a href='#'><span>Google Calendar</span></a>
      <ul>
         <li class='last'><a href='#'><span><iframe src="https://www.google.com/calendar/embed?src=otter.techrent%40gmail.com&ctz=America/Los_Angeles" style="border: 0" width="450" height="200" frameborder="0" scrolling="no"></iframe></span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Specific Views</span></a>
      <ul>
         <li><a href='compsview.php'><span>COMPS</span></a></li>
         <li class='last'><a href='staffview.php'><span>Staff and Faculty</span></a></li>
      </ul>
      
   </li>
    <li class='last'><a href='index.php'><span>Request Form</span></a></li>
    <li class='last'><a href='#' onclick='location.reload(true); return false;'><span>View Changes</span></a>
    
   </li>
  

</ul>
</div>

<!-- /////////////////////////////////                        /////////////////////////////////////// -->
<!-- /////////////////////////////////     Live Inventory    /////////////////////////////////////// -->
<!-- /////////////////////////////////                      /////////////////////////////////////// -->

<div id='cssmenu' align='center'>
<ul>
<li class='active'><a href='administrator.php'><span> |INVENTORY|</span></a></li>

<!-- ///////////////////////////////////////   Mac Books /////////////////////////////////////////      -->      
<li class='has-sub'><a href='#'><span>MacBook</span></a>
<ul>
<li class='last'><a href='#'><span><?php

echo'
<div align="center">
Macbook:';
while ($line = mysql_fetch_assoc($mactotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////   HP Laptops /////////////////////////////////////////      --> 
   <li class='has-sub'><a href='#'><span>HP</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
HP Laptop:';
while ($line = mysql_fetch_assoc($hptotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  iPad  /////////////////////////////////////////      --> 
 <li class='has-sub'><a href='#'><span>iPad</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
iPad:';
while ($line = mysql_fetch_assoc($ipadtotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Clicker  /////////////////////////////////////////      --> 
<li class='has-sub'><a href='#'><span>Clicker</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Clicker:';
while ($line = mysql_fetch_assoc($clickertotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Kodak  /////////////////////////////////////////      --> 
   <li class='has-sub'><a href='#'><span>Kodak</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Kodak Pocket Cam:';
while ($line = mysql_fetch_assoc($kodaktotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Canon DSLR    /////////////////////////////////////////      --> 
   <li class='has-sub'><a href='#'><span>DSLR</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Canon DSLR:';
while ($line = mysql_fetch_assoc($canondslrtotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Canon Video Camera /////////////////////////////////////////      --> 
  <li class='has-sub'><a href='#'><span>Canon Video</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Canon Video Camera:';
while ($line = mysql_fetch_assoc($canontotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Sony Video Camera    /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Sony Video</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Sony Video Camera:';
while ($line = mysql_fetch_assoc($sonytotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Nikon Camera   /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Nikon</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Nikon Digital Camera:';
while ($line = mysql_fetch_assoc($nikontotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Tripod    /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Tripod</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Tripod:';
while ($line = mysql_fetch_assoc($tripodtotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////  Business Caclculator  /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Bus.Calc</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Business Calculator:';
while ($line = mysql_fetch_assoc($bcalctotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////   Scientific Calc /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Sci.Calc</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Scientific Calculator:';
while ($line = mysql_fetch_assoc($scalctotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////   Ti89  /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>TI89</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
TI 89 Calculator:';
while ($line = mysql_fetch_assoc($ti89total)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
   
<!-- ///////////////////////////////////////   Live Scribe /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>LiveScribe</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Live Scribe Pen:';
while ($line = mysql_fetch_assoc($livescribetotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
 <!-- ///////////////////////////////////////   Wacom   /////////////////////////////////////////      --> 
     <li class='has-sub'><a href='#'><span>Wacom</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Wacom Tablet:';
while ($line = mysql_fetch_assoc($wacomtotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
<!-- ///////////////////////////////////////   Clicker set /////////////////////////////////////////      --> 
 <li class='has-sub'><a href='#'><span>Clickerset</span></a>
      <ul>
         <li class='last'><a href='#'><span><?php

echo'
<div align="center">
Clicker Class Set:';
while ($line = mysql_fetch_assoc($clickerclasstotal)){
echo' </br>
'.$line['serial_number'].'';
}'</div>';
?></span></a></li>
      </ul>
   </li>
    
   
</div>
</div>
<br><br><br><br><br><br><br>
<!-- //////////////////////////////////////////////////////                       /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////     ORDER DISPLAY    /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////                     /////////////////////////////////////////////////////////////// -->

<table class="hoverTable" id="display" align="left" width=100% border="1" cellpadding ="7" cellspacing ="7" text-align:"left" >
<form id="orders_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>

<label for="Admin"><center><h2><b> BLIPS </b></h2><center></label>

<th>Order</th>
<th>First Name</th>
<th>Last Name</th>
<th>Item</th>
<th>Term</th>
<th>Phone Number</th>
<th>Email</th>
<th>Requested Pick Up</th>

<?php

while ($line = mysql_fetch_assoc($newHost)){
echo '<tr onClick="HighLightTR(this);"><td>'.$line['Date'].'</td><td>'.$line['Venue'].'</td><td> '.$line['Address'].'</td><td>'. $line['City'].' </td><td>'.$line['State'].'</td><td>'.$line['Price'].'</td></tr>';

}
?>

</table>
</div>
</form>
</div>
<!-- //////////////////////////////////////////////////////                            /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////     Change Status Tools   /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////                          /////////////////////////////////////////////////////////////// -->

<!-- /////////////////////////////////     Status Tool Label     /////////////////////////////////////// -->
<div class="status">
<h3>Status Tools</h3>
</div>

<!-- /////////////////////////////////     Emailed Tool     /////////////////////////////////////// -->
</div>
<div class="tools">
<div class="panel">
  <h2>Emailed </h2>
  <div class="panelcontent">
    <table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="emailed_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="left">
</div>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order: </label><input type="text" name="order" size="8" maxlength="40">
</div>
<div align="center">
<input name="emailed" type="submit" value="Change Status " >
</table>
</div>
</form>
  </div>
</div>

</div>
<!-- /////////////////////////////////     Out of Stock Tool     /////////////////////////////////////// -->
<div class="tools5">
<div class="panel">
  <h2>Out of Stock</h2>
  <div class="panelcontent">
	<table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="outofstock_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="right">
</div>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order:</label><input type="text" name="order" size="8" maxlength="40"><br>

<br>

<div align="center">

<input name="outofstock" type="submit" value="Set" >


</table>
</div>
</form>

</div>
</div>

<!-- /////////////////////////////////    Schedule Pick Up     /////////////////////////////////////// -->
<div class="tools2">
<div class="panel">
  <h2>Set Pick Up Date</h2>
  <div class="panelcontent">
	<table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="return_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="right">
</div>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order: </label><input type="text" name="order" size="8" maxlength="40"><br>
<?= ((!empty($date)) ? '<div class="error">' : '') ?><label for = "date">Appt Date and Time: </label><input type="text" name="date" size="15" maxlength="60">
</div>
<div align="center">
<input name="scheduled" type="submit" value="Set APPT" >
</div>
</table>
</div>
</form>
</table>
  </div>
</div>

<!-- /////////////////////////////////    Check Out TOOL     /////////////////////////////////////// -->
<div class="tools3">
<div class="panel">
  <h2>Check Out</h2>
  <div class="panelcontent">
	<table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="update_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="right">
</div>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order:</label><input type="text" name="order" size="8" maxlength="40"><br>
<?= ((!empty($serial)) ? '<div class="error">' : '') ?><label for = "serial">Serial #:</label><input type="text" name="serial" size="15" maxlength="40">
<br>
<label for = "amount">Amount Paid:</label><input type="text" name="amount" size="8" maxlength="40"><br>
<label for = "comp">Was this comp?</label>
<select name="comp">
<option value ="0">No</option>
<option value ="1">Yes</option>
</select>
<br>
<?= ((!empty($outdate)) ? '<div class="error">' : '') ?><label for = "outdate">Date Out:</label><input type="text" name="outdate" size="8" maxlength="40">
<br>
<?= ((!empty($returndate)) ? '<div class="error">' : '') ?><label for = "returndate">Due Back:</label><input type="text" name="returndate" size="8" maxlength="40">
</div>
<div align="center">

<input name="update" type="submit" value="Checkout" >


</table>
</div>
</form>

</div>
</div>



<!-- /////////////////////////////////     Return Tool       /////////////////////////////////////// -->
<div class="tools4">
<div class="panel">
  <h2>Return</h2>
  <div class="panelcontent">
	<table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="return_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order:</label><input type="text" name="order" size="8" maxlength="40">
<br>
<?= ((!empty($serial)) ? '<div class="error">' : '') ?><label for = "serial">Serial #:</label><input type="text" name="serial" size="15" maxlength="40">
</div>
<div align="center">
<input name="return" type="submit" value="Return" >


</table>
</div>
</form>

</div>
</div>

<!-- /////////////////////////////////    Add Late FEE     /////////////////////////////////////// -->
<div class="tools6">
<div class="panel">
  <h2>Late Fee</h2>
  <div class="panelcontent">
	<table align="right" width="450" border="3" cellpadding ="5" cellspacing ="5">
<form id="latefee_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="right">
</div>
<br>
<div align="left">
<?= ((!empty($order)) ? '<div class="error">' : '') ?><label for = "order">Order:</label><input type="text" name="order" size="8" maxlength="40"><br>
<br>
<label for = "latefeeamount">Amount Late Fee Paid:</label><input type="text" name="latefeeamount" size="8" maxlength="40"><br>
<br>
</div>
<div align="center">

<input name="latefee" type="submit" value="Add Late Fee" >


</table>
</div>
</form>

</div>
</div>





</body>





</html>