<?php

$dbhost = '23.229.171.225';
$dbuser = 'Michael';
$dbpassword = 'TechRent2014!';
$dbdatabase = 'TechRent';

// Connecting, selecting database
$dblink = mysql_connect($dbhost, $dbuser, $dbpassword)
    or die("Could not connect to database at $dbhost: " . mysql_errno() . ": " . mysql_error());

mysql_select_db($dbdatabase,$dblink)
    or die("Could not select database $dbdatabase: " . mysql_errno() . ": " . mysql_error());
	
?>