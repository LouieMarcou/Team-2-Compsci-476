<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Corner Side Help</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" href="WebsiteStyleSheet.css">
		
	</head>
		
	<body>

		<div class="links">
			<span style="display:inline-block;">
				<!--<p style="font-size:3vw; text-align:left; float:left;"> Corner Side Help</p>-->
				<img src="Pictures/CornerSide Logo Nov 16th (002).png" width="20%">
			</span>
			<span style="float:right; font-size:2vw; margin-right:25px;">
				<a href="index.html">Home</a>
				<a href="sponsors.html">Sponsors</a>
				<a href="donate.html">Donate</a>
				<a href="logIn.html">Log In</a>
			</span>
		</div>

<?php

// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','cornersidehelp');
$response = "";

// get the post records
$userID = "";
if (isset($_POST['userID'])) {
	$userID = $_POST['userID'];
}
$donation = "";
if (isset($_POST['donation'])) {
	$donation = $_POST['donation'];
}
$donor = "";
if (isset($_POST['donor'])) {
	$donor = $_POST['donor'];
}
$donorPass = "";
if (isset($_POST['donorPass'])){
	$donorPass = $_POST['donorPass'];
}

//check fields are not empty
if ($userID === '' || $donation === '' || $donor === '' || $donorPass === '') {
	$emptyField = "";

	if ($userID === ''){
		$emptyField = $emptyField . "User ID <br>";
	}
	if ($donation === ''){
		$emptyField = $emptyField . "Donation amount <br>";
	}
	if ($donor === ''){
		$emptyField = $emptyField . "Username <br>";
	}
	if ($donorPass === ''){
		$emptyField = $emptyField . "Password <br>";
	}
	echo '<span style="padding-top: 100px; padding-left:600px;"> Please fill information in for: <br>'. $emptyField;
}
else{

	$sql_username = "SELECT firstName, lastName FROM users WHERE userID='$userID'"; //get first and last name from users 
	$username_result = mysqli_query($con, $sql_username); //send query

	echo '<span style="padding-top: 100px; padding-left:600px;"> All fields correct <br>'. $emptyField;
	if ($username_result){// if user exists, maybe add confirmation?
		$row = mysqli_fetch_array($username_result);//makes the result an array
		echo "$row[0] $row[1] <br>";
	}
	//$username_num = mysqli_num_rows($username_result);
	//if ($usernameid != 0) { //If user exists
	//	$username_echo = '<span style="color:#e60000;text-align:center;">"There is user with that username.</span>'; // ...kill the script! 
	//}

	// database insert SQL code
	//$sql = "INSERT INTO `receipts` (`receiptID`, `userID`, `donorID`, `amount`) VALUES ('', '$userID', '$donor', '$donation')";

	// insert in database 
	//$rs = mysqli_query($con, $sql);
	//
	//if($rs)
	//{
	//	echo "Receipt Record Inserted";
	//}
	}
?>
	<form>
	 <input type="button" value="Go back" onclick="history.back()">
	</span><!--span for text and button to be aligned-->
	</form> 
</html>