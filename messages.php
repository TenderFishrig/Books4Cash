<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>All messages</title>
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Expires" CONTENT="-1">
        <link rel="stylesheet" type="text/css" href="style.css"/>
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
                <?php
                    // Check if anyone is logged in
                    if(!isset($_SESSION['user_id']))
                    {
                        echo "You need to log in first!";
                        header( "refresh:3;url=login.php" );
                    }
                    else
                    {
                        // Check which user is logged in
                        $user_id = $_SESSION['user_id'];
                        // Establishing a connection to the database
                        try
                        {
                            $conn = new PDO('mysql:host=localhost;dbname=books4cash', 'root', '');
                        }
                        catch (PDOException $exception) 
                        {
                            echo "There was a problem " . $exception -> getMessage();
                        }
                        // Getting messages from the database
                        /*$query = "SELECT * FROM message, message_text WHERE :user_id = receiver_id "
                                . "AND message.message_id = message_text.message_id";*/
                        $query = "SELECT * FROM message WHERE :user_id = receiver_id ORDER BY time_sent DESC";
                        $prepared_statement = $conn -> prepare($query);
                        $prepared_statement -> bindValue(':user_id', $user_id);
                        $prepared_statement -> execute();
                        $countMessages = $prepared_statement -> rowCount();
                        if($countMessages == 0)
                        {
                            echo "You have no messages in your inbox!";
                        }
                        else
                        {
                            echo "<h3>Your inbox:</h3>";
                            echo "<table class='table'>";  
                            echo "<tr><th>Sender:</th><th>Title:</th>"
                                . "<th>Time Sent:</th></tr>";
                            while($message = $prepared_statement -> fetch(PDO::FETCH_OBJ))
                            {
                                $message_id = $message -> message_id;
                                $sender_id = $message -> sender_id;
                                $query2 = "SELECT username FROM user WHERE user_id = :user";
                                $prepared_statement2 = $conn -> prepare($query2);
                                $prepared_statement2 -> bindValue(':user', $sender_id);
                                $prepared_statement2 -> execute();
                                $resultset = $prepared_statement2 -> fetch(PDO::FETCH_OBJ);
                                $sender = $resultset -> username;
                                $title = $message -> title;
                                $date = $message -> time_sent;
                                $seen = $message -> seen;
                                if($seen == 'n')
                                {
                                    echo "<tr class='seen'>";
                                    
                                }
                                else
                                {
                                    echo "<tr>";
                                }
                                echo "<td>". $sender ."</td>";
                                if($seen == 'n')
                                {
                                    echo "<td><a class='seen' href='read_message.php?message_id=" . $message_id . "'>" . $title . "</a></td>";
                                } 
                                else
                                {
                                    echo "<td><a href='read_message.php?message_id=" . $message_id . "'>" . $title . "</a></td>";
                                }
                                echo "<td>". $date ."</td>";
                                echo "</tr>";
                                
                            }
                            echo "</table>";
                        }
                    }
                ?>    
            </div>    
            <div id="footer">
                
            </div> 
        </div>
    </body>
</html>