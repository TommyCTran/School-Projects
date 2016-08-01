<?php

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: AdvisorCreateAppointment.php
File Description: In this file, a student chooses a radio button for the day they want to sign up
for, and selects a time from a select box on that same line. Times only show up
within 2 business days to a week after that if the current week is enabled, or 
next monday through the following monday if current week is disabled. If day has 
no availabilities, the student cannot select it. 
*/

session_start();
include ('Proj2Head.html');
include('CommonMethods.php');



$debug = false;
$COMMON = new Common($debug);

$advisorId = $_SESSION['advisorId'];
$advisorName = $_SESSION['advisors'][$advisorId];
$demo = $_SESSION['demo'];
$schedule = array();
$avaliableSchedule = array();

$sql = "SELECT * FROM Advising_Availability2 where `advisorId` = '$advisorId' OR `advisorId` = 'GROUPAP'";
$rs = $COMMON->executeQuery($sql, $_SERVER['SCRIPT_NAME']);
while($row = mysql_fetch_assoc($rs)){
	array_push($avaliableSchedule, $row['dateTime']);
}
echo '<link rel="stylesheet" type="text/css" href="http://userpages.umbc.edu/~t22/CMSC331/Project2/css/AdvisorCreateAppointmentStylesheet.css"/>';
echo '<div class="background"></div>';

echo "
<div class='form-title'> Advisor Create Appointments</div>
<form action='AdvisorInsertDB.php' name='advisorAppointments' method='post'>";
if ($demo == True)
{
	$startDate = date('Y-m-d 08:00:00', strtotime('+1 week'));
	$date = $startDate;
	$endDate = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($date)));
	$endOfAppointments = True;
	while ($endOfAppointments)
	{
		if (date('l', strtotime($date)) != "Saturday" &&
		date('l', strtotime($date)) != "Sunday" &&
		date('H', strtotime($date)) >= "08" && 
		date('H', strtotime($date)) <= "16" && 
		date('H:i', strtotime($date)) != "13:30" && 
		date('H:i', strtotime($date)) != "14:00" &&
		date('H:i', strtotime($date)) != "16:30")
		{
			$schedule[$date] = date('F j, Y, g:i a', strtotime($date));
		}
	$date = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($date)));
		if ($date == $endDate)
		{
			$endOfAppointments = False;
		}
	}
}
if ($demo == False)
{
	$startDate = date('2015-03-02 08:00:00');
	$date = $startDate;
	$endDate = date('2015-05-01 16:00:00');
	$endOfAppointments = True;
	while ($endOfAppointments)
	{
		if (date('l', strtotime($date)) != "Saturday" &&
		date('l', strtotime($date)) != "Sunday" &&
		date('H', strtotime($date)) >= "08" && 
		date('H', strtotime($date)) <= "16" && 
		date('H:i', strtotime($date)) != "16:30")
		{
			$schedule[$date] = date('F j, Y, g:i a', strtotime($date));
		}
	$date = date('Y-m-d H:i:s', strtotime('+30 minutes', strtotime($date)));
		if ($date == $endDate)
		{
			$endOfAppointments = False;
		}
	}
}

$_SESSION['schedule'] = $schedule;
	
echo 
"<script>

function show(id, value)
{
	
	if(document.getElementById(id+'Individual').checked)
	{
		document.getElementById(value).style.visibility='hidden';
		document.getElementById(value+'Major').style.visibility='hidden';
	}
		if(document.getElementById(id+'Group').checked)
	{
		document.getElementById(value).style.visibility='visible';
		document.getElementById(value+'Major').style.visibility='visible';
		
	}
}

</script>";
echo "

<div class='monday' style='width: 5%;'>Monday</div>
<div class='DOW-form-div'>
<br>";

