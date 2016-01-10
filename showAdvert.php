<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Advertisement</title>
        <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <meta HTTP-EQUIV="Expires" CONTENT="-1">
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <div id="container">
            
            <div id="header">
                <img src="images/logo.png" alt="logo"/>
                <div id="form">
                    <h2>Search our database:</h2>
                    <form action="search.php" method="get">
                        <label for="search">Enter your search term</label>
                        <input type="text" name="search" id="search" value="<?php 
                            if (isset($_GET['search'])) echo $_GET['search']; ?>">
                        <input type="submit" name="Search" value="Search">
                    </form>
                </div> 
                <a id='post' href='post.php'><img src="images/post.png" alt="post" title='post'/></a>
                 
            </div>
            <div id="menu">
                <a href='#'>Advanced Search</a>&nbsp;&nbsp;
                <a href='#'>Contact Us</a>&nbsp;&nbsp;
                <?php
                    if(isset($_SESSION['username']))
                    {
                        $username = $_SESSION['username'];
                        echo "You are logged in as " . $username . "&nbsp;&nbsp;";
                        echo "<a href='logout.php'>Log Out</a>";
                    }   
                    else
                    {
                        echo "<a href='register.php'>Sign Up</a>&nbsp;&nbsp;";
                        echo "<a href='login.php'>Log In</a>";
                    }
                ?>
            </div>
            <div id="content">
                <?php
                    // Establishing a connection to the database
                    try
                    {
                        $conn = new PDO('mysql:host=localhost;dbname=books4cash', 'root', '');
                    }
                    catch (PDOException $exception) 
                    {
                        echo "There was a problem " . $exception -> getMessage();
                    }
                    // Getting the id of the advertisement
                    $advert_id = $_GET['advert_id'];
                    
                    // Getting the id of the logged in user if he is logged in.
                    if(isset($_SESSION['user_id']))
                    {    
                        $user_id = $_SESSION['user_id'];
                    }
                    
                    $query = "SELECT * FROM ad, ad_description, user "
                            . "WHERE ad.advert_id = ad_description.advert_id "
                            . "AND ad.advert_id = :advert_id "
                            . "AND ad.user_id = user.user_id";
                    $prepared_statement = $conn -> prepare($query);
                    $prepared_statement -> bindValue(':advert_id', $advert_id);
                    $prepared_statement -> execute();
                    $resultset = $prepared_statement -> fetch(PDO::FETCH_OBJ);
                    $price = $resultset -> price;
                    $title = $resultset -> title;
                    $image = $resultset -> image;
                    $user = $resultset -> user_id;
                    $username = $resultset -> username;
                    $description = $resultset -> description;
                    if ($image !== "")
                    {
                        echo "<img src=".$image." alt=".$title." title=".$title."<br/>";
                    }
                    else
                    {
                        echo "No image (make this a default photo or something) <br/>";
                    }
                    echo "Price: " . $price . "<br/>";
                    echo "Title: " . $title . "<br/>";
                    echo "Description: " . $description . "<br/>";
                    echo "Posted by: <a href='user.php?user_id=$user'>" . $username . "</a><br/>";
                    echo "<hr/>";
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
                    if(isset($_POST['submit_comment']))
                    {
                        $date_time = gmdate('Y-m-d H:i:s');
                        if(isset($_SESSION['user_id']))
                        {
                            //$user_id = $_SESSION['user_id'];
                            if(!empty($_POST['comment']))
                            {
                                $comment = $_POST['comment'];
                                $query3 = "INSERT INTO ad_comment (advert_id, user_id, comment, date_time) "
                                        . "VALUES (:advert_id, :user_id, :comment, :date_time)";
                                    $prepared_statement3 = $conn -> prepare($query3);
                                    $prepared_statement3 -> bindValue(':advert_id', $advert_id);
                                    $prepared_statement3 -> bindValue(':user_id', $user_id);
                                    $prepared_statement3 -> bindValue(':comment', $comment);
                                    $prepared_statement3 -> bindValue(':date_time', $date_time);
                                    $prepared_statement3 -> execute();
                                    if ($prepared_statement3 -> rowCount() > 0)
                                    {
                                            echo "Your comment was posted!";
                                            header( "refresh:3;url='showAdvert.php?advert_id=$advert_id'" );
                                    }
                                    else
                                    {
                                            echo "Something went wrong...";
                                    }
                            }
                            else
                            {
                                echo "Your comment cannot be empty!";
                            }
                        }
                        else
                        {
                            echo "Only those who have logged in can post comments!<br/>";
                            echo "<a href='login.php'>Click here to enter login page.</a>";
                        }
                    }
                    echo "<hr/><br/>";
                    
                    $query2 = "SELECT ac.*, user.username FROM user, ad_comment AS ac WHERE ac.advert_id = :advert_id "
                            . "AND user.user_id = ac.user_id ORDER BY date_time";
                    $prepared_statement2 = $conn -> prepare($query2);
                    $prepared_statement2 -> bindValue(':advert_id', $advert_id);
                    $prepared_statement2 -> execute();
                    while ($comment = $prepared_statement2 -> fetch(PDO::FETCH_OBJ))
                    {
                        $timePosted = $comment -> date_time;
                        $username = $comment -> username;
                        $comm = $comment -> comment;
                        echo $timePosted . "<br/>";
                        echo $username . "<br/>";
                        echo $comm . "<br/>";
                        echo "<hr/>";
                    }
                ?>
            </div>    
            <div id="footer">
                
            </div> 
        </div>
    </body>
</html>
