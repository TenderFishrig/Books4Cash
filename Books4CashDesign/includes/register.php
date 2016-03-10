<?php
/*
 * Error codes:
 * 1 - Username already used.
 * 2 - Email already used.
 * 3 - Database error.
 * 4 - Invalid post information.
 * 5 - Invalid email formating.
 * 6 - Password too short.
 *
 */

//TODO create separete
session_start();
require 'DBCommunication.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code'=>array(),'message' => '');
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    // Get typed in values and add needed signs.
    try {
        $database = new DBCommunication();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        // Check if such username does not exist.
        $query = "SELECT * FROM whwp_User WHERE user_username = :username";
        $database->prepQuery($query);
        $database->bind('username', $username);
        $database->execute();
        $usernameuse=$database->rowCount();
        $query = "SELECT * FROM whwp_User WHERE user_email = :email";
        $database->prepQuery($query);
        $database->bind('email', $email);
        $database->execute();
        $emailuse=$database->rowCount();
        if ($username > 0) {
            array_push($response_array['error_code'], 1);
        }
        if($emailuse > 0 ) {
            array_push($response_array['error_code'], 2);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($response_array['error_code'], 5);
        }
        if(strlen($password)<6){
            array_push($response_array['error_code'], 6);
        }
        if(strlen($password))
            if(empty($response_array['error_code'])) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                // Insert these values into a database.
                $query = "INSERT INTO whwp_User (user_username, user_email, user_password, user_ismoderator) VALUES (:username,:email, :hashed_password, 0)";
                $database->prepQuery($query);
                $database->bindArrayValue(array('username' => $username, 'hashed_password' => $hashed_password, 'email' => $email));
                $database->execute();
                if ($database->rowCount() > 0) {
                    $response_array['success']=true;
                }
            }
        echo json_encode($response_array);
    }
    catch(PDOException $e){
        array_push($response_array['error_code'], 3);
        $response_array['message']=$e->getMessage();
        echo json_encode($response_array);
    }
} else {
    array_push($response_array['error_code'], 4);
    echo json_encode($response_array);
}
?>
