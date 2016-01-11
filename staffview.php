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
require 'dbconfig.php';
//Enter Item Inquiries for available items
$mac = "select serial_number from inventory where item like'Mackbook' and rented=0";
$mactotal = mysql_query($mac,$dblink);
$ipad = "select serial_number from inventory where item like'ipad' and rented=0";
$ipadtotal = mysql_query($ipad,$dblink);
$hp = "select serial_number from inventory where item like'HP Laptop' and rented=0";
$hptotal = mysql_query($hp,$dblink);
$sony = "select serial_number from inventory where item like'sony camcorder' and rented=0";
$sonytotal = mysql_query($sony,$dblink);
$clicker = "select serial_number from inventory where item like'clicker' and rented=0";
$clickertotal = mysql_query($clicker,$dblink);
$kodak = "select serial_number from inventory where item like'kodak' and rented=0";
$kodaktotal = mysql_query($kodak,$dblink);
$ti89 = "select serial_number from inventory where item like'ti89' and rented=0";
$ti89total = mysql_query($ti89,$dblink);
$scalc = "select serial_number from inventory where item like'scalc' and rented=0";
$scalctotal = mysql_query($scalc,$dblink);
$bcalc = "select serial_number from inventory where item like'bcalc' and rented=0";
$bcalctotal = mysql_query($bcalc,$dblink);
$tripod = "select serial_number from inventory where item like'tripod' and rented=0";
$tripodtotal = mysql_query($tripod,$dblink);
$projector = "select serial_number from inventory where item like'projector' and rented=0";
$projectortotal = mysql_query($projector,$dblink);
$wacom = "select serial_number from inventory where item like'wacom' and rented=0";
$wacomtotal = mysql_query($wacom,$dblink);
$livescribe = "select serial_number from inventory where item like'livescribe' and rented=0";
$livescribetotal = mysql_query($livescribe,$dblink);
$nikon = "select serial_number from inventory where item like'nikon' and rented=0";
$nikontotal = mysql_query($nikon,$dblink);
$canon = "select serial_number from inventory where item like'canon' and rented=0";
$canontotal = mysql_query($canon,$dblink);
$canondslr = "select serial_number from inventory where item like'canondslr' and rented=0";
$canondslrtotal = mysql_query($canondslr,$dblink);
$clickerclass = "select serial_number from inventory where item like'clickerclass' and rented=0";
$clickerclasstotal = mysql_query($clickerclass,$dblink);
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
//staff orders
$stafforders = "select * from orders where staff='1' and returned=1 or staff='1' and checkedout=1 ";
$staffall_orders= mysql_query($stafforders,$dblink);
//mac orders
$macorders = "select * from orders where item like'Macbook' and returned=1 or checkedout=1 ";
$macall_orders= mysql_query($macorders,$dblink);
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
		comp = '$_POST[comp]', emailed = '0', returndate = '$_POST[returndate]' WHERE order_id = '$_POST[order]'";
		
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

		$result = "UPDATE orders SET active = '1', returned = '1', checkedout = '0' WHERE order_id = '$_POST[order]'";
	
		
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

		$result = "UPDATE orders SET active = '1', emailed = '1' WHERE order_id = '$_POST[order]'";
	
		
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

		$result = "UPDATE orders SET active = '1', emailed = '0', scheduled = '1', appointment = '$_POST[date]' WHERE order_id = '$_POST[order]'";
	
		
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

</map>
</div>

</header>

<body background="BG.png">
<!-- /////////////////////////////////     Menu      /////////////////////////////////////// -->

