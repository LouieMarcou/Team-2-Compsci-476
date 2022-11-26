<?php
// database connection code
// $con = mysqli_connect('localhost', 'database_user', 'database_password','database');

$con = mysqli_connect('localhost', 'root', '','cornersidehelp');

// get the post records
$userID = $_POST['userID'];
$donation = $_POST['donation'];
$donor = $_POST['donor']; //need donor ID

// database insert SQL code
$sql = "INSERT INTO `receipts` (`receiptID`, `userID`, `donorID`, `amount`) VALUES ('', '$userID', '$donor', '$donation')";

// insert in database 
$rs = mysqli_query($con, $sql);

if($rs)
{
	echo "Receipt Record Inserted";
}

?>