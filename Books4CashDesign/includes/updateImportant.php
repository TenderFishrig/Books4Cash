<?php
session_start();
require 'DBCommunication.php';
require 'crypting.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code'=>array(),'message' => '');

try {
    if(isset($_POST['password']) && isset($_SESSION['user_id'])) {

        $conn = new DBCommunication();
        $conn->beginTransaction();
        $user_id = $_SESSION['user_id'];
        $password=$_POST['password'];
        $query = "SELECT user_password FROM whwp_User WHERE user_id = :user_id";
        $conn->prepQuery($query);
        $conn->bind('user_id', $user_id);
        $password_hash=$conn->single();

        if (password_verify($password, $password_hash->user_password))
        {
            if (password_needs_rehash($password_hash->user_password, PASSWORD_DEFAULT)) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE whwp_User SET user_password=(:hashed_password) WHERE user_id=(:user_id)";
                $conn->prepQuery($query);
                $conn->bindArrayValue(array('hashed_password' => $new_hash, 'user_id' => $user_id));
                $conn->execute();
            }
            if (isset($_POST['email'])) {
                if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    array_push($response_array['error_code'], 5);
                }
                else {
                    $query = "UPDATE whwp_User SET user_email = :email WHERE user_id = :user_id";
                    $conn->prepQuery($query);
                    $email = encrypt($_POST['email']);
                    $conn->bindArrayValue(array('email' => $email, 'user_id' => $user_id));
                    $conn->execute();
                }
            }

            if(isset($_POST['new_password'])){
                $new_password=$_POST['new_password'];
                if(strlen($new_password)>=6){
                    $query = "UPDATE whwp_User SET user_password = :password WHERE user_id = :user_id";
                    $conn->prepQuery($query);
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $conn->bindArrayValue(array('password' => $hashed_password, 'user_id' => $user_id));
                    $conn->execute();
                }
                else {
                    array_push($response_array['error_code'], 4);
                }
            }

            $response_array['success'] = true;

            $conn->endTransaction();
        } else {
            array_push($response_array['error_code'], 3);
        }
    }
    else {
        array_push($response_array['error_code'], 2);
    }
}
catch (PDOException $e){
    $conn->cancelTransaction();
    array_push($response_array['error_code'], 1);
    $response_array['message']=$e->getMessage();
}
echo json_encode($response_array);