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
				<img src="Pictures/CornerSide_Logo_Nov_16th_(002).png" width="30%" height="30%">
			</span>
			<span style="float:right; margin-right:25px;">
				<a href="Index.html">Home</a>
				<a href="Sponsors.html">Sponsors</a>
				<a href="Donate.html">Donate</a>
				<a href="LogIn.html">Log In</a>
                <a href="CreateUser.html">Create Account</a>
			    <a href="About.html">About</a>
			</span>
		</div>
        <div>
            <style>
                .answers {
                    color: #5A5A5A;
                    font-size: 20px;
                }
                .description {
                    color: #000000;
                    font-size: 30px;
                }
            </style>
<?php

    try{
        $db = mysqli_connect('localhost', 'root', '', 'cornersidehelp');
    }
    catch(mysqli_sql_exception $e) {
        echo "Error!: " . $e->getmessage() . "<br>";
    }

    //CONNECTION TO DATABASE 

    $mode = "";


    try {
        if(isset($_GET['mode'])) {
            $mode = $_GET['mode'];
        }
    

        switch ($mode) {
            case 'displayProfile':
                include('Profile.html');

                if ((isset($_POST['username']) && (isset($_POST['password'])))) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $pHash = password_hash($password, PASSWORD_DEFAULT);
                }

                $parameters = [
                    ":username" => $username,
                    "pHash" => $pHash
                ];

                $sql = 'SELECT `firstName`, `lastName`, `accountBalance`, `city`, `shelterID` FROM `users` WHERE `username` = :username AND `pHash` = :pHash';


                break;

            case 'createUser':
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city']) && isset($_POST['shelterID'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                    $shelter = $_POST['shelterID'];
                }

                $sqlUserNameCheck = "SELECT * FROM users WHERE username = '$username'";

                $result = $db->query($sqlUserNameCheck);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<span style="padding-top: 200px;"> Username Already Used! <br>';
                    } else {
                        $sql = 'INSERT INTO users(firstName, lastName, city, shelterID, pHash, username) 
                        VALUES (?,?,?,?,?,?)';

                        $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                        $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method
                        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID); //hashes the password using Argon2ID hashing algorithm
                        
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('ssssss', $firstName, $lastName, $city, $shelter, $pwd_hashed, $username);
                        $stmt->execute();

                        echo "<span style='padding-top: 200px;'> User Created! <br><input type='button' value='Go back' onclick='history.back()''";
                    }
                }
        
                break;

            case 'createDonor':
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                }

                $sqlUserNameCheck = "SELECT * FROM donors WHERE username = '$username'";

                $result = $db->query($sqlUserNameCheck);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<span style="padding-top: 200px;"> Username Already Used! <br>';
                    } else {
            
                        $sql = 'INSERT INTO donors(firstName, lastName, city, pHash, username) 
                        VALUES (?,?,?,?,?)';
                    
                        $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                        $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method
                        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID); //hashes the password using Argon2ID hashing algorithm
                        
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('sssss', $firstName, $lastName, $city, $pwd_hashed, $username);
                        $stmt->execute();

                        echo "<span style='padding-top: 200px;'> Donor Created! <br><input type='button' value='Go back' onclick='history.back()''";
                    }
                }
                break;

            case 'loginUser':
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                };

                $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method using the password revceived from login

                $sqlPassword = "SELECT pHash FROM users WHERE username = '$username'";

                $sql_pwd_hashed = $db->query($sqlPassword); 

                $row = $sql_pwd_hashed->fetch_assoc(); //fetch the sql pHash of username
                $pwd_hashed = $row['pHash'];

                if (password_verify($pwd_peppered, $pwd_hashed)) { //compare the hashed password with the database password
                    $sql = "SELECT firstName, lastName, accountBalance, city, username FROM users WHERE username = '$username'";
                    
                    $result = $db->query($sql);

                    if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<span style='padding-top: 200px;'>
                                    <h1>Welcome Back " . $row['firstName']. "!".
                                    "<p class= 'description' >Username: </p>" . "<p class= 'answers'>". $row["username"].
                                    "<br><p class= 'description' >First Name: </p>" . "<p class= 'answers'>" . $row["firstName"].
                                    "<br><p class= 'description' >Last Name: </p>" . "<p class= 'answers'>" . $row["lastName"]. 
                                    "<br><p class= 'description' >City: </p>" . "<p class= 'answers'>" . $row["city"].
                                    "<br><p class= 'description' >Account Balance: " . "<p class= 'answers'>" . "$". $row["accountBalance"];
                                }
                          } 
                          else {
                                echo "<span style='padding-top: 200px;'> No records has been found <br><input type='button' value='Go back' onclick='history.back()''>";
                          }
                }
                else {
                    echo "<span style='padding-top: 200px;'> Password is incorrect. <br><input type='button' value='Go back' onclick='history.back()''>";
                }

                break;

                case 'loginDonor':
                    if (isset($_POST['username']) && isset($_POST['password'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                    };
    
                    $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                    $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method using the password revceived from login
    
                    $sqlPassword = "SELECT pHash FROM donors WHERE username = '$username'";
    
                    $sql_pwd_hashed = $db->query($sqlPassword);
    
                    $row = $sql_pwd_hashed->fetch_assoc(); //fetch the sql pHash of username
                    $pwd_hashed = $row['pHash'];
                    $check = password_verify($pwd_peppered, $pwd_hashed);

                    if (password_verify($pwd_peppered, $pwd_hashed)) { //compare the hashed password with the database password
                        $sql = "SELECT firstName, lastName, city, username FROM donors WHERE username = '$username'";
                        
                        $result = $db->query($sql);
    
                        if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<span style='padding-top: 200px;'>
                                        <h1>Welcome Back " . $row['firstName']. "!".
                                        "<p class= 'description' >Username: </p>" . "<p class= 'answers'>". $row["username"] . 
                                        "<br><p class= 'description' >First Name: </p>" . "<p class= 'answers'>" . $row["firstName"]. 
                                        "<br><p class= 'description' >Last Name: </p>" . "<p class= 'answers'>" . $row["lastName"]. 
                                        "<br><p class= 'description' >City: </p>" . "<p class= 'answers'>" . $row["city"];
                                    }
                              } 
                              else {
                                    echo "<span style='padding-top: 200px;'> No records has been found <br><input type='button' value='Go back' onclick='history.back()''>";
                              }
                    }
                    else {
                        echo "<span style='padding-top: 200px;'> Password is incorrect. <br><input type='button' value='Go back' onclick='history.back()''>";
                    }
    
                    break;
            default:
                
        }
    }
    catch (PDOException $e) {
        echo "Error!: " . $e->getmessage() . "<br>";
        die();
    } 
?>
        </div>
<form>
	</span><!--span for text and button to be aligned-->
	</form> 
</html>