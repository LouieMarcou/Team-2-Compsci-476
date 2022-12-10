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
			</span>
		</div>
        <div>
<?php

    try{
        $db = mysqli_connect('localhost', 'root', '', 'cornersidehelp', '4306');
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
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                }

                $sqlUserNameCheck = "SELECT * FROM users WHERE username = '$username'";

                $result = $db->query($sqlUserNameCheck);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        echo 'Username Already Used!';
                    } else {
                        $sql = 'INSERT INTO users(firstName, lastName, city, pHash, username) 
                        VALUES (?,?,?,?,?)';

                        $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                        $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method
                        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID); //hashes the password using Argon2ID hashing algorithm
                        
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('sssss', $firstName, $lastName, $city, $pwd_hashed, $username);
                        $stmt->execute();
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
                        echo 'Username Already Used!';
                    } else {
            
                        $sql = 'INSERT INTO donors(firstName, lastName, city, pHash, username) 
                        VALUES (?,?,?,?,?)';
                    
                        $pepper = get_cfg_var("pepper"); //grabs pepper variable from config file
                        $pwd_peppered = hash_hmac("sha256", $password, $pepper); //Generates  a keyed hash value using the HMAC method
                        $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID); //hashes the password using Argon2ID hashing algorithm
                        
                        $stmt = $db->prepare($sql);
                        $stmt->bind_param('sssss', $firstName, $lastName, $city, $pwd_hashed, $username);
                        $stmt->execute();
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
                                  echo "Username: " . $row["username"]. "<br>First Name: " 
                                      . $row["firstName"]. "<br>Last Name:" . $row["lastName"]. 
                                      "<br>City: " . $row["city"].
                                      "<br>Account Balance: $" . $row["accountBalance"];
                                }
                          } 
                          else {
                                echo "No records has been found <input type='button' value='Go back' onclick='history.back()''>";
                          }
                }
                else {
                    echo "Password is incorrect. <input type='button' value='Go back' onclick='history.back()''>";
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
    
                    if (password_verify($pwd_peppered, $pwd_hashed)) { //compare the hashed password with the database password
                        $sql = "SELECT firstName, lastName, city, username FROM donors WHERE username = '$username'";
                        
                        $result = $db->query($sql);
    
                        if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "Username: " . $row["username"]. "<br>First Name: " 
                                        . $row["firstName"]. "<br>Last Name:" . $row["lastName"]. 
                                        "<br>City: " . $row["city"];
                                    }
                              } 
                              else {
                                    echo "No records has been found <input type='button' value='Go back' onclick='history.back()''>";
                              }
                    }
                    else {
                        echo "Password is incorrect. <input type='button' value='Go back' onclick='history.back()''>";
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