<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta charset="utf-8">
    <meta name="description" content="A page for buying and selling books">


    <title>Account</title>
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
                <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Messages</a>
                        </li>
                </ul>
          </div>
          </div>
          </div>

         <div class="col-lg-9 panel panel-default" id="registration">
            <div class="panel-heading">Edit profile</div>
            <div class="panel-body">
            <form role="form" id="dataUpdateForm" action="includes/updateImportant.php">
            
                <div class="form-group">
                    <label for="firstname">First name:</label>
                    <input type="text" class="form-control" name="firstname" id="firstname">
                </div>


                <div class="form-group">
                    <label for="surname">Last name:</label>
                    <input type="text" class="form-control" name="surname" id="surname">
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" name="city" id="city">
                </div>

                <div class="form-group">
                    <label for="old_password">Password:</label>
                    <input type="password" class="form-control" name="old_password" id="old_password">
                </div>

                <div id="importantFields">

                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" name="email" class="form-control" id="email" disabled="true">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" class="form-control" name="password" id="password" disabled="true">
                    </div>

                    <div class="form-group" id="confirmation">
                        <label for="confirm_password">Re-enter new password:</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" disabled="true">
                    </div>
                </div>

                <button id="cancel" onclick="updateView()" type="button" class="btn btn-default">Cancel</button>

                <button id="submit" type="submit" class="btn btn-default">Update All</button>
                
            </form>
            </div>
        </div>
    
</div>
</div>


<footer>
    <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
</footer>

<script src="js/bootstrap/jquery-2.2.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom scripts/EffectsIndex.js"></script>
<script src="js/bootstrap/bootstrap-notify.min.js"></script>
<script src="js/custom scripts/userPageScript.js"></script>

</body>
</html>