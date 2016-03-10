<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta charset="utf-8">
    <meta name="description" content="A page for buying and selling books">


    <title>Post an Ad</title>
</head>

<body>

<?php

if(isset($_SESSION['username']))
{

    include("includes/loggedMenu.php");

}

include("includes/sidebar.php");
?>

<header class="banner">
    <div class= "container-fluid">
        <p class="container-fluid">Books4Cash</p>
    </div>
</header>


<div class="container"><!--Ad form-->

    <div class="row">
        <section class="col-xs-6 col-md-4 col-md-offset-3" id="adspace">

            <form id="postForm" action="includes/post.php" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input class="form-control" type="text" id="title" name="title">
                </div>

                <div class="form-group">
                    <label for="price">Price:</label>
                    <div class="input-group">
                        <input class="form-control" type="number" min="0" step="0.01" id="price" name="price">
                        <div class="input-group-addon">£</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" rows="5" cols='50'></textarea>
                </div>

                <div class="form-control-file">
                    <label for="photo">Photo:</label>
                    <input type="file" name="image" id="image" multiple accept="image/x-png, image/gif, image/jpeg, image/jpg" />
                </div>


                <div>
                    <div class="form-group">
                        <label for="tag1">Tag 1:</label>
                        <input class="form-control" type="text" id="tag1" maxlength="50" name="tag1">
                    </div>

                    <div class="form-group">
                        <input class="form-control" type="submit" name="submit" value="Submit ad!" />
                    </div>

            </form>
        </section>
    </div>

</div><!--Ad form-->

<footer>
    <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
</footer>

<script src="js/bootstrap/jquery-2.2.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom scripts/EffectsIndex.js"></script>
<script src="js/bootstrap/bootstrap-notify.min.js"></script>
<script src="js/custom scripts/postScript.js"></script>

</body>
</html>

