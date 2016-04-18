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

if(isset($_SESSION['user_id']))
{

    include("includes/loggedMenu.php");

}

?>


<div class="container"><!--Ad form-->
    <div class="row">
        <div class="panel panel-default col-lg-offset-3" id="adPanel">
                <div class="panel-heading">Post an Ad</div>
                <div class="panel-body">
            <form id="postForm" action="includes/post.php" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="title">Title*:</label>
                    <input class="form-control" type="text" id="title" name="title">
                </div>

                <div class="form-group">
                    <label for="author">Author:</label>
                    <input class="form-control" type="text" id="author" name="author">
                </div>

                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="1">Not Set</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condition:</label>
                    <select name="condition" id="condition">
                        <option value="1">New</option>
                        <option value="2">Used</option>
                        <option value="3">Poor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price*:</label>
                    <div class="input-group">
                        <input class="form-control" type="number" min="0" max="1000" step="0.01" id="price" name="price">
                        <div class="input-group-addon">£</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description*:</label><br>
                    <textarea id="description" name="description" rows="5" cols='50'></textarea>
                </div>

                <div class="form-control-file">
                    <label for="photo">Photo:</label>
                    <input type="file" name="image" id="image" multiple accept="image/x-png, image/jpeg, image/jpg" />
                </div>


                <div class="form-group">
                    <label for="tag1">Tag 1*:</label>
                    <input class="form-control" type="text" id="tag1" maxlength="50" name="tag1">
                </div>

                <div class="form-group">
                    <input class="form-control" type="submit" name="submit" value="Submit ad!" />
                </div>

            </form>
        </div>
        </div>
    <!-- </div> -->

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

