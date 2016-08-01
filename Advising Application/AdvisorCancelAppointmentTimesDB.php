<?php

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: StudentInsertDB.php
File Description: This page inserts information into Student_Info2 and Advising_Appointments2.  This will only come up if the last
page was 'StudentAreYouSure.php' and was created.
*/

//make sure header comments come after <?php, or else they show up as text on the page

session_start();
include('../CommonMethods.php');
$debug = false;
$COMMON = new Common($debug);

// Make sure we're coming from the right page
if($_SESSION['lastPage'] != "AdvisorCancelAppointmentTimes.php"){
	echo "Something went wrong!<br>";
}

else{
	$advisorId = $_SESSION['advisorId'];
	$advisorName = $_SESSION['advisors'][$advisorId];
	$schedule = $_SESSION['schedule'];
	
	foreach ($schedule as $key => $value)
	{
		
		if (isset($_POST[str_replace(" ","_", $key)]))
		{
			$sql = "DELETE FROM `Advising_Availability2` WHERE `dateTime` = '$key'"; 
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
			$sql = "DELETE FROM `Advising_Appointments2` WHERE `dateTime` = '$key'";
			$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		}
		
	}
}

$_SESSION['showAdvisorOptionsMessage'] = true;
$_SESSION['advisorOptionsMessage'] = "You have successfully canceled an appointment.";
// Make last page equal this page.
$_SESSION['lastPage'] = "AdvisorCancelAppointmentTimesDB.php";

//header should come after setting last page, or else it won't reach that part of the code
header('Location: AdvisorOptions.php');

?>
