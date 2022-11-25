<?php
$message=$_POST["message"];
$subject=$_POST["subject"];
$sender=$_POST["email"];
$name=$_POST["fullName"];
$recipent = "marcoulouie@gmail.com";

function sendEmail()
{
	if($message)
	{
		mail($recipent , $subject, 
		
		$message, $sender);
	}
}

?>
<?php

	sendEmail();

?>
<!-- endline -->


