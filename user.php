<?php
session_start();
include "DBCommunication.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User page</title>
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
        $conn = new DBCommunication();
        if(isset($_GET['user_id']))
        {
            try {
                // Get the ID of which user's page to display
                $user_id = $_GET['user_id'];
                // Run query to get information about the user.
                $query = "SELECT * FROM whwp_User WHERE user_id = :user_id";
                $conn->prepQuery($query);
                $conn->bind('user_id',$user_id);
                $user = $conn->single();
                $username = $user->user_firstname;
                echo "The page of " . $username;
                // Set the target as a private message receiver
                $_SESSION['target_id'] = $user_id;
                // If the user is not in his own page - displaay the link to PM
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $user_id) {
                    echo "<a href='send_message.php'><img src='images/pm.png' id='pm' alt='Private Message' title='Private Message'/></a>";
                }
                // Query to get all the ads from the user, whose page is accessed.
                $query = "SELECT * FROM whwp_Advert WHERE advert_owner = :user_id";
                $conn->prepQuery($query);
                $conn->bind('user_id', $user_id);
                $ad=$conn->resultset();
                $countAds = $conn->rowCount();
                if ($countAds == 0) {
                    echo "<br/>No adverts uplaoded by this user!";
                } else {
                    echo "<h2>Ads uploaded by: " . $username . ":</h2>";
                    foreach ($ad as $element) {
                        $advert_id = $element->advert_id;
                        $price = $element->advert_price;
                        $title = $element->advert_bookname;
                        echo "<p><a href ='showAdvert.php?advert_id=$advert_id'>" . $title . " " . $price . "</a></p>";

                    }
                }
            }
            catch(PDOException $e){
                echo "Something went wrong.";
            }
        }
        else
        {
            echo "No user selected!";
        }
        ?>
    </div>
    <div id="footer">

    </div>
</div>
</body>
</html>
    
