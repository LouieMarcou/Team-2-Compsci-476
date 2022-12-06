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
				<img src="Pictures/Cornerside_Logo_Nov_16th_002.png" width="20%">
			</span>
			<span style="float:right; font-size:2vw; margin-right:25px;">
				<a href="index.html">Home</a>
				<a href="Sponsors.html">Sponsors</a>
				<a href="Donate.html">Donate</a>
				<a href="LogIn.html">Log In</a>
			</span>
		</div>
<?php

    //ALTER TABLE users
    //MODIFY COLUMN ID INTEGER NOT NULL AUTO_INCREMENT;

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


                

                // $pageTitle = 'Profile';
                // $columns = array("");
                // displayResultSet($pageTitle, $reultSet, $columns);

                break;

            case 'createUser':
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                }
        
                $sql = 'INSERT INTO users(firstName, lastName, city, pHash, username) 
                VALUES (?,?,?,?,?)';

                $pepper = get_cfg_var("pepper");
                $pwd_peppered = hash_hmac("sha256", $password, $pepper);
                $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
        
                //$pHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare($sql);
                $stmt->bind_param('sssss', $firstName, $lastName, $city, $pwd_hashed, $username);
                $stmt->execute();
                break;

            case 'createDonor':
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                }
            
                $sql = 'INSERT INTO donors(firstName, lastName, city, pHash, username) 
                VALUES (?,?,?,?,?)';
            
                $pHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare($sql);
                $stmt->bind_param('i', $var);
                $stmt->execute();
                break;

            case 'loginUser':
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                };


                $sql = "SELECT firstName, lastName, city, username FROM users WHERE username = '$username' AND pHash = '$pHash'";


                $result = $db->query($sql);
                //mysqli_stmt_bind_param()
                //$stmt->bind_param('ss', $username, $password);
                //$stmt = $db->prepare($sql);
                //$stmt->bind_param('sssss', $firstName, $lastName, $city, $pHash, $username);
                //$result = $stmt->execute();

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "username: " . $row["username"]. " - lastName: " 
                          . $row["fisrtName"]. " " . $row["lastName"]. "<br>";
                    }
              } 
              else {
                    echo "No records has been found";
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
<form>
	</span><!--span for text and button to be aligned-->
	</form> 
</html>