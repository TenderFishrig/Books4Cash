<?php
session_start();
require 'DBCommunication.php';
header('Content-type: application/json');
$response_array=array('success' => false,'error_code' => 0,'message'=>'');
try {
    // Connect to the database
    $conn = new DBCommunication();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM whwp_User WHERE user_username = :username";
    $conn->prepQuery($query);
    $conn->bind('username', $username);
    if ($user = $conn->single()) {
        if (password_verify($password, $user->user_password))//(crypt($password, $user -> salt) == $user -> password)
        {
            if (password_needs_rehash($user->user_password, PASSWORD_DEFAULT)) {
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "UPDATE whwp_User SET user_password=(:hashed_password) WHERE user_username=(:username)";
                $conn->prepQuery($query);
                $conn->bindArrayValue(array('hashed_password' => $new_hash, 'username' => $user->username));
                $conn->execute();
            }
            // echo "Congratulations! You have logged in on our website!";
            $_SESSION['user_id'] = $user->user_id;
            $_SESSION['username'] = $user->user_username;
            $user_id = $_SESSION['user_id'];
            if (isset($_POST['rememberme'])) // Does NOT work!!
            {
                $identifier = hash('md5', $username);
                $randomString = openssl_random_pseudo_bytes(64);
                $token = bin2hex($randomString);
                $query = "UPDATE whwp_User SET user_indentifier = :identifier, user_token = :token WHERE user_id = :user_id";
                $conn->prepQuery($query);
                $conn->bindArrayValue(array('identifier'=>$identifier,'token'=>$token,'user_id'=>$user_id));
                $conn->execute();

                $cookie_name = 'Books4Cash';
                $cookie_value = $identifier .",". $token;
                $cookie_length = time() + 31536000; // 1 Year long.
                setcookie($cookie_name, $cookie_value, $cookie_length, "/");
            }
            $response_array['success']=true;
        } else {
            $response_array['error_code']=1;
        }
    } else {
        $response_array['error_code']=1;
    }
}
catch(PDOException $e){
    $response_array['error_code']=2;
    $response_array['message']=$e->getMessage();
}
echo json_encode($response_array);
?>