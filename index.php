<html>
<style type="text/css" media="screen">
@import url(http://fonts.googleapis.com/css?family=Open+Sans:400,600,300);
html *
{
  font-family: 'Open Sans', sans-serif; !important;
  
}

.button-warning {
            background: rgb(223, 117, 20); /* this is an orange */
        }



</style>


<?php
require 'dbconfig.php';

if(!empty($_POST)){
	$Error= "";
	if(empty($_POST["fname"])){
		$Error .= "<li>Missing First Name!</li>";
		$usrnamebad = 1;
	}
	if(empty($_POST["lname"])){
		$Error .= "<li>Missing Last Name!</li>";
		$usrnamebad = 1;
	}
	
	if(empty($_POST["email"])){
		$Error .= "<li>Missing Email!</li>";
		$emailbad = 1;
	}
	
	if(empty($_POST["otter"])){
		$Error .= "<li>Missing Otter ID!</li>";
		$emailbad = 1;
	}
	
	if(empty($_POST["phone"])){
		$Error .= "<li>Missing Phone Number!</li>";
		$phonebad = 1;
	}
	if(empty($_POST["item"])){
		$Error .= "<li>Missing Item!</li>";
		$itembad = 1;
	}
	if(empty($_POST["course"])){
		$Error .= "<li>Missing Course!</li>";
		$coursebad = 1;
	}
	if(empty($_POST["instructor"])){
		$Error .= "<li>Missing Instructor NA is OK!</li>";
		$instructorbad = 1;
	}
	if(empty($_POST["rent"])){
		$Error .= "<li>Missing Rental Term!</li>";
		$termbad = 1;
	}
	if(empty($_POST["desired"])){
		$Error .= "<li>Desired Pick Up!</li>";
		$desiredbad = 1;
	}
	

	
	
	if(empty($Error)){
		
		if(!$dblink)
			{	
				die('Could not connect: '. mysql_error());
			}
		$result = "INSERT INTO customers(otter_id, fname, lname, email, pnumber, instructor_name, course, faculty) 
		VALUES ('$_POST[otter]','$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[phone]','$_POST[instructor]','$_POST[course]','$_POST[faculty]')";
		
		$redirect = header('Location:thankyou.php');
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		$result2 = "INSERT INTO orders(fname,lname,item, Rental_term, comp, otterid, active, email, pnumber, staff,desired)
		VALUES('$_POST[fname]','$_POST[lname]','$_POST[item]','$_POST[rent]',0,'$_POST[otter]', 0, '$_POST[email]','$_POST[phone]','$_POST[faculty]','$_POST[desired]')" ;
		
		header('Location:thankyou.php');
		
		if (mysql_query($result,$dblink))
		{
		$Success .= "<li>You Have Submitted Your Request!</li>";
		}
	
		
		if (!mysql_query($result2,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		

	    
		mysql_close($dblink);
		echo '<center><h1> You Have Successfully Entered Your Rental Request!</h1>
	<br><h1> <a href="https://store.csumb.edu/tech-rent"><img src="clicktopay.png"></a><br><br><img src="complete.png" ><br><br></tr></h1><br><br><br><br><br><br>
	<h1>You Have Submitted Your Request!!! <bold>Do Not<bold>Fill Out the Reqeust Form Again.</h1></center></center';

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
<link rel="stylesheet" href="http://www.techboymonterey.com/mike/styles.css">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">


</header>

<body background="BG1.png" bgproperties="fixed">


<table align="center" width="550" border="3">
<form id="rent_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="center">
<label for="Rent Form"><b><h3>Rental Request Form</h3></bold></label>
<h4> Do not leave any fields empty, use N/A for not applicable. </h4>

 </div>
<th>
<div align="left">
<br/>
<?= ((!empty($fnamebad)) ? '<div class="error">' : '') ?><label for = "fname">First Name:</label><input type="text" name="fname" size="25" maxlength="40" value='<?php echo htmlentities($disp_fname) ?>'>
<br /><br/>
<?= ((!empty($lnamebad)) ? '<div class="error">' : '') ?><label for = "lname">Last Name:</label><input type="text" name="lname" size="25" maxlength="40" value='<?php echo htmlentities($disp_lname) ?>'>
<br /><br/>
<?= ((!empty($emailbad)) ? '<div class="error">' : '') ?><label for = "email">Email Address:</label><input type="text" name="email" size="25" maxlength="40" value='<?php echo htmlentities($disp_email) ?>'>
<br /><br/>
<?= ((!empty($otterbad)) ? '<div class="error">' : '') ?><label for = "otter">Otter Id:</label><input type="text" name="otter" size="25" maxlength="40" value='<?php echo htmlentities($disp_otter) ?>'>
<br /><br/>
<?= ((!empty($phonebad)) ? '<div class="error">' : '') ?><label for = "phone">Phone #: </label><input type="text" name="phone" size="25" maxlength="40">
<br /><br/>
<?= ((!empty($coursebad)) ? '<div class="error">' : '') ?><label for = "course">Course Name: </label><input type="text" name="course" size="25" maxlength="40">
<br /><br/>
<?= ((!empty($instructorbad)) ? '<div class="error">' : '') ?><label for = "instructor">Instructor Name: </label><input type="text" name="instructor" size="25" maxlength="40">
<br /><br/>

<label for = "faculty">Are you an instructor or staff?</label>
<select name="faculty">
<option value ="0">No</option>
<option value ="1">Yes</option>
</select>




<br/><br/>
<?= ((!empty($itembad)) ? '<div class="error">' : '') ?><label for ="item">Which item would you like to rent?</label>
<select name="item">
<option value =""></option>
<option value ="Macbook">MacBook</option>
<option value ="ipad">iPad</option>
<option value ="hp_laptop">HP Laptop</option>
<option value ="kodak">Kodak Pocket Video Camera</option>
<option value ="clicker">Clicker</option>
<option value ="sony camcorder">Sony Video Camera</option>
<option value ="canon">Canon Video Camera</option>
<option value ="canondslr">Canon DSLR</option>
<option value ="nikon">Nikon Digital Camera</option>
<option value ="tripod">Tripod</option>
<option value ="wacom">Wacom Tablet</option>
<option value ="livescribe">Live Scribe Pen</option>
<option value ="bcalc">Business Calculator</option>
<option value ="scalc">Scientific Calculator</option>
<option value ="ti89">Ti-89 Calculator</option>
<option value ="projector">Compaq Projector</option>
</select>
<br/><br/>
<?= ((!empty($termbad)) ? '<div class="error">' : '') ?><label for ="rent">How long would you like to rent this device?</label>
<select name="rent">
<option value =""></option>
<option value ="1 Day">1 Day</option>
<option value ="2 Days">2 Days</option>
<option value ="3 Days">3 Days</option>
<option value ="4 Days">4 Days</option>
<option value ="1 week">1 Week</option>
<option value ="2 weeks">2 Weeks</option>
<option value ="3 weeks">3 Weeks</option>
<option value ="1 Month">1 Month</option>
<option value ="2 Months">2 Months</option>
<option value ="Semester">Entire Semester</option>
</select>
<br/><br/>
<?= ((!empty($desiredbad)) ? '<div class="error">' : '') ?><label for = "desired">Desired Pick Up Date and Time: </label><input type="text" name="desired" size="25" maxlength="60">
<br /><br/>
<br/>
</div>
<div align="center">
<input class="pure-button" type="submit" value="Submit"> <i class="fa fa-paper-plane"></i> </input>
<br/>
</div>
<br/>
</th>

</form>
</table>
</body>





</html>