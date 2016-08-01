<?php
session_start();

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: StudentOptions.php
File Description: This file shows the options for advising that the student can choose from.
The student can choose to create an appointment, view an upcoming appointment, change an 
appointment, or delete an appointment.
*/

include('Proj2Head.html');
$fName = $_SESSION['fName'];
$studentId = $_SESSION['studentId'];
$advisors = $_SESSION['advisors'];
$groupEnabled = $_SESSION['groupEnabled'];
$indEnabled = $_SESSION['indEnabled'];
$hasUpcomingAppointment = $_SESSION['studentHasUpcomingAppointment'];
$hasPastAppointment = $_SESSION['studentHasPastAppointment'];
$upcomingWithinDay = $_SESSION['upcomingWithinDay'];
//var_dump($_SESSION['advisors']);
?>

<!--Output-->
<link rel="stylesheet" type="text/css" href="http://userpages.umbc.edu/~t22/CMSC331/Project2/css/StudentOptionsStylesheet.css"/>
<div class="form-div">
<div class="form-title">Please choose an option<br></div>
<form action = 'StudentOptionHeaders.php' method = 'post' name = 'selectOption'>

<!------------------------------------------------------------------------->
<div class="form">
<div class='box'>
<div class='content'>
<div class='space'>
<input type = 'radio' name = 'rb_option' value = 'createGroupAppointment' 
<?php 
/*
if(!$groupEnabled){
	//echo 'disabled';
}
*/
if($_SESSION['studentChoice'] == 'createGroupAppointment' || 
		!isset($_SESSION['studentChoice'])){
echo 'checked';
}
?> >
Create Group Appointment<br>
</div>
<div class='space'>
<input type = 'radio' name = 'rb_option' value = 'createIndividualAppointment' 
<?php 
/*
if(!$indEnabled){
//echo 'disabled';
}
*/
//checked if group disabled
if($_SESSION['studentChoice'] == 'createIndividualAppointment'){
echo ' checked';
}
?> >Create Individual Appointment
<!------------------------------------------------------------------------>

<?php
echo "<select class='dropdown1'name='sel_createAdvisor'";
/*
if(!$indEnabled){
	//echo 'disabled';
}
*/
echo '>';

//=> is not a mistake. It's like for each key as its values
foreach($advisors as $advisorId=>$advisorName){
	if($advisorName != 'Group Advising'){
		echo"<option value = '$advisorId'";
	 	if($_SESSION['studentsCreateAdvisor'] == $advisorId){
			echo "selected";
		}
		echo ">";
	}
	echo "$advisorName</option>";
}
echo "</select>";
?>

<!--------------------------------------------------------------------------->
<br>
</div>
<div class='space'>
<input type = 'radio' name = 'rb_option' value = 'changeToGroupAppointment'
<?php 
/*
if(!$hasUpcomingAppointment || $hasPastAppointment || $upcomingWithinDay){
//echo "disabled";
} 
*/
//cancel and change will always be enabled/disabled at the same time, so 
//only check if this was the student's option (coming from a later page)
if($_SESSION['studentChoice'] == 'changeToGroupAppointment'){
	echo "checked";
}
?> >Change to Group Appointment<br>
</div>
<div class='space'>
<!------------------------------------------------------------------------------->
<input type = 'radio' name = 'rb_option' value = 'changeToIndividualAppointment'
<?php 
/*
if(!$hasUpcomingAppointment || $upcomingWithinDay){
//echo "disabled";
}
*/
if($_SESSION['studentChoice'] == 'changeToIndividualAppointment'){
echo "checked";
}

?> >Change to Individual Appointment


<!---------------------------------------------------------------------->
<?php
echo "<select class='dropdown2' name='sel_changeAdvisor'";
/*
if(!$hasUpcomingAppointment|| $upcomingWithinDay){
	//echo 'disabled';
}
*/
echo '>';
foreach($advisors as $advisorId=>$advisorName){
	if($advisorName != 'Group Advising'){
		echo"<option value = '$advisorId'";
	 	if($_SESSION['studentsChangeAdvisor'] == $advisorId){
			echo "selected";
		}
		echo ">";
	}
	echo "$advisorName</option>";
}
echo "</select>";
?>

<!------------------------------------------------------------------------>
<br>
</div>
<div class='space'>
<input type = 'radio' name = 'rb_option' value = 'viewAppointment'
<?php 
/*
if(!$_SESSION['viewEnabled']){
//echo "disabled";
}
*/

if($_SESSION['studentChoice'] == 'viewAppointment'){ 
//||$hasPastAppointment || $hasUpcomingAppointment){//commented out for now
echo " checked";
}
?> >View Appointment Details<br>

</div>
<div class='space'>
<!----------------------------------------------------------------------------->
<input type = 'radio' name = 'rb_option' value = 'cancelAppointment'
<?php 
/*
if(!$hasUpcomingAppointment || $upcomingWithinDay){
//echo "disabled";
}
*/
//will never be checked by default
if($_SESSION['studentChoice'] == 'cancelAppointment'){
echo "checked";
}
 ?> >Cancel Upcoming Appointment<br><br>
</div>
</div>
</div>
</div>

<!------------------------------------------------------------------------------>
<div class='success'><b>
<!--student options message-->
<?php
if($_SESSION['showStudentOptionsMessage']){
echo '<br>';

echo '<font color="red"><b>'.$_SESSION['studentOptionsMessage']."<br><font color='red'><b>";
}
?>
</b>
</div>
<!---------------------------->

<table class='buttons'>
<tr>

<td><input type = 'submit' value = 'Next'>
</form></td>

<td><form action = 'index.php' name = 'goback'>
<input class='goBack' type='submit' value = 'Sign Out'>
</form></td>

<td><form action='readme.html' name='student' target="_blank" class='help'>
<input type='submit' class='studentbutton' value ='help' >
</form></td>

</tr>

</table>

<!--submit button-->
<!------------------------------------------------------------------------->
<!--go back button-->

</div>

<?php
$_SESSION['lastPage'] = "StudentOptions.php";
include('Proj2Tail.html');
?>
