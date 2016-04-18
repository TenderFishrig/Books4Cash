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
                <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i>
                                My Books</a></li>
                <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Inbox</a>
                        </li>
                <li><a href="send_message.php"><i class="glyphicon glyphicon-pencil"></i> Send A Message</a>
                        </li>
                </ul>
          </div>
          </div>
          </div>
        <div class="col-lg-9">
         <div class="panel panel-default">
          <div class="panel-heading">Message 
          </div>
    
      <table class="table table-hover">
          <thead>
              <!-- <tr>
                  <th>From</th>
                  <th>Time Sent</th>
                  <th>Title</th>
                  <th>Message</th>
              </tr> -->
          </thead>
          <tbody>

             
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
                        try {
                            // Establishing a connection to the database
                            $conn = new DBCommunication();
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
                            echo "<tr>";
                            echo "<td><ul class='list-group'>";
                            echo "<li class='list-group-item'><strong>From: </strong>". $sender . "<span class='pull-right'>" . $date . "</span></li>";
                            echo "<li class='list-group-item'><strong>Title: </strong>" . $title . "</li>";
                            echo "<li class='list-group-item'><strong>Message: </strong>" . $message_text . "</li>";
                            echo "</ul></td>";
                            // echo "<td style='width:20%'><span class='pull-right'>" . $date . "</span></td>";
                            echo "</tr>";
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
 
    </tbody>
      </table>
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