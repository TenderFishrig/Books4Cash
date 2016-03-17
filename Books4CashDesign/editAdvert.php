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
            <h1>Edit advert.</h1>
            <form role="form" id="advertUpdateForm">

                <?php
                    if(isset($_GET['advert_id'])){
                        echo "<input id='advert_id' type='hidden' name='advert_id' value='".$_GET['advert_id']."'>";
                    }
                    else {
                        echo "<input id='advert_id' type='hidden' name='advert_id' value='0'>";
                    }
                ?>

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
                    <label for="tag0">Tag 1*:</label>
                    <input class="form-control" type="text" id="tag0" maxlength="50" name="tag0">
                </div>

                <div class="form-group">
                    <input class="form-control" type="submit" name="submit" value="Update ad!" />
                </div>
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
<script src="js/custom scripts/advertEdit.js"></script>

</body>
</html>