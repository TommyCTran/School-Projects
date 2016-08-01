<?php

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: StudentSignin.php
File Description: In this page, the student gives all their necessary information (signs in) 
*/

session_start();
$_SESSION['showSudentOptionsMessage'] = false;

include('Proj2Head.html');
//info format user enters is checked in ValidateStudentSiginin.php
if($_SESSION['lastPage'] == 'ValidateStudentSignin.php'){
	$signinError=true;
	$fName = $_SESSION['fName'];
	$lName = $_SESSION['lName'];
	$major = $_SESSION['major'];
	$studentId = $_SESSION['studentId'];
	$studentEmail = $_SESSION['studentEmail'];
	$returningStudentId = $_SESSION['returningStudentId'];
}
else{
	$signinError = false;//
}

?>

<!--output-->
<link rel="stylesheet" type="text/css" href="http://userpages.umbc.edu/~t22/CMSC331/Project2/css/StudentSigninStylesheet.css"/>
<div class="form-div">
<div class="form-title">Student Signin<br></div>

<div class='box1'>
<div class='form1'>
<div class='space'><b>New Student</b></div>
<form action='ValidateStudentSignin.php' method='post' name='login'>

	<div class='space'>First Name: 	<input type='text' size="23" name='fName' <?php echo "value='$fName'"?>><br></div>
 	
	<div class='space'>Last Name:  	<input type='text' size="23" name='lName' <?php echo "value='$lName'"?>><br></div>

	Major:	 		<select name='major' class='space1'>
	 				<option value='Undecided'>Undecided</option>
  					<option value='Computer Science' <?php if($major == 'Computer Science'){echo"selected";} ?>>Computer Science</option>
  					<option value='Computer Engineering' <?php if($major == 'Computer Engineering'){echo"selected";} ?>>Computer Engineering</option>
  					<option value='Mechanical Engineering' <?php if($major == 'Mechanical Engineering'){echo"selected";} ?>>Mechanical Engineering</option>
  					<option value='Chemical Engineering' <?php if($major == 'Chemical Engineering'){echo"selected";}?>>Chemical Engineering</option>
  					</select>

	
	<div class='space'>Student Email:	<input type='text' name='studentEmail' <?php echo "value='$studentEmail'"?> ></div>
	
	<div class='space'>Student ID:	<input type='text' size="23" name='studentId' <?php echo "value='$studentId'"?> ></div><br>
</div>
</div>


<div class='box2'>
<div class='form2'>
<br><br>
<div class='space'><b>Returning Student</b></div>
  	
	Student ID:	<input type='text' name='returningStudentId' <?php echo "value='$returningStudentId'"?> ><br>

</div>
</div>
<br><br>
<div class='error'>
<?php

if($_SESSION['showStudentSigninErrorMessage']){
		//error message in red font
   		echo '<font color="red"><b>';
		echo $_SESSION['studentSigninErrorMessage']."<br><br>";	
		echo '</b></font>';
}
?>
</div>
<table class='buttons'>
<tr>

<td><input type='submit' value='Sign In'></div>
</form></td>

<td><form action='index.php' name='goBack' class='goBack'>
<input type='submit' value='Go Back'>
</form></td>

</tr>

</table>

<!--signin button-->



<!--back button-->

</div>

<?php
$_SESSION['lastPage'] = "StudentSignin.php";
include('Proj2Tail.html');
?>
