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
				<img src="Pictures/CornerSide_Logo_Nov_16th_(002).png" width="20%">
			</span>
			<span style="float:right; font-size:2vw; margin-right:25px;">
				<a href="index.html">Home</a>
				<a href="Sponsors.html">Sponsors</a>
				<a href="Donate.html">Donate</a>
				<a href="LogIn.html">Log In</a>
			</span>
		</div>

<?php
//Dummy username: cornersidehelper
//Dummy password: CShlp41^23
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','cornersidehelp');
//$con = mysqli_connect('localhost', 'root', '','cornersidehelp');
//mysql credentials = root
$response = "";

// get the post records
$userID = "";
if (isset($_POST['userID'])) {
	$userID = $_POST['userID'];
}
$donation = "";
if (isset($_POST['donation'])) {
	$donation = floatval($_POST['donation']);
}
// guest button is pressed
$donor = "";
if (isset($_POST['donor'])) {
	$donor = $_POST['donor']; 
	// $donor = "guest"; 
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
		// need to check password
		//if (password) {
			//get account balance
			//$sql_userAccountBal = "SELECT accountBalance FROM users WHERE userID = '$userID'";
			//$balance_result = mysqli_query($con, $sql_userAccountBal);
			//$account_balance = mysqli_fetch_array($balance_result);
			//$new_balance = $donation + floatval($account_balance[0])
	//using stripe the command would ...
			//		$sql_addDonation = "UPDATE users SET accountBalance = $new_balance WHERE userID = 'userID'";
			//		$process_donation = mysqli_query($con, $sql_addDonation);
	//	}
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