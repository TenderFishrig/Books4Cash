<?php
//function get_salt()
//{
//    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//    $salt='$2a$10$';
//    for($i=0; $i<22; $i++)
//    {
//        $random_char= $chars[mt_rand(0,strlen($chars))];
//        $salt.=$random_char;
//    }
//    $salt.=$random_char."$";
//    return $salt;
//}
session_start();
include 'DBCommunication.php';
//                if(isset($_SESSION['username']))
//                {
//                    $username = $_SESSION['username'];
//                    echo "You are logged in as " . $username . "&nbsp;&nbsp;";
//                    echo "<a href='logout.php'>Log Out</a>";
//                }
//                else
//                {
//                    echo "<a href='register.php'>Sign Up</a>&nbsp;&nbsp;";
//                    echo "<a href='login.php'>Log In</a>";
//                }
//
if (isset($_REQUEST['username']) && isset($_REQUEST['password']) && isset($_REQUEST['email'])) {
    // Get typed in values and add needed signs.
    $database = new DBCommunication();
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $email = $_REQUEST['email'];
    // Check if such username does not exist.
    $query = "SELECT * FROM whwp_User WHERE user_firstname = :username";
    $database->prepQuery($query);
    $database->bind('username', $username);
    $database->execute();
    if ($database->rowCount() > 0) {
        echo "Email already in use.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Insert these values into a database.
        $query = "INSERT INTO whwp_User (user_firstname, user_email, user_password, user_ismoderator) VALUES (:username,:email, :hashed_password, 0)";
        $database->prepQuery($query);
        $database->bindArrayValue(array('username' => $username, 'hashed_password' => $hashed_password, 'email' => $email));
        $database->execute();
        if ($database->rowCount() > 0) {
            echo "Congratulations! You have registered on our website!";
        } else {
            echo "Something went wrong...";
        }
    }

} else
    echo "Error";
?>
