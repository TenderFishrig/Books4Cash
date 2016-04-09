<?php
session_start();
include "includes/DBCommunication.php";
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta charset="utf-8">
    <meta name="description" content="A page for buying and selling books">
  

    <title>Registration</title>
  </head>
  
  <body>
  
   <?php 
   if(isset($_SESSION['user_id']))
{

    include("includes/loggedMenu.php");

}

include("includes/sidebar.php");
?>


     <div class="container">
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
                <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Messages</a>
                        </li>
                </ul>
          </div>
          </div>
          </div>
        <div class="col-lg-9">
         <div class="panel panel-default">
          <div class="panel-heading">Your Inbox
          </div>
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
                                echo "<table class='table'>";
                                echo "<tr><th>Sender</th><th>Title</th>"
                                    . "<th>Time Sent</th></tr>";
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
           </div>
     </div><!--registration container-->

      

      <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
      </footer>

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>
     <script src="js/custom scripts/registrationScript.js"></script>

     
  </body>
</html>