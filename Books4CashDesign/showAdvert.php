<?php
session_start();
include "includes/DBCommunication.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Advertisement</title>
    <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <meta HTTP-EQUIV="Expires" CONTENT="-1">
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
    <meta name="description" content="A page for buying and selling books">

</head>
<body>
<div class="container">
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

<?php
// Getting the id of the advertisement
$advert_id = $_GET['advert_id'];

// Getting the id of the logged in user if he is logged in.
if(isset($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
}

try {
    // Establishing a connection to the database
    $conn = new DBCommunication();
    $query = "SELECT * FROM whwp_Advert, whwp_User "
        . "WHERE whwp_Advert.advert_id = :advert_id "
        . "AND whwp_User.user_id = whwp_Advert.advert_owner";
    $conn->prepQuery($query);
    $conn->bind('advert_id',$advert_id);
    $resultset = $conn->single();
    $price = $resultset->advert_price;
    $title = $resultset->advert_bookname;
    //$image = $resultset -> image;
    $date = $resultset->advert_date;
    $author = $resultset->advert_bookauthor;
    $user = $resultset->advert_owner;
    $username = $resultset->user_username;
    $description = $resultset -> advert_description;

    $query = "SELECT whwp_Image.image_location FROM whwp_Advert "
        . "JOIN whwp_AdImage ON whwp_Advert.advert_id = whwp_AdImage.adimage_advert "
        . "JOIN whwp_Image ON whwp_AdImage.adimage_image = whwp_Image.image_id "
        . "WHERE whwp_Advert.advert_id = :advert_id";
    $conn->prepQuery($query);
    $conn->bind('advert_id',$advert_id);
    $image=$conn->resultset();
    foreach ($image as $element) {
       // echo "<img src = 'thumbnails/" . ($element->image_location) . "' alt='" . $title . "' title='" . $title . "'>";
        echo "<a href='uploadedImages/" . ($element->image_location) . "' target='_blank'><img src='thumbnails/" . ($element->image_location) . "'></a><br/>";
    }
    echo "Price: " . $price . "<br/>";
    echo "Title: " . $title . "<br/>";
    echo "Author: " . $author . "<br/>";
    echo "Date Posted: " . $date . "<br/>";
    echo "Description: " . $description . "<br/>";
    echo "Posted by: <a href='user.php?user_id=$user'>" . $username . "</a><br/>";

    if($_SESSION['user_id'] == $user)
    {
        echo "<a href='editForm.php?advert_id=$advert_id'>" . "Edit this advertisement" . "</a><br/>";
    }
    echo "<hr/>";
}
catch(PDOException $e){
    echo 'Something went wrong';
}
?>
<div id="form2">
    <h2>Post a comment:</h2>
    <form action="<?php "showAdvert.php?advert_id=$advert_id" ?>"
          method="post">
        <label for="comment">Your comment:</label>
        <textarea name="comment" rows="5" cols='50'></textarea>
        <input type="submit" name="submit_comment" value="Post Comment!">
    </form>
    <hr/>
</div>
<?php
try {
    if(isset($_POST['submit_comment']))
    {
        $date_time = gmdate('Y-m-d H:i:s');
        if(isset($_SESSION['user_id']))
        {
            //$user_id = $_SESSION['user_id'];
            if(!empty($_POST['comment']))
            {
                $comment = $_POST['comment'];

                $query = "INSERT INTO whwp_Comment ( comment_advert, comment_author, comment_contents) "
                    . "VALUES (:advert_id, :user_id, :comment)";
                $conn->prepQuery($query);
                $conn->bindArrayValue(array('advert_id'=>$advert_id,'user_id'=>$user_id,'comment'=>$comment));
                //$prepared_statement3 -> bindValue(':date_time', $date_time);
                $conn->execute();
                echo "Your comment was posted!";
                header("refresh:3;url='showAdvert.php?advert_id=$advert_id'");
            }
            else
            {
                echo "Your comment cannot be empty!";
            }
        }
        else
        {
            echo "Only those who have logged in can post comments!<br/>";
            //echo "<a href='includes/login.php'>Click here to enter login page.</a>";
        }
    }
    echo "<hr/><br/>";

    $query = "SELECT ac.*, whwp_User.user_username FROM whwp_User, whwp_Comment AS ac WHERE ac.comment_advert = :advert_id "
        . "AND whwp_User.user_id = ac.comment_author";
    $conn -> prepQuery($query);
    $conn -> bind('advert_id', $advert_id);
    $comment=$conn -> resultset();
    foreach ($comment as $element)
    {
        //$timePosted = $comment -> date_time;
        $username = $element -> user_username;
        $comm = $element -> comment_contents;
        //echo $timePosted . "<br/>";
        echo $username . "<br/>";
        echo $comm . "<br/>";
        echo "<hr/>";
    }
}
catch(PDOException $e) {
    echo "Something went wrong...";
}
?>
</div>

</div>
</div>
</div>

<div id="footer">

<footer>
    <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
</footer>
</div>

</body>
</html>
