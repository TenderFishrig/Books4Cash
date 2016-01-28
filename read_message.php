<?php
session_start();
include 'DBCommunication.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Read message</title>
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
                    // Check if the user is logged in
                    if(!isset($_SESSION['user_id']))
                    {
                        echo "You need to log in first!";
                        header( "refresh:3;url=login.php" );
                    }
                    else
                    {
                        // Check who is logged in
                        $user_id = $_SESSION['user_id'];
                        // Get the message id that the user wishes to open
                        $message_id = $_GET['message_id'];
                        // Establishing a connection to the database
                        $conn = new DBCommunication();
                        try {
                            // Query to get a message
                            $query = "SELECT * FROM whwp_Message WHERE :user_id = message_recipient ";
                            $conn->prepQuery($query);
                            $conn->bind('user_id',$user_id);
                            $message = $conn->single();
                            //$sender_id = $message -> receiver_id;
                            // Check if the specified message belongs to the logged in user
                            //if($user_id == $sender_id)
                            //{
                            $sender_id = $message->message_sender;
                            // Query to get the sender's username.
                            $query = "SELECT user_firstname FROM whwp_User WHERE user_id = :user";
                            $conn->prepQuery($query);
                            $conn->bind('user',$sender_id);
                            $resultset = $conn->single();
                            // Get and output all the details.
                            $sender = $resultset->user_firstname;
                            $title = $message->message_subject;
                            $message_text = $message->message_content;
                            $date = $message->message_date;
                            //$sent = $message -> seen;
                            echo "From: " . $sender . "&nbsp &nbsp &nbsp &nbsp ";
                            echo "Time sent: " . $date . "<br/>";
                            echo $title . "<br/>";
                            echo $message_text;

                            // Mark the message as seen
//                            $query3 = "UPDATE message SET seen = 'y' WHERE message_id = :message_id";
//                            $prepared_statement3 = $conn -> prepare($query3);
//                            $prepared_statement3 -> bindValue(':message_id', $message_id);
//                            $prepared_statement3 -> execute();
//                            // If no such message (invalid ID) then redirect the user
//                            $count = $prepared_statement -> rowCount();
//                            if($count == 0)
//                            {
//                                header('Location: messages.php');
//                            }
                            //}
                            // If message belongs to another user (not logged in), redirect the user.
//                        else
//                        {
//                            header('Location: messages.php');
//                        }
                        }
                        catch (PDOException $e){
                            echo 'Something went wrong.';
                        }
                    }
                ?>    
            </div>    
            <div id="footer">
                
            </div> 
        </div>
    </body>
</html>