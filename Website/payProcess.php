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
			</span>
		</div>

        <p id="demo"></p>

	<?php
        include 'processDonation.php';
        if (isset($_POST['Verify'])){
            $con = mysqli_connect('localhost', 'root', '','cornersidehelp');
            //$donation = $_GET['donation'];

            //$userID = $_GET['userID'];
        //get account balance
            $sql_userAccountBal = "SELECT accountBalance FROM users WHERE userID = '$userID'";
            $balance_result = mysqli_query($con, $sql_userAccountBal);
            $account_balance = mysqli_fetch_array($balance_result);
            $new_balance = floatval($donation) + floatval($account_balance[0]);
            
            $sql_addDonation = "UPDATE users SET accountBalance = $new_balance WHERE userID = '$userID'";
            $process_donation = mysqli_query($con, $sql_addDonation);

            echo '<script>alert("Paymeny Sent!")</script>';
        }
    ?>
</html>