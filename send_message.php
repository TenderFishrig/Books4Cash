<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Send message</title>
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
                    $receiver = "";
                    if(!isset($_SESSION['target_id']))
                    {
                        echo "Invalid request";
                    }
                    else
                    {
                        $receiver_id = $_SESSION['target_id'];
                        // Establishing a connection to the database
                        try
                        {
                            $conn = new PDO('mysql:host=localhost;dbname=wehope', 'wehope', 'l4ndofg10ry');
                        }
                        catch (PDOException $exception) 
                        {
                            echo "There was a problem " . $exception -> getMessage();
                        }
                        $query = "SELECT whwp_User.user_firstname FROM whwp_User WHERE whwp_User.user_id = :receiver_id";
                        $prepared_statement = $conn -> prepare($query);
                        $prepared_statement -> bindValue(':receiver_id', $receiver_id);
                        $prepared_statement -> execute();
                        $username = $prepared_statement -> fetch(PDO::FETCH_OBJ);
                        $receiver = $username -> user_firstname;
                    }
                ?>
                <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post"
                    <label for="title">Recipient:</label>
                    <input type="text" id="title" name="recipient" value="<?php echo $receiver; ?>" disabled/><br/><br/>
                      
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title"><br/><br/>    
                    <label for="message">Your message:</label>
                    <textarea name="message" rows="5" cols='50'></textarea><br/><br/>
                    <input type="submit" name="send" value="Send Message!" />
                </form>
                <?php
                    if(!isset($_SESSION['user_id']))
                    {
                        echo "You need to log in to send a message!";
                        header( "refresh:0;url=login.php" );
                    }   
                    else
                    {
                        if(isset($_POST['send']))
                        {
                            if(!empty([$_POST['title']]))
                            {
                                if(isset($_POST['message']) && !empty($_POST['message'])) 
                                {
                                    $sender_id = $_SESSION['user_id'];
                                    $title = $_POST['title'];
                                    $message = $_POST['message'];
                                    $time_sent = gmdate('Y-m-d H:i:s');
                                    
                                    // Running the queries
                                    $query2 = "INSERT INTO whwp_Message (message_sender, message_recipient, "
                                                . "message_subject, message_content, message_time,message_date) VALUES "
                                                . "(:sender_id, :receiver_id, :title, :content, :time_sent, :date_sent)";
                                    $prepared_statement2 = $conn -> prepare($query2);
                                    $prepared_statement2 -> bindValue(':sender_id', $sender_id);
                                    $prepared_statement2 -> bindValue(':receiver_id', $receiver_id);
                                    $prepared_statement2 -> bindValue(':title', $title);
                                    $prepared_statement2 -> bindValue(':time_sent', $time_sent);
                                    $prepared_statement2 -> bindValue(':content',$message);
                                    $prepared_statement2 -> bindValue(':date_sent',$time_sent);
                                    $prepared_statement2 -> execute();
                                    
//                                    $query3 = "SELECT message_id FROM message ORDER BY message_id DESC LIMIT 1";
//                                    $prepared_statement3 = $conn -> prepare($query3);
//                                    $prepared_statement3 -> bindValue(':text', $message);
//                                    $prepared_statement3 -> execute();
//                                    $resultset = $prepared_statement3 -> fetch(PDO::FETCH_OBJ);
//                                    $message_id = $conn->lastInsertId();
                                    
//                                    $query4 = "INSERT INTO message_text (message_id, text) VALUES "
//                                                . "(:message_id, :text)";
//                                    $prepared_statement4 = $conn -> prepare($query4);
//                                    $prepared_statement4 -> bindValue(":message_id", $message_id);
//                                    $prepared_statement4 -> bindValue(':text', $message);
//                                    $prepared_statement4 -> execute();
                                    // Give the user some feedback
                                    if ($prepared_statement2 -> rowCount() > 0)
                                    {
                                        echo "Message sent!";
                                    }
                                    else
                                    {
                                        echo "Something went wrong...";
                                    }
                                }  
                                else
                                {
                                    echo "Can't send an empty message!";
                                }                                
                            }
                            else
                            {
                                echo "Enter a title!";
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