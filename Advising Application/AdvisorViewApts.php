<?php
/*
Name: Nathaniel Baylon, Tommy Tran, Kyle Fritz
Date: 03/29/2015
Last Modified: 5/1/15
Class: CMSC331
Project: Project 2
File: AdvisorViewApts.php
File Description: This page will only come up if the last page was AdvisorOptions.php 
and "View Created Appointment" was selected.
*/
session_start();
include('Proj2Head.html');
include('CommonMethods.php');
$fName = $_SESSION['fName'];
// Make sure we're coming from the right page
if($_SESSION['lastPage'] != "AdvisorOptions.php" && $_SESSION['lastPage'] != "AdvisorViewApts.php"){
	echo "Something went wrong!<br>";
}
else{

	$advisors = $_SESSION['advisors'];
	// $employeeId becomes whatever the Session variable of employeeId holds
	
	if($_SESSION['lastPage'] == 'AdvisorViewApts.php'){
		$advisorId = $_POST['sel_advisorView'];
		//echo "$advisorId";
	}
	else{
		$advisorId = $_SESSION['advisorId'];
		//echo "$advisorId";
	}

	
	////////////////////////Nat's additions//////////////////
	$today = time();
	if($_SESSION['lastPage'] != 'AdvisorViewApts.php'){
		
		if($_SESSION['demo']){
			if(date('l')=='Sunday' || date('l')== 'Saturday'){
				
				// starts today at 8am
				$selectedDate = strtotime("Monday");
				$selectedDate = strtotime("8 am", $startDate);
			
			}
			else{
				$selectedDate = strtotime("8am", $today);
			}
		}
		else{
			if(date('Y-m-d') < '2015-05-01' && date('Y-m-d') > '2015-03-02'){
				if(date('l')=='Sunday' || date('l')== 'Saturday'){
				
					// starts today at 8am
					$selectedDate = strtotime("Monday");
					$selectedDate = strtotime("8am", $startDate);
				}
				else{
					$selectedDate = strtotime("8am", $today);
				}
			}
			else{
				//if not in the time frame, make last day the default
				$selectedDate = strtotime('2015-05-01 08:00:00');
			}

		}
	}
	//from this page
	else{
		$selectedDate = strtotime($_POST['sel_startDate']);

	}

	//the advisor
	echo "
	<link rel='stylesheet' type='text/css' href='http://userpages.umbc.edu/~t22/CMSC331/Project2/css/AdvisorViewAptsStylesheet.css'/>
	<div class='form-title'> Advisor View Appointments<br></div>
	<div class='form-div'>
	<div class='block'>";
	echo"<form action = 'AdvisorViewApts.php' method='post'>";
	echo"<div class= 'space'>";
	echo "Advisor:<select name='sel_advisorView'>";
	foreach($advisors as $advisorsId=>$advisorName){
		if($advisorName != 'Group Advising'){
			echo"<option value = '$advisorsId'";
			if($advisorId == $advisorsId){
				echo "selected";
			}
			echo '>';
		}
		echo "$advisorName</option>";
	}
	echo "</select><br></div>";

	

	if(!$_SESSION['demo']){

		$counterDay = '2015-03-02 08:00:00';
		$counterEndDay = '2015-05-01 08:00:00';

	}
	else{
		$counterDay = date('Y-m-d H:i:s', strtotime("-2 weeks", time()));
		$counterEndDay = date('Y-m-d H:i:s', strtotime("+2 weeks", time()));
	}
	
	//echo"<form action = 'AdvisorViewApts.php' method='post'>";
	echo"<div class='space'>Day:<select name='sel_startDate'>";
	while($counterDay < $counterEndDay){
		$userFormatCounterDay = date("l, m/d/Y", strtotime($counterDay));
		echo"<option value='$counterDay'";
			//if same day in the select box as the start day
			if(date('Y-m-d', strtotime($counterDay)) == date('Y-m-d', $selectedDate)){
				echo "selected";
			}
		echo">$userFormatCounterDay</option>";
			
		if(date('l', strtotime($counterDay)) == "Friday"){
			$counterDay = date('Y-m-d 08:00:00',strtotime("+3 days", strtotime($counterDay)));
		}
		else{
			$counterDay = date('Y-m-d 08:00:00',strtotime("+1 days", strtotime($counterDay)));
		}
	}
	echo "</select><br></div>";
	echo "<br>";

	//get all the entries from Advising_Appointments2 for the selected day
	$counterTime = date("Y-m-d h:i:s",$selectedDate);
	$counterEndTime = date('Y-m-d', $selectedDate);
	$counterEndTime = $counterEndTime." 16:00:00";
	//echo "$counterTime $counterEndTime";
	$userFormatDate = date('l, m/d/Y', $selectedDate);

	//instantiate common
	$debug = false;
	$COMMON = new Common($debug);

	echo '<table border = "3">';
	echo"<caption>$userFormatDate</caption>";
	echo "<tr>
			<th>Time</th>
			<th>Student</th>
			<th>Email</th>
			<th>Major</th>
			<th>Student Id</th>
		<tr>";
	while($counterTime < $counterEndTime){
		$userFormatTime = date('g:i a', strtotime($counterTime));
		$sql = "SELECT * FROM Advising_Appointments2
				 WHERE `dateTime` = '$counterTime' AND (`advisorId` = '$advisorId' OR `advisorId` = 'GROUPAP')";
		
		$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
		$row = mysql_fetch_assoc($rs);

		if($userFormatTime == '1:30 pm' || $userFormatTime == '2:00 pm'){
			$student = "Lunch Break";
			$email = " ";
			$major = " ";
			$id = " ";
		}
		elseif(mysql_num_rows($rs) == 0){
			$student = " ";
			$email = " ";
			$major = " ";
			$id = " ";
		}
		else{
			//var_dump($row);
			if($row['advisorId'] == 'GROUPAP'){
				$student = "Group Appointment";
				$email = " ";
				$id = " ";
				
				$sql = "SELECT * FROM `Advising_Availability2` WHERE `advisorId` = 'GROUPAP'
				AND `dateTime` = '$counterTime'";

				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$groupRow = mysql_fetch_assoc($rs);
			
				$major = $groupRow['major'];		
			}
			else{
				$studentId = $row['studentId'];
				$sql = "SELECT * FROM `Student_Info2` WHERE `studentId` = '$studentId'";
				$rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
				$studentRow = mysql_fetch_assoc($rs);
				$student = $studentRow['fName']." ".$studentRow['lName'];
				$email = $studentRow['studentEmail'];
				$major = $studentRow['major'];
				$id = $studentId;
			}
		}
			echo "<tr>";
			echo "<td>$userFormatTime</td>";
			echo "<td>$student</td>";
			echo "<td>$email</td>";
			echo "<td>$major</td>";
			echo "<td>$id</td>";
			echo "</tr>";
			$counterTime = date('Y-m-d H:i:s',strtotime('+30 minutes',strtotime($counterTime)));
	}
	echo "</table>";
}
?>

<table class='buttons'>
<tr>
<td><input type='submit' value='View Schedule'>
	</form>
</td>

<td><form action='AdvisorOptions.php' name='AVAtoAOptions'>
	<!--Go Back button-->
	<input type='submit' value='Go Back' class='goBack'>
	<!-- End of form  -->
	</form></td>
	

</tr>

</table>


<?php
	// Make last page equal this page.	
  	$_SESSION['lastPage'] = "AdvisorViewApts.php";
	include('Proj2Tail.html');
?>