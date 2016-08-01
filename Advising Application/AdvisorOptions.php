<?php

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: AdvisorOptions.php
File Description: This file shows the options for advising that the student can choose from.
The student can choose to create an appointment, view an upcoming appointment, change an 
appointment, or delete an appointment.
*/

session_start();
include('Proj2Head.html');

//variables to be used as default values
$advisorId = $_SESSION['advisorId'];
$advisors = $_SESSION['advisors'];
//$advisorView = $_SESSION['advisorView'];
$searchStudentID = $_SESSION['searchStudentID'];
$searchStudentlName = $_SESSION['searchStudentlName'];
$cancelID = $_SESSION['cancelID'];
$advisorReschedule = $_SESSION['advisorReschedule'];
$rescheduleID = $_SESSION['rescheduleID'];
$scheduleNewfName = $_SESSION['scheduleNewfName'];
$scheduleNewlName = $_SESSION['scheduleNewlName'];
$scheduleNewEmail = $_SESSION['scheduleNewEmail'];
$scheduleNewMajor = $_SESSION['scheduleNewMajor'];
$scheduleNewID = $_SESSION['scheduleNewID'];
$scheduleExistingID = $_SESSION['scheduleExistingID'];



//var_dump($_SESSION['advisors']);
?>
<link rel="stylesheet" type="text/css" href="http://userpages.umbc.edu/~t22/CMSC331/Project2/css/AdvisorOptionsStylesheet.css"/>
<!--Output-->
<div class="form-div">
<div class="form-title">Please choose an option<br></div>
<div class="form">
<form action = 'AdvisorOptionHeaders.php' method = 'post' name = 'selectOption'>

<div class="box1"></div>
<!--view Schedule-->
<div class="space">
<input type = 'radio' name = 'rb_option' value = 'viewAppointment'
	<?php if($_SESSION['advisorDecision'] == 'viewAppointment'){echo 'checked';}?>
> View Schedule
<?php
/*
echo "<select name='sel_advisorView'>";
foreach($advisors as $advisorsId=>$advisorName){
	//if($advisorName != 'Group Advising'){
		echo"<option value = '$advisorsId'";
	 	if($advisorId == $advisorsId){
			echo "selected";
		}
		echo ">";
	//}
	echo "$advisorName</option>";
}

echo "</select><br><br>";
*/

?>
</div>


<div class="space">
<!--select appointment times-->
<input type = 'radio' name = 'rb_option' value = 'selectAppointment' 
	<?php
	if($_SESSION['advisorDecision'] == 'selectAppointment' ||
	!isset($_SESSION['studentChoice'])){
		echo 'checked';
	}
	?>
> Create Appointment Times<br>
</div>
<div class="space">
<!--cancelAppointmentTimes-->
<input type = 'radio' name = 'rb_option' value = 'cancelAppointmentTimes' 
	<?php
	if($_SESSION['advisorDecision'] == 'cancelAppointmentTimes'){
		echo 'checked';
	}
	?>
> Cancel Appointment Times
</div>
<div class="space">
<!--Find student-->
<input type = 'radio' name = 'rb_option' value = 'searchStudentID'
	<?php if($_SESSION['advisorDecision'] == 'searchStudentID'){echo 'checked';}?>
> Search For Student:

<input type = 'text' size = '25' name = 'text_searchStudentID'<?php echo "value='$searchStudentID'"; ?> 
											placeholder = 'Last Name or Student ID'>
</div>
<div class="space">
<!--Cancel appointment-->
<input type = 'radio' name = 'rb_option' value = 'cancelAppointment'
	<?php if($_SESSION['advisorDecision'] == 'cancelAppointment'){echo 'checked';}?>
>Cancel Appointment:

<input type = 'text' size = '25' name = 'text_cancelID'<?php echo "value='$cancelID'"; ?>
					placeholder = 'Student ID'>
</div>

<div class="space">
<!--Reschedule Appointment-->
<input type = 'radio' name = 'rb_option' value = 'rescheduleAppointment'
	<?php if($_SESSION['advisorDecision'] == 'rescheduleAppointment'){echo 'checked';}?>
