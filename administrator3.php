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
		comp = '$_POST[comp]', emailed = '0',outofstock = '0', returndate = '$_POST[returndate]' WHERE order_id = '$_POST[order]'";
		
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

</map>
</div>

</header>

<body background="BG.png">

<!-- //////////////////////////////////////////////////////                       /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////     ORDER DISPLAY    /////////////////////////////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////                     /////////////////////////////////////////////////////////////// -->

<table class="hoverTable" id="display" align="left" width=100% border="1" cellpadding ="7" cellspacing ="7" text-align:"left" >
<form id="orders_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>

<label for="Admin"><center><h2><b>New Requests</b></h2><center></label>
<thead>
<tr>
<th>Order</th>
<th>First Name</th>
<th>Last Name</th>
<th>Item</th>
<th>Term</th>
<th>Phone Number</th>
<th>Email</th>
</tr>

</thead>
<?php

while ($line = mysql_fetch_assoc($resultopeno_orders)){
echo '<tr onClick="HighLightTR(this);"><td>'.$line['order_id'].'</td><td>'.$line['fname'].'</td><td> '.$line['lname'].'</td><td>'. $line['item'].' </td><td>'.$line['Rental_term'].'</td><td>'.$line['pnumber'].'</td><td>'.$line['email'].'</td></tr>';

}
?>

</table>
<table id="header-fixed"></table>
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


<table id="table-1">
    <thead>
        <tr>
            <th>Col1</th>
            <th>Col2</th>
            <th>Col3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>info</td>
            <td>info</td>
            <td>info</td>
        </tr>
        <tr>
            <td>info</td>
            <td>info</td>
            <td>info</td>
        </tr>
        <tr>
            <td>info</td>
            <td>info</td>
            <td>info</td>
        </tr>
    </tbody>
</table>
<table id="header-fixed"></table>





</body>





</html>