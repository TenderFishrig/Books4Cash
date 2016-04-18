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

<div class="container showAdvert">
    <div class="panel panel-default">
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

            $query = "SELECT tag_description FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                . "WHERE whwp_Advert.advert_id = :advert_id "
                . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id";
            $conn->prepQuery($query);
            $conn->bind('advert_id', $advert_id);
            $tags = $conn->resultset();

            if($_SESSION['user_id'] == $user)
            {
                echo "<div class='panel-heading'>" . $title . "<a href='editAdvert.php?advert_id=$advert_id'><span style='float:right' class='glyphicon glyphicon-edit' id='adEdit'></span></a></div>";

            }
            else{
                echo "<div class='panel-heading'>" . $title . "</div>";
            }

            echo "<div class='panel-body'>";
            ?>
            <article class="search-result row">
                <div class="col-xs-12 col-sm-12 col-md-3">
                    <?php
                    if(!empty($image)) {
                        foreach ($image as $element) {
                            echo '<a href="#" title="Lorem ipsum" class="thumbnail"><img src="thumbnails/' . $element->image_location . '" /></a>';
                        }
                    }
                    else {
                        echo '<a href="#" title="Lorem ipsum" class="thumbnail"><img src="thumbnails/default.png" /></a>';
                    }
                    ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2">
                    <ul class="meta-search">
                        <li><i class="glyphicon glyphicon-calendar"></i> <span><?php echo $date; ?></span></li>
                        <li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
                        <li><i class="glyphicon glyphicon-tags"></i> <span>Tags:</span>
                        <?php foreach($tags as $item){
                            echo '<br><span>'.$item->tag_description.'</span>';
                        }?></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                    <h2>Description</h2>
                    <p><?php echo $description; ?></p>

                </div>
                <span class="clearfix borda"></span>
            </article>
            <?php
            echo "<p><strong>Price:</strong> " . $price . "£</p>";
            echo "<p><strong>Author:</strong> " . $author . "</p>";
            echo "<p><strong>Posted by:</strong>" . $username . "</p>";

            echo "</div>";
            echo "</div>";


        }
        catch(PDOException $e){
            echo 'Something went wrong';
        }
        ?>

        <div class="panel panel-default">

            <div class="panel panel-heading">
                Comments
            </div>
            <div class="panel panel-body">
                <form action="<?php "showAdvert.php?advert_id=$advert_id" ?>"
                      method="post">
                    <div class="form-group">
                        <textarea name="comment" rows="5" cols='50' placeholder="Type your comment here"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit_comment" value="Post Comment!" class="btn btn-default custombutton">
                    </div>
                </form>
                <hr/>

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
                                //header("refresh:3;url='showAdvert.php?advert_id=$advert_id'");
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

                    $query = "SELECT ac.*, whwp_User.user_username FROM whwp_User, whwp_Comment AS ac WHERE ac.comment_advert = :advert_id "
                        . "AND whwp_User.user_id = ac.comment_author";
                    $conn -> prepQuery($query);
                    $conn -> bind('advert_id', $advert_id);
                    $comment=$conn -> resultset();
                    ?>



                    <?php

                    foreach ($comment as $element)
                    {
                        //$timePosted = $comment -> date_time;
                        $username = $element -> user_username;
                        $comm = $element -> comment_contents;
                        //echo $timePosted . "<br/>";
                        echo "<div id=\"comment\"><p>" .$comm . "</p><div id=\"postedBy\"><p>Posted by:"  . $username .
                            "</p><p>On: " . "</p></div></div>";

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
