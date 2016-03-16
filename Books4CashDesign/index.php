<?php
session_start();
require 'includes/DBCommunication.php';
if(isset($_COOKIE['Books4Cash']))
{
    try {
        $database = new DBCommunication();
        $explodedCookie = explode(",", $_COOKIE['Books4Cash']);
        $identifier = $explodedCookie[0];
        $token = $explodedCookie[1];
        $query = "SELECT user_username, user_token FROM whwp_User WHERE user_indentifier = :identifier";
        $database->prepQuery($query);
        $database->bind('identifier', $identifier);
        $user = $database->single();
        if ($database->rowCount() > 0) {
            $username = $user->user_username;
            $user_token = $user->user_token;
            if ($token == $user_token) {
                $_SESSION['username'] = $username;
            }
        }
    }
    catch(PDOException $e){

    }
}
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
	  <meta charset="utf-8">
	  <meta name="description" content="A page for buying and selling books">
	

	  <title>Books4Cash</title>
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

    include("includes/sidebar.php");
   ?>
     
     
       
          <header class="banner">
             <div class= "container-fluid">
             <p class="container-fluid">Books4Cash</p>
             </div>
          </header>
           
           
     <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
     </footer>

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>

  </body>
</html>