> Reschedule Appointment:

<input type = 'text' name = 'text_rescheduleID'<?php echo "value='$rescheduleID'"; ?>
					placeholder = 'Student ID'>
				
				
<?php
echo "<select class='dropdown1' name='sel_advisorReschedule'>";
foreach($advisors as $advisorsId=>$advisorName){
	//if($advisorName != 'Group Advising'){
		echo"<option value = '$advisorsId'";
		if($advisorId == $advisorsId){
			echo "selected";
		}
		echo '>';
	//}
	echo "$advisorName</option>";
}
echo "</select><br>";
?>

</div>
<div class="space">
<br>
<br>
<div class="box2">
</div>
<!--Schedule Appointment-->

<input type = 'radio' name = 'rb_option' value = 'scheduleAppointment'
	<?php if($_SESSION['advisorDecision'] == 'scheduleAppointment'){echo 'checked';}?>
> Schedule appointment for new or existing student

<?php
echo ":<select class='dropdown2' name='sel_advisorSchedule'>";
foreach($advisors as $advisorsId=>$advisorName){
	//if($advisorName != 'Group Advising'){
		echo"<option value = '$advisorsId'";
		if($advisorId == $advisorsId){
			echo "selected";
		}
		echo">";
	//}
	echo "$advisorName</option>";
}
echo "</select><br>";
?>

</div>
<div class="newstudent">
<b>New Student's Information</b><br>
<div class="space">
Student First Name:	 <input type='text' name='text_scheduleNewfName'<?php echo "value='$scheduleNewfName'"; ?>><br>
</div>
<div class="space">
Student Last Name: 	<input type='text' name='text_scheduleNewlName'<?php echo "value='$scheduleNewlName'"; ?>><br>
</div>
<div class="space">
Student Major: 		<select class='dropdown3' name='sel_scheduleNewMajor'>
	 						<option value='Undecided'<?php if($scheduleNewMajor == 'Undecided'){echo"selected";} ?>>Undecided</option>
  							<option value='Computer Science'<?php if($scheduleNewMajor == 'Computer Science'){echo"selected";} ?>>Computer Science</option>
  							<option value='Computer Engineering'<?php if($scheduleNewMajor == 'Computer Engineering'){echo"selected";} ?>>Computer Engineering</option>
  							<option value='Mechanical Engineering'<?php if($scheduleNewMajor == 'Mechanical Engineering'){echo"selected";} ?>>Mechanical Engineering</option>
  							<option value='Chemical Engineering' <?php if($scheduleNewMajor == 'Chemical Engineering'){echo"selected";} ?>>Chemical Engineering</option>
  						</select><br>
</div>
<div class="space">
Student Email:		<input type='text' size='25' name='text_scheduleNewEmail'<?php echo "value='$scheduleNewEmail'"; ?>><br>
</div>
<div class="space">
Student ID:			<input type='text' size='28' name='text_scheduleNewID'<?php echo "value='$scheduleNewID'"; ?>><br>
</div>
</div>
<div class="oldstudent">

<b>Existing Student's Information</b><br>
<div class="space">
Student ID:			<input type='text' size='14' name='text_scheduleExistingID'<?php echo "value='$scheduleExistingID'"; ?>><br>
</div>
</div>
<!--THE MESSAGE, if there is one...Needs some styling, but I'm lazy  (:@) -->

<div class='success'><b>
<?php
if($_SESSION['showAdvisorOptionsMessage']){
	$message = $_SESSION['advisorOptionsMessage'];
	echo "$message <br><br>";
}
?>
</b></div>



<!--submit button-->

<!--go back button-->

</div>
<table class='buttons'>
<tr>
<td><input type = 'submit' value = 'Next'>
</form>
</td>

<td><form action = 'index.php' name = 'goback' class='goBack'>
<input type='submit' value = 'Sign Out'>
</form></td>

<td><form action='readme.html' name='student' target="_blank" class='help'>
<input type='submit' class='studentbutton' value ='help' >
</form></td>

</tr>

</table>

<?php
$_SESSION['lastPage'] = "AdvisorOptions.php";
include('Proj2Tail.html');
?>
