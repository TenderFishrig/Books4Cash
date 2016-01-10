<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
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
                    <input type="submit" name="login" value="Log In">
                </form>    
                <?php

                if(isset($_POST['login']))
                {
                    // Connect to the database
                    try
                    {
                        $conn = new PDO('mysql:host=localhost;dbname=wehope', 'wehope', 'l4ndofg10ry');
                    }
                    catch (PDOException $exception) 
                    {
                        echo "Oh no, there was a problem" . $exception->getMessage();
                    }
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $query = "SELECT * FROM whwp_User WHERE user_email = :username";
                    $prepared_statement = $conn -> prepare($query);
                    $prepared_statement -> bindValue(':username', $username);
                    $prepared_statement -> execute();
                    if($user = $prepared_statement -> fetch(PDO::FETCH_OBJ))
                    {
                        if (password_verify($password,$user->user_password))//(crypt($password, $user -> salt) == $user -> password)
                        {
                            if(password_needs_rehash($user->user_password, PASSWORD_DEFAULT))
                            {
                                $new_hash=password_hash($password, PASSWORD_DEFAULT);
                                $query = "UPDATE whwp_User SET user_password=(:hashed_password) WHERE user_email=(:username)";
                                $prep_stmt = $conn -> prepare($query);
                                $prep_stmt -> bindValue(':hashed_password', $new_hash);
                                $prep_stmt -> bindValue(':username',$user->username);
                                //$prep_stmt -> bindValue(':salt', $salt);
                                $prep_stmt -> execute();
                            }
                            echo "Congratulations! You have logged in on our website!";
                            $_SESSION['user_id'] = $user -> user_id;
                            $_SESSION['username'] = $user -> user_email;
                            header( "refresh:3;url=index.php" );
                        }
                        else
                        {
                            //header("Location: https://selene.hud.ac.uk/u1467200/login.php");
                        }
                    }
                    else
                    {
                        echo "Incorrect username!";
                    }

                }
                ?>
            </div>
            <div id="footer">

            </div>
        </div>    
    </body>
</html>


