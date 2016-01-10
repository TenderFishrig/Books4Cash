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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <div id="container">
            
        <div id="header">
            <img src="images/logo.png" alt="logo"/>
            <div id="form">
                <h2>Search our database:</h2>
                <form action="search.php" method="get">
                    <label for="search">Enter your search term</label>
                    <input type="text" name="search" id="search" value="<?php 
                        if (isset($_GET['search'])) echo $_GET['search']; ?>">
                    <input type="submit" name="Search" value="Search">
                </form>
            </div> 
            <a id='post' href='post.php'><img src="images/post.png" alt="post" title='post'/></a>
             
        </div>
        <div id="menu">
            <a href='#'>Advanced Search</a>&nbsp;&nbsp;
            <a href='#'>Contact Us</a>&nbsp;&nbsp;
            <?php
                if(isset($_SESSION['username']))
                {
                    $username = $_SESSION['username'];
                    echo "You are logged in as " . $username . "&nbsp;&nbsp;";
                    echo "<a href='logout.php'>Log Out</a>";
                }   
                else
                {
                    echo "<a href='register.php'>Sign Up</a>&nbsp;&nbsp;";
                    echo "<a href='login.php'>Log In</a>";
                }
            ?>
        </div>
        <div id="content">
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <label for="password" >Password:</label>
                <input type="password" id="password" name="password">
                <input type="submit" name="register" value="Register">
            </form>    
           
            <?php
                if(isset($_POST['register']))
                {
                    // Connect to the database
                    try
                    {
                        $conn = new PDO('mysql:host=localhost;dbname=books4cash', 'root', '');
                    }
                    catch (PDOException $exception) 
                    {
                        echo "Oh no, there was a problem" . $exception -> getMessage();
                    }
                    // Get typed in values and add needed signs.
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    // Check if such username does not exist.
                    $query = "SELECT * FROM user WHERE username = :username";
                    $prepared_statement = $conn -> prepare($query);
                    $prepared_statement -> bindValue(':username', $username);
                    $prepared_statement -> execute();
                    if ($prepared_statement -> rowCount() > 0)
                    {
                        echo "This username is already taken.";
                        //header( "refresh:6;url=login.php" );
                    }
                    else
                    {
                        //$salt = get_salt();
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        // Insert these values into a database.
                        $query = "INSERT INTO user (username, password) VALUES (:username, :hashed_password)";
                        $prep_stmt = $conn -> prepare($query);
                        $prep_stmt -> bindValue(':username', $username);
                        $prep_stmt -> bindValue(':hashed_password', $hashed_password);
                        //$prep_stmt -> bindValue(':salt', $salt);
                        $prep_stmt -> execute();
                        // Give the user some feedback
                        if ($prep_stmt -> rowCount() > 0)
                        {
                            echo "Congratulations! You have registered on our website!";
                            header( "refresh:6;url=login.php" );
                        }
                        else
                        {
                            echo "Something went wrong...";
                        }
                    }
                }
            ?>    
        </div>
        <div id="footer">
                
        </div>        
    </div>



</body>
</html>
