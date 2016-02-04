<?php
session_start();
include 'DBCommunication.php';
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
                        // Getting messages from the database
                        /*$query = "SELECT * FROM message, message_text WHERE :user_id = receiver_id "
                                . "AND message.message_id = message_text.message_id";*/
                        try {
                            // Establishing a connection to the database
                            $conn = new DBCommunication();
                            $query = "SELECT * FROM whwp_Message WHERE :user_id = message_recipient ORDER BY message_date,message_time DESC";
                            $conn->prepQuery($query);
                            $conn->bind('user_id', $user_id);
                            $message = $conn->resultset();
                            $countMessages = $conn->rowCount();
                            if ($countMessages == 0) {
                                echo "You have no messages in your inbox!";
                            } else {
                                echo "<h3>Your inbox:</h3>";
                                echo "<table class='table'>";
                                echo "<tr><th>Sender:</th><th>Title:</th>"
                                    . "<th>Time Sent:</th></tr>";
                                foreach ($message as $element) {
                                    $message_id = $element->message_id;
                                    $sender_id = $element->message_sender;
                                    $query = "SELECT user_firstname FROM whwp_User WHERE user_id = :user";
                                    $conn->prepQuery($query);
                                    $conn->bind('user', $sender_id);
                                    $resultset = $conn->single();
                                    $sender = $resultset->user_firstname;
                                    $title = $element->message_subject;
                                    $date = $element->message_time;
                                    $seen = 'n'; //$message -> seen;!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
                                    if ($seen == 'n') {
                                        echo "<tr class='seen'>";

                                    } else {
                                        echo "<tr>";
                                    }
                                    echo "<td>" . $sender . "</td>";
                                    if ($seen == 'n') {
                                        echo "<td><a class='seen' href='read_message.php?message_id=" . $message_id . "'>" . $title . "</a></td>";
                                    } else {
                                        echo "<td><a href='read_message.php?message_id=" . $message_id . "'>" . $title . "</a></td>";
                                    }
                                    echo "<td>" . $date . "</td>";
                                    echo "</tr>";

                                }
                                echo "</table>";
                            }
                        }
                        catch (PDOException $e){
                            echo "Something went wrong.";
                        }
                    }
                ?>    
            </div>    
            <div id="footer">
                
            </div> 
        </div>
    </body>
</html>