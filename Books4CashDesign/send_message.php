<?php
session_start();
include "includes/DBCommunication.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Send message</title>
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Expires" CONTENT="-1">
        <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        
    </head>
    <body>
       <?php

if(isset($_SESSION['user_id']))
{

    include("includes/loggedMenu.php");

}

else
{

    include("includes/menu.php");

}


?>
            
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
                        try {
                            $conn = new DBCommunication();
                            $query = "SELECT whwp_User.user_firstname FROM whwp_User WHERE whwp_User.user_id = :receiver_id";
                            $conn->prepQuery($query);
                            $conn->bind('receiver_id', $receiver_id);
                            $username = $conn->single();
                            $receiver = $username->user_firstname;
                        }
                        catch(PDOException $e){
                            echo 'Something went wrong';
                        }
                    }
                ?>
<div class="container" id="userContent">
<div class="row">
<div class="col-lg-3">
          <div class="panel panel-default">
          <div class="panel-heading">My Account
          </div>
          <div class="panel-body">
               <ul class="nav nav-list">
                <li class="usermenuActive"><a href="userSettings.php"><i class="glyphicon glyphicon-user"></i> Edit profile</a>
                </li>
                <li><a href="userPage.php"><i class="glyphicon glyphicon-list-alt"></i>
                                My Books</a></li>
                <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Inbox</a>
                        </li>
                        <li><a href="send_message.php"><i class="glyphicon glyphicon-pencil"></i> Send a Message</a>
                        </li>
                </ul>
          </div>
          </div>
          </div>
<div class="col-lg-9">
   <div class="panel panel-default">
   <div class="panel-heading">Send a Private Message</div>
   <div class="panel-body">
        <form class="form-inline" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" >
                    <div class="form-group">                
                    <label for="title">Recipient:</label>
                    <input type="text" id="title" name="recipient" value="<?php echo $receiver; ?>" disabled/>
                    </div>
                    <div class="form-group"> 
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title"> 
                    </div>  
                    <div class="form-group"> 
               
                    <textarea id="messageBox" name="message" rows="5" cols='40'></textarea>
                    </div>
                    <div class="form-group"> 
                    <buttom class="btn btn-default custombutton" type="submit" name="send" value="Send Message!" >Send Message!</buttom>
                    </div>
                </form>


      
        </div>    
        </div>
    
</div>
</div>

               
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

                                    try {
                                        // Running the queries
                                        $query = "INSERT INTO whwp_Message (message_sender, message_recipient, "
                                            . "message_subject, message_content, message_time,message_date) VALUES "
                                            . "(:sender_id, :receiver_id, :title, :content, :time_sent, :date_sent)";
                                        $conn->prepQuery($query);
                                        $conn->bindArrayValue(array('sender_id'=>$sender_id,'receiver_id'=>$receiver_id,
                                            'title'=>$title,'time_sent'=>$time_sent,'content'=>$message,'date_sent'=>$time_sent));
                                        $conn->execute();
                                        // Give the user some feedback
                                        echo "Message sent!";
                                    }
                                    catch(PDOException $e){
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
           <footer>
                <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
            </footer>
        
    </body>
    <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom scripts/EffectsIndex.js"></script>
<script src="js/bootstrap/bootstrap-notify.min.js"></script>
<script src="js/custom scripts/postScript.js"></script>
</html>