<?php
session_start();

/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Class: CMSC331
Project: Project 2
File: AdvisorSignin.php
File Description: In this page, the student gives all their necessary information (signs in) 
*/

include('Proj2Head.html');
if($_SESSION['signinError'] == true){
	$signinError=true;
	$fName = $_SESSION['fName'];
	$lName = $_SESSION['lName'];
	$advisorPhoneNumber = $_SESSION['advisorPhoneNumber'];
	$advisorId = $_SESSION['advisorId'];
	$password = $_SESSION['password'];
	$advisorEmail = $_SESSION['advisorEmail'];
}
else{
	$signinError = false;//
}

?>
<div class='box'>
</div>
<link rel="stylesheet" type="text/css" href="http://userpages.umbc.edu/~t22/CMSC331/Project2/css/AdvisorSigninStylesheet.css"/>
<!--output-->
<div class="form-div">
<div class="form-title"> Advisor Signin<br></div>
<form action='ValidateAdvisorSignin.php' method='post' name='login'>
	<div class="form1">
  	Advisor ID:		
					<input type='text' name='advisorId' <?php echo "value='$advisorId'"?>>
	</div>
	<div class="form2">
  	Password:		
					<input type='password' name='password' <?php echo "value='$password'"?>>
	</div>


<table class='buttons'>
<tr>

<td><input type='submit' value='Sign In'>
</form></td>

<td><form action='index.php'class='goBack' name='goBack'>
<input type='submit' value ='Go Back'></div>
</form></td>

</tr>

</table>

<!--signin button-->


<!--back button-->
<?php

if($signinError){
		//error message in red font
		
		$message = $_SESSION['advisorErrorMessage'];
   		echo "<div class='error'>
		<b><font color='#ff0000'>$message</font></b>
		</div>";	
}

$_SESSION['lastPage'] = "AdvisorSignin.php";
include('Proj2Tail.html');
?>
