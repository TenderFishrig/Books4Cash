<?php
session_start();
include 'DBCommunication.php';
//                if(isset($_POST['login']))
//                {
header('Content-type: application/json');
$response_array=array('success' => false,'error_code' => 0,'message'=>'');
try {
    // Connect to the database
    $conn = new DBCommunication();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM whwp_User WHERE user_email = :username";
    $conn->prepQuery($query);
    $conn->bind('username', $username);
    if ($user = $conn->single()) {
        if (password_verify($password, $user->user_password))//(crypt($password, $user -> salt) == $user -> password)
        {
            if (password_needs_rehash($user->user_password, PASSWORD_DEFAULT)) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE whwp_User SET user_password=(:hashed_password) WHERE user_email=(:username)";
                $conn->prepQuery($query);
                $conn->bindArrayValue(array('hashed_password' => $new_hash, 'username' => $user->username));
                $conn->execute();
            }
            // echo "Congratulations! You have logged in on our website!";
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['username'] = $user->user_email;
            $response_array['success']=true;
            echo json_encode($response_array);
        } else {
            $response_array['error_code']=1;
            echo json_encode($response_array);
            //header("Location: https://selene.hud.ac.uk/u1467200/login.php");
        }
    } else {
        $response_array['error_code']=1;
        echo json_encode($response_array);
        //header("Location: ../index.php");
    }
}
catch(PDOException $e){
    $response_array['error_code']=2;
    $response_array['message']=$e->getMessage();
    echo json_encode($response_array);
}
//                }
?>