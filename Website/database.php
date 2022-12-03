
<?php
    $user = 'belschneal15';
    $pass = 'ab3993';
    $db_info = 'mysql:dbname=cornersidehelp;host=cs.uww.edu';
    //$db_info = 'mysql:host=cs.uww.edu;dbname=cornersidehelp';

    try {
        $db = mysqli_connect('localhost', 'root', '', 'cornerside');
        //$db = new PDO($db_info, $user, $pass);
    }
    catch (PDOException $e) {
        print "Error!: " . $e->getmessage() . "<br>";
        die();
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

                $resultSet = prep($sql, $db, $parameterValues);

                

                // $pageTitle = 'Profile';
                // $columns = array("");
                // displayResultSet($pageTitle, $reultSet, $columns);

                break;

            case 'createUser':

                $sql = 'INSERT INTO `users`(`firstName`, `lastName`, `city`, `pHash`, `username`) 
                VALUES (:firstName,:lastName,:city,:pHash,:username)';

                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['city'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $firstName = $_POST['firstName'];
                    $lastName = $_POST['lastName'];
                    $city = $_POST['city'];
                }

                $pHash = password_hash($password, PASSWORD_DEFAULT);

                $parameters = [
                    ":firstName" => $firstName,
                    ":lastName" => $lastName,
                    ":city" => $city,
                    ":pHash" => $pHash,
                    "username" => $username
                ];
                mysqli_query($db, $sql);
                //$stmt = $db->prepare($sql);

                if($stmt->execute($parameters)) {
                    echo "Created New User";
                } else {
                    $stmt->error;
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

<?php
    function prep ($sql, $db, $parameterValues =null) {
        $statement = $db->prepare($sql);

        $statement->execute($parameterValues);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

?>