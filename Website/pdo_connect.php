<?php

$user = 'root';
$pass = ''; 
$db_info='mysql:host=localhost;dbname=cornersidehelp';
try {
    $db = new PDO($db_info, $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

#$sql = "SELECT firstName FROM `donors`";
#$statement = $db->prepare($sql);
#$statement->execute();

?>