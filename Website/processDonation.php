<!DOCTYPE html>
<html>
	<head>
	<!-- for the confirm button -->
	
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
				<img src="Pictures/Cornerside_Logo_Nov_16th_(002).png" width="20%">
			</span>
			<span style="float:right; font-size:2vw; margin-right:25px;">
				<a href="index.html">Home</a>
				<a href="Sponsors.html">Sponsors</a>
				<a href="Donate.html">Donate</a>
				<a href="LogIn.html">Log In</a>
				<a href="CreateUser.html">Create Account</a>
				<a href="About.html">About</a>
			</span>
		</div>
		
		
	
	<?php
		//echo '<script type="text/javascript">
     //  window.onload = function () { alert("Is this the amonut you want to donate?"); } 
		//</script>'; 
		//?>

<?php
// include 'payProcess.php';
//Dummy username: cornersidehelper
//Dummy password: CShlp41^23
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','cornersidehelp');
//$con = mysqli_connect('localhost', 'cornersidehelper', 'CShlp41^23','cornersidehelp'); // serrver
//mysql credentials = root
$emptyField = "";

// get the post records
$userID = "";

if (isset($_POST['userID'])) {
	$userID = $_POST['userID'];
}
$donation = "";
if (isset($_POST['donation'])) {
	$donation = ($_POST['donation']);
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
$guest = "";
if (isset($_POST['guest'])){
	$guest = $_POST['guest'];
}

function checkGuest($guest){
	if ($guest === "guest") {
		return true;
	}else {
		return false;
	}
}

//check fields are not empty
if (($userID === '' || $donation === '') && checkGuest($guest) ) {
	
	if ($userID === ''){
		$emptyField = $emptyField . "User ID <br>";
	}
	if ($donation === ''){
		$emptyField = $emptyField . "Donation amount <br>";
	}

	echo '<span style="padding-top: 200px;"> Please fill information in for: <br>'. $emptyField;
} 

else if (($userID === '' || $donation === '') && !checkGuest($guest)) {
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

	echo '<span style="padding-top: 200px;"> Please fill information in for: <br>'. $emptyField;
}

else{
	$sql_donorname = "SELECT username FROM donors WHERE username = '$donor'";
	$donorname_result = mysqli_query($con, $sql_donorname);
	$donorname_num = mysqli_num_rows($donorname_result);
	$sql_username = "SELECT firstName, lastName FROM users WHERE userID='$userID'"; //get first and last name from users 
	$username_result = mysqli_query($con, $sql_username); //send query
	$username_num = mysqli_num_rows($username_result);// check rows, if zero no results found

	if ($donorname_num == 0 && checkGuest($guest)) { //and check password
		echo '<span style="padding-top: 200px;"> Username not recognized please try again<br>';
	} 
	else if ($username_num == 0) { 
		echo '<span style="padding-top: 200px;"> The User ID entered does not exist in database <br>';
	}
	else {
		//if guest checkout
		if ($guest === "guest") {
			$donor = "guest";
		} else {
			$sql_getDonorID = "SELECT donorID FROM donors WHERE username = '$donor'";
			$donor_result = mysqli_query($con, $sql_getDonorID);
			$donor_found = mysqli_fetch_array($donor_result);
			$donor = $donor_found[0];
		}
		
		$row = mysqli_fetch_array($username_result); //makes the result an array
		echo '<span style="padding-top: 200px;">You donated ' . $donation . ' To ' . $row[0] . " " . $row[1];
		
		//get account balance
		$sql_userAccountBal = "SELECT accountBalance FROM users WHERE userID = '$userID'";
		$balance_result = mysqli_query($con, $sql_userAccountBal);
		$account_balance = mysqli_fetch_array($balance_result);
		$new_balance = floatval($donation) + floatval($account_balance[0]);
		
		$sql_addDonation = "UPDATE users SET accountBalance = $new_balance WHERE userID = '$userID'";
		$process_donation = mysqli_query($con, $sql_addDonation);

		//make receipt
		$sql_addReceipt = "INSERT INTO `receipts` (`receiptID`, `userID`, `donorID`, `amount`) VALUES ('', '$userID', '$donor', '$donation')";
		$process_receipt = mysqli_query($con, $sql_addReceipt);
		
	}
	
}
	

?>

	<form>
	 <input type="button" value="Go back" onclick="history.back()">
	</span><!--span for text and button to be aligned-->
	</form> 
</html>