<div class="fixmenu">
<div id='cssmenu' align='center'>
<ul>
<li class='active'><a href='administrator.php'><span><img src="TROtter.png" "100" width="100"> </li>
 <li class='has-sub'><a href='#'><span>TR Orders</span></a>
      <ul>
   <li><a href='administrator.php'><span>Newest Orders</span></a></li>
   <li><a href='emailed.php'><span>Emailed Orders</span></a></li>
   <li><a href='Scheduled.php'><span>Scheduled Orders</span></a></li>
   <li><a href='checkedout.php'><span>Checked Out Orders</span></a></li>
   <li><a href='Rented.php'><span>Returned Orders</span></a></li>
   <li><a href='superpanel.php'><span>Super Panel</span></a></li>
      </ul>
   <li class='has-sub'><a href='#'><span>Product Views</span></a>
      <ul>
         <li><a href='#'><span>MacBooks</span></a></li>
         <li><a href='#'><span>iPads</span></a></li>
         <li><a href='#'><span>HP Laptops</span></a></li>
         <li><a href='#'><span>Clickers</span></a></li>
         <li><a href='#'><span>Canon DSLR</span></a></li>
         <li><a href='#'><span>Canon Camcorder</span></a></li>
         <li><a href='#'><span>Sony Camcorder</span></a></li>
         <li><a href='#'><span>Nikon Camera</span></a></li>
         <li><a href='#'><span>Tripod</span></a></li>
         <li><a href='#'><span>Live Scribe</span></a></li>
         <li><a href='#'><span>Wacom tablet</span></a></li>
         <li><a href='#'><span>Kodak Pocket Cam</span></a></li>
         <li><a href='#'><span>Business Calc</span></a></li>
         <li><a href='#'><span>Ti89 Calc</span></a></li>
         <li><a href='#'><span>Scientific Calc</span></a></li>
         <li><a href='#'><span>Projector</span></a></li>
         <li class='last'><a href='#'><span>Clicker Class Set</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Specific Views</span></a>
      <ul>
         <li><a href='#'><span>COMPS</span></a></li>
         <li class='last'><a href='#'><span>Staff and Faculty</span></a></li>
      </ul>
      
   </li>
    <li class='last'><a href='index.php'><span>Request Form</span></a></li>
    <li class='has-sub'><a href='#' onclick='location.reload(true); return false;'><span>View Changes</span></a>
    
   </li>
  
   <li class='has-sub'><a href='#'><span>Google Calendar</span></a>
      <ul>
         <li class='last'><a href='#'><span><iframe src="https://www.google.com/calendar/embed?src=otter.techrent%40gmail.com&ctz=America/Los_Angeles" style="border: 0" width="450" height="200" frameborder="0" scrolling="no"></iframe></span></a></li>
      </ul>
   </li>
</ul>
</div>

<!-- /////////////////////////////////                        /////////////////////////////////////// -->
<!-- /////////////////////////////////     Inventory Live    /////////////////////////////////////// -->
<!-- /////////////////////////////////                      /////////////////////////////////////// -->

<div id='cssmenu' align='center'>
<ul>
<li class='active'><a href='administrator.php'><span> |INVENTORY|</span></a></li>

     
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
<!-- /////////////////////////////////     ORDER DISPLAY    /////////////////////////////////////// -->
<div class="orders">
<table align="left" width=100% border="3" cellpadding ="7" cellspacing ="7" text-align:"left">
<form id="orders_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="left">
<label for="Admin" align ="bottom"><h2><b>STAFF and FACULTY ORDERS:</b></h2></b></label></div>

<th>
<?php

while ($line = mysql_fetch_assoc($staffall_orders)){
echo '<u>Order:</u>'.$line['order_id'].' <u>First Name: </u>'.$line['fname'].'  <u>Last Name: </u>'.$line['lname'].'   <u>Item:</u> '. $line['item'].' <u>Rental Request:</u> '.$line['Rental_term'].'
	<u>otter ID:</u> '.$line['otterid'].' <u>Email: </u>'.$line['email'].'<u>Phone Number: </u>'.$line['pnumber'].'<u>Item Rented: </u>'.$line['item'].'<u> Amount Paid : </u>'.$line['amtPaid'].'<u>Item Returned: </u>'.$line['returned'].'Serial Rented: </u>'.$line['serialnumber'].' <br/> <br/>';
}
?>
</th>
</table>
</form>
</div>
<!-- /////////////////////////////////     Status Label     /////////////////////////////////////// -->
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

<!-- /////////////////////////////////     Pick Up Tool     /////////////////////////////////////// -->
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
<?= ((!empty($date)) ? '<div class="error">' : '') ?><label for = "date">Appt: </label><input type="text" name="date" size="15" maxlength="40">
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
<?= ((!empty($amount)) ? '<div class="error">' : '') ?><label for = "amount">Amount Paid:</label><input type="text" name="amount" size="8" maxlength="40"><br>
<label for = "comp">Was this comp?</label>
<select name="comp">
<option value ="0">No</option>
<option value ="1">Yes</option>
</select>
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







</body>





</html>