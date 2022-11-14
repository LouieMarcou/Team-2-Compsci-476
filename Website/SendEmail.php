<?php
$message=$_POST["message"];
$subject=$_POST["subject"];
$sender=$_POST["email"];
$name=$_POST["fullName"];
if($message)
{
	mail("your@email.address" , $subject, 
	
	$message, $sender);
}



?>
