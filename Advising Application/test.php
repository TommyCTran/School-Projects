<?php
session_start();
$str = "asdkjds";
$arraay = array("foo", "bar", "hello", "world");
$startDate = date('Y-m-d 08:00:00', strtotime('+1 week'));
$date = date('2015-11-11 08:00:00');

"<script>
var schedule = '$arraay[1]';
schedule.toString();
window.alert(schedule);
function show(id, value)
{
	if(document.getElementById(id+Individual).checked)
	{
		
	}
	if(document.getElementById(id+Group).checked)
	{
		window.alert('Checked');
		
	}
}
</script>
<input type='checkbox' id='$key+Individual' name='$key' value='$key' onclick='show($key, $value);'>
";

$startDate = date('2015-03-02 08:00:00');
$date = $startDate;
$endDate = date('2015-05-1 16:00:00');
echo date('l', strtotime($date));
echo "<br>";

$startDate = date('Y-m-d 08:00:00', strtotime('+1 week'));
$date = $startDate;
$endDate = date('Y-m-d H:i:s', strtotime('+1 week', strtotime($date)));
$endOfAppointments = True;
echo date('l', strtotime($date));	

?>
<html>
<html>
<body>



</body>
</html>
.form-div
{
	float: left;
	margin-left: 25%;
	margin-top: 2.5%;
	width: 50%;
}