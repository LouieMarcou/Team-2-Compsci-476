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

    // $user = 'belschneal15';
    // $pass = 'ab3993';
    // $db_info = 'mysql:dbname=cornersidehelp;host=cs.uww.edu';
    //$db_info = 'mysql:host=cs.uww.edu;dbname=cornersidehelp';
    $testdb = new PDO('mysql:host=localhost;dbname=cornersidehelp', 'root','');
    echo '<p>in</p>';
    $db = mysqli_connect('localhost', 'root', '', 'cornersidehelp');
        echo '<p> here </p>';
        if(!$db) {
            echo '<p> failed </p>';
        }

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $city = $_POST['city'];
        }

        $sql = 'INSERT INTO users(firstName, lastName, city, pHash, username) 
        VALUES (:firstName,:lastName,:city,:pHash,:username)';

        $pHash = password_hash($password, PASSWORD_DEFAULT);

        $parameters = [
            ":firstName" => $firstName,
            ":lastName" => $lastName,
            ":city" => $city,
            ":pHash" => $pHash,
            "username" => $username
        ];
        mysqli_query($db, $sql);
        echo('here');

    // try {
    //     $db = mysqli_connect('localhost', 'root', '', 'cornersidehelp');
    //     echo '<p> here </p>';
    //     if(!$db) {
    //         echo '<p> failed </p>';
    //     }
    //     //$db = new PDO($db_info, $user, $pass);
    // }
    // catch (PDOException $e) {
    //     print "Error!: " . $e->getmessage() . "<br>";
    //     die();
    // }

    //CONNECTION TO DATABASE 

    // $mode = "";

    // try {
    //     if(isset($_GET['mode'])) {
    //         $mode = $_GET['mode'];
    //     }
    

    //     switch ($mode) {
    //         case 'displayProfile':
    //             include('Profile.html');

    //             if ((isset($_POST['username']) && (isset($_POST['password'])))) {
    //                 $username = $_POST['username'];
    //                 $password = $_POST['password'];
    //                 $pHash = password_hash($password, PASSWORD_DEFAULT);
    //             }

    //             $parameters = [
    //                 ":username" => $username,
    //                 "pHash" => $pHash
    //             ];

    //             $sql = 'SELECT `firstName`, `lastName`, `accountBalance`, `city`, `shelterID` FROM `users` WHERE `username` = :username AND `pHash` = :pHash';

    //             $resultSet = prep($sql, $db, $parameterValues);

                

    //             // $pageTitle = 'Profile';
    //             // $columns = array("");
    //             // displayResultSet($pageTitle, $reultSet, $columns);

    //             break;

    //         case 'createUser':

    //             $sql = 'INSERT INTO `users`(`firstName`, `lastName`, `city`, `pHash`, `username`) 
    //             VALUES (:firstName,:lastName,:city,:pHash,:username)';

    //             if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
    //                 $username = $_POST['username'];
    //                 $password = $_POST['password'];
    //                 $firstName = $_POST['firstName'];
    //                 $lastName = $_POST['lastName'];
    //                 $city = $_POST['city'];
    //             }

    //             $pHash = password_hash($password, PASSWORD_DEFAULT);

    //             $parameters = [
    //                 ":firstName" => $firstName,
    //                 ":lastName" => $lastName,
    //                 ":city" => $city,
    //                 ":pHash" => $pHash,
    //                 "username" => $username
    //             ];
    //             mysqli_query($db, $sql);
    //             echo('here');
    //             //$stmt = $db->prepare($sql);

    //             // if($stmt->execute($parameters)) {
    //             //     echo "Created New User";
    //             // } else {
    //             //     $stmt->error;
    //             // }
    //             break;
    //         default:
                
    //     }
    // }
    // catch (PDOException $e) {
    //     echo "Error!: " . $e->getmessage() . "<br>";
    //     die();
    // } 
?>
<form>
	</span><!--span for text and button to be aligned-->
	</form> 
</html>

<?php
    function prep ($sql, $db, $parameterValues =null) {
        $statement = $db->prepare($sql);

        $statement->execute($parameterValues);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

?>