foreach ($schedule as $key => $value)
{	
	$keySpace = str_replace(" ","", $key);
	$valueSpace = str_replace(" ","", $value);
	$keyIndividual = $keySpace.'Individual';
	$keyGroup = $keySpace.'Group';
	$valueMajor = $valueSpace.'Major';
	$valueHide = $valueSpace.'';
	
	
	if (date('l', strtotime($key)) == "Monday" && !in_array($key, $avaliableSchedule))
	{
		echo "
		<div class='space'>
		<b>$value</b> Individual Appointment
		<input type='radio' id='$keyIndividual' name='$key' value='$keyIndividual' onclick=show('$keySpace','$valueSpace');>
		Group Appointment
		<input type='radio' id='$keyGroup' name='$key' value='$keyGroup' onclick=show('$keySpace','$valueSpace');>
		<select name='$valueHide' id='$valueHide' class='visible'>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10' selected>10</option>
		</select>
		<select name='$valueMajor' id='$valueMajor' class='visible'>
		<option value='All Majors' selected>All Majors</option>
		<option value='Computer Science'>Computer Science</option>
		<option value='Computer Engineering'>Computer Engineering</option>
		<option value='Mechanical Engineering'>Mechanical Engineering</option>
		<option value='Chemical Engineering'>Chemical Engineering</option>
		</select>
		</div>";
	}
}
echo "</div>";
echo "

<div class='tuesday' style='width: 5.5%';>Tuesday</div>
<div class='DOW-form-div'>";
foreach ($schedule as $key => $value)
{	
	$keySpace = str_replace(" ","", $key);
	$valueSpace = str_replace(" ","", $value);
	$keyIndividual = $keySpace.'Individual';
	$keyGroup = $keySpace.'Group';
	$valueMajor = $valueSpace.'Major';
	$valueHide = $valueSpace.'';
	
	
	if (date('l', strtotime($key)) == "Tuesday" && !in_array($key, $avaliableSchedule))
	{
		echo "
		<div class='space'>
		<b>$value</b> Individual Appointment
		<input type='radio' id='$keyIndividual' name='$key' value='$keyIndividual' onclick=show('$keySpace','$valueSpace');>
		Group Appointment
		<input type='radio' id='$keyGroup' name='$key' value='$keyGroup' onclick=show('$keySpace','$valueSpace');>
		<select name='$valueHide' id='$valueHide' class='visible'>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10' selected>10</option>
		</select>
		<select name='$valueMajor' id='$valueMajor' class='visible'>
		<option value='All Majors' selected>All Majors</option>
		<option value='Computer Science'>Computer Science</option>
		<option value='Computer Engineering'>Computer Engineering</option>
		<option value='Mechanical Engineering'>Mechanical Engineering</option>
		<option value='Chemical Engineering'>Chemical Engineering</option>
		</select>
		</div>";
	}
}
echo "</div>";

echo "

<div class='wednesday' style='width: 7.25%';>Wednesday</div>
<div class='DOW-form-div'>";
foreach ($schedule as $key => $value)
{	
	$keySpace = str_replace(" ","", $key);
	$valueSpace = str_replace(" ","", $value);
	$keyIndividual = $keySpace.'Individual';
	$keyGroup = $keySpace.'Group';
	$valueMajor = $valueSpace.'Major';
	$valueHide = $valueSpace.'';
	
	
	if (date('l', strtotime($key)) == "Wednesday" && !in_array($key, $avaliableSchedule))
	{
		echo "
		<div class='space'>
		<b>$value</b> Individual Appointment
		<input type='radio' id='$keyIndividual' name='$key' value='$keyIndividual' onclick=show('$keySpace','$valueSpace');>
		Group Appointment
		<input type='radio' id='$keyGroup' name='$key' value='$keyGroup' onclick=show('$keySpace','$valueSpace');>
		<select name='$valueHide' id='$valueHide' class='visible'>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10' selected>10</option>
		</select>
		<select name='$valueMajor' id='$valueMajor' class='visible'>
		<option value='All Majors' selected>All Majors</option>
		<option value='Computer Science'>Computer Science</option>
		<option value='Computer Engineering'>Computer Engineering</option>
		<option value='Mechanical Engineering'>Mechanical Engineering</option>
		<option value='Chemical Engineering'>Chemical Engineering</option>
		</select>
		</div>";
	}
}
echo "</div>";
echo "
<div class='thursday' style='width: 6%';>Thursday</div>
<div class='DOW-form-div'>";
foreach ($schedule as $key => $value)
{	
	$keySpace = str_replace(" ","", $key);
	$valueSpace = str_replace(" ","", $value);
	$keyIndividual = $keySpace.'Individual';
	$keyGroup = $keySpace.'Group';
	$valueMajor = $valueSpace.'Major';
	$valueHide = $valueSpace.'';
	
	
	if (date('l', strtotime($key)) == "Thursday" && !in_array($key, $avaliableSchedule))
	{
		echo "
		<div class='space'>
		<b>$value</b> Individual Appointment
		<input type='radio' id='$keyIndividual' name='$key' value='$keyIndividual' onclick=show('$keySpace','$valueSpace');>
		Group Appointment
		<input type='radio' id='$keyGroup' name='$key' value='$keyGroup' onclick=show('$keySpace','$valueSpace');>
		<select name='$valueHide' id='$valueHide' class='visible'>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10' selected>10</option>
		</select>
		<select name='$valueMajor' id='$valueMajor' class='visible'>
		<option value='All Majors' selected>All Majors</option>
		<option value='Computer Science'>Computer Science</option>
		<option value='Computer Engineering'>Computer Engineering</option>
		<option value='Mechanical Engineering'>Mechanical Engineering</option>
		<option value='Chemical Engineering'>Chemical Engineering</option>
		</select>
		</div>";
	}
}
echo "</div>";
echo "

<div class='friday' style='width: 5%';>Friday</div>
<div class='DOW-form-div'>";
foreach ($schedule as $key => $value)
{	
	$keySpace = str_replace(" ","", $key);
	$valueSpace = str_replace(" ","", $value);
	$keyIndividual = $keySpace.'Individual';
	$keyGroup = $keySpace.'Group';
	$valueMajor = $valueSpace.'Major';
	$valueHide = $valueSpace.'';
	
	
	if (date('l', strtotime($key)) == "Friday" && !in_array($key, $avaliableSchedule))
	{
		echo "
		<div class='space'>
		<b>$value</b> Individual Appointment
		<input type='radio' id='$keyIndividual' name='$key' value='$keyIndividual' onclick=show('$keySpace','$valueSpace');>
		Group Appointment
		<input type='radio' id='$keyGroup' name='$key' value='$keyGroup' onclick=show('$keySpace','$valueSpace');>
		<select name='$valueHide' id='$valueHide' class='visible'>
		<option value='1'>1</option>
		<option value='2'>2</option>
		<option value='3'>3</option>
		<option value='4'>4</option>
		<option value='5'>5</option>
		<option value='6'>6</option>
		<option value='7'>7</option>
		<option value='8'>8</option>
		<option value='9'>9</option>
		<option value='10' selected>10</option>
		</select>
		<select name='$valueMajor' id='$valueMajor' class='visible'>
		<option value='All Majors' selected>All Majors</option>
		<option value='Computer Science'>Computer Science</option>
		<option value='Computer Engineering'>Computer Engineering</option>
		<option value='Mechanical Engineering'>Mechanical Engineering</option>
		<option value='Chemical Engineering'>Chemical Engineering</option>
		</select>
		</div>";
	}
}
echo "</div>";
?>

<table class='buttons'>
<tr>

<td><input type = 'submit' value = 'Next'></div>
</form></td>

<td><form action = 'AdvisorOptions.php' name = 'goback' class='goBack'>
<input type='submit' value = 'Back'>
</form></td>


</tr>
</table>

<!--submit button-->


<!--go back button-->


<?php
$_SESSION['lastPage'] = 'AdvisorCreateAppointment.php';
include('Proj2Tail.html');
?>
