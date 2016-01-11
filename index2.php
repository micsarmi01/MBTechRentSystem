<html>


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

	
	
	if(empty($Error)){
		
		if(!$dblink)
			{	
				die('Could not connect: '. mysql_error());
			}
		$result = "INSERT INTO customers(otter_id, fname, lname, email, pnumber, instructor_name, course, faculty) 
		VALUES ('$_POST[otter]','$_POST[fname]','$_POST[lname]','$_POST[email]','$_POST[phone]','$_POST[instructor]','$_POST[course]','$_POST[faculty]')";
		
		
		if (!mysql_query($result,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
		$result2 = "INSERT INTO orders(fname,lname,item, Rental_term, comp, otterid, active, email)
		VALUES('$_POST[fname]','$_POST[lname]','$_POST[item]','$_POST[rent]',0,'$_POST[otter]', 0, '$_POST[email]')";
		
	
		
	
		
		if (!mysql_query($result2,$dblink))
		{
			die('Error: ' . mysql_error());
		}
		
	    
		mysql_close($dblink);
		

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
<div align ="center">
<img src="/csumb.png" width="700" height="180"/>
<br/>
<h1> CSUMB TECH STORE 2</h1>
</div>

</header>

<body>
<table align="center" width="500" border="3">
<form id="rent_form" action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
<div align="center">
<label for="Rent Form"><b>Rental Request Form</b></label></div>

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
<label for = "phone">Phone #: </label><input type="text" name="phone" size="25" maxlength="40">
<br /><br/>
<label for = "course">Course Name: </label><input type="text" name="course" size="25" maxlength="40">
<br /><br/>
<label for = "instructor">Instructor Name: </label><input type="text" name="instructor" size="25" maxlength="40">
<br /><br/>

<label for = "faculty">Are you an instructor?</label>
<select name="faculty">
<option value ="0">No</option>
<option value ="1">Yes</option>
</select>




<br/><br/>
<label for ="item">Which item would you like to rent?</label>
<select name="item">
<option value ="--">--item--</option>
<option value ="Macbook">MacBook</option>
<option value ="ipad">iPad</option>
<option value ="hp_laptop">HP Laptop</option>
</select>
<br/><br/>
<label for ="rent">How long would you like to rent this device?</label>
<select name="rent">
<option value ="--">--rent--</option>
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
<br/>
</div>
<div align="center">
<input type="submit" value="Submit">
<br/>
</div>
<br/>
</th>

</form>
</table>
</body>





</html>