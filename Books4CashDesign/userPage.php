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
include("includes/sidebar.php");
?>

<div class="container">
    <div class="row">
        <section class="col-md-6 col-md-offset-4" id="registration">
            <h1>Register</h1>
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


        </section>

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