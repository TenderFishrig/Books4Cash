<?php
session_start();
include 'DBCommunication.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Post an ad</title>
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
        if(!isset($_SESSION['username']))
        {
            echo "You need to log in to post an ad!";
            header( "refresh:3;url=login.php" );
        }
        else
        {
            // Connect to the database
            ?>
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price"><br/><br/>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title"><br/><br/>
                <label for="description">Description:</label>
                <textarea name="description" rows="5" cols='50'></textarea><br/><br/>
                <label for="photo">Photo:</label>
                <input type="file" name="image" /><br/><br/>

                <label for="tag1">Tag 1:</label>
                <input type="text" id="tag1" maxlength="50" name="tag1"><br/>
                <label for="tag1">Tag 2:</label>
                <input type="text" id="tag2" maxlength="50" name="tag2"><br/>
                <label for="tag1">Tag 3:</label>
                <input type="text" id="tag3" maxlength="50" name="tag3"><br/>
                <label for="tag1">Tag 4:</label>
                <input type="text" id="tag4" maxlength="50" name="tag4"><br/>
                <label for="tag1">Tag 5:</label>
                <input type="text" id="tag5" maxlength="50" name="tag5"><br/><br/>
                <input type="submit" name="submit" value="Submit ad!" />
            </form>
            <?php
            if(isset($_POST['submit']))
            {
                if(!empty($_POST['price']) && !empty($_POST['title']) && !empty($_POST['description']))
                {
                    $tag1 = $_POST['tag1'];
                    $tag2 = $_POST['tag2'];
                    $tag3 = $_POST['tag3'];
                    $tag4 = $_POST['tag4'];
                    $tag5 = $_POST['tag5'];
                    if(!empty($tag1) || !empty($tag2) || !empty($tag3) || !empty($tag4) || !empty($tag5))
                    {
                        $price = $_POST['price'];
                        $title = $_POST['title'];
                        $description = $_POST['description'];
                        if(is_uploaded_file($_FILES['image']['tmp_name']))
                        {
                            $file = $_FILES['image']['name'];
                            $file_tmp = $_FILES['image']['tmp_name'];
                            $image = "itemPhotos/".basename($file); // Folder to move the file
                            move_uploaded_file($file_tmp, $image); // Move the uploaded file to the desired folder
                            $image = substr($image, 11);
                        }
                        else
                        {
                            $image = "";
                        }
                        try {
                            $conn = new DBCommunication();
                            $conn->beginTransaction();
                            // Get user, who is logged in and posting ad, id
                            $query = "SELECT user_id FROM whwp_User WHERE user_email = :username";
                            $conn->prepQuery($query);
                            $conn->bind('username', $username);
                            $resultset = $conn->single();
                            $user_id = $resultset->user_id;

                            // Insert some data to the database.
//                                    $query2 = "INSERT INTO whwp_advert (advert_owner, advert_price, advert_bookname, image) "
//                                    . "VALUES (:user_id, :price, :title, :image)";
                            $query = "INSERT INTO whwp_Advert (advert_owner, advert_price, advert_bookname, advert_date) "
                                . "VALUES (:user_id, :price, :title, :date)";
                            $conn->prepQuery($query);
                            $conn->bindArrayValue(array('user_id' => $user_id, 'price' => $price, 'title' => $title, 'date' => gmdate('Y-m-d')));
//                                    $prepared_statement2 -> bindValue(':image', $image);
                            $conn->execute();

                            // Get the auto generated advert_id.
//                                    $query3 = "SELECT advert_id FROM whwp_advert ORDER BY advert_id DESC LIMIT 1";
//                                    $prepared_statement3 = $conn -> prepare($query3);
//                                    $prepared_statement3 -> execute();
//                                    $resultset = $prepared_statement3 -> fetch(PDO::FETCH_OBJ);
//                                    $advert_id = $resultset -> advert_id;
                            $advert_id = $conn->lastInsertId();

                            // Insert image data into table
                            $query = "INSERT INTO whwp_Image (image_location) "
                                . "VALUES (:image)";
                            $conn->prepQuery($query);
                            $conn->bind('image', $image);
                            $conn->execute();
                            $image_id = $conn->lastInsertId();

                            //Create image-advert link
                            $query = "INSERT INTO whwp_AdImage (adimage_advert, adimage_image) "
                                . "VALUES (:advert, :image)";
                            $conn->prepQuery($query);
                            $conn->bindArrayValue(array('advert' => $advert_id, 'image' => $image_id));
                            $conn->execute();

                            // Insert data to the description table.
                            //Todo: add field to database
//                                    $query4 = "INSERT INTO ad_description (advert_id, description) "
//                                              . "VALUES (:advert_id, :description)";
//                                    $prepared_statement4 = $conn -> prepare($query4);
//                                    $prepared_statement4 -> bindValue(':advert_id', $advert_id);
//                                    $prepared_statement4 -> bindValue(':description', $description);
//                                    $prepared_statement4 -> execute();

                            // Create array and store all the tags in it.
                            $tags = array();
                            if (!empty ($tag1)) {
                                array_push($tags, $tag1);
                            }
                            if (!empty ($tag2)) {
                                array_push($tags, $tag2);
                            }
                            if (!empty ($tag3)) {
                                array_push($tags, $tag3);
                            }
                            if (!empty ($tag4)) {
                                array_push($tags, $tag4);
                            }
                            if (!empty ($tag5)) {
                                array_push($tags, $tag5);
                            }
                            // Count how many tags were stored.
                            $numberOfTags = count($tags);


                            $tagsToAdd = array();
                            $tagIdsStored = array();
                            // Query to check if such tag exists.
                            $query = "SELECT tag_id FROM whwp_Tag WHERE tag_description = :tag";
                            $conn->prepQuery($query);
                            $conn->bind('tag', $tag);
                            for ($i = 0; $i < $numberOfTags; $i++) {
                                $tag = $tags[$i];
                                $t = $conn->single();
                                if ($conn->rowCount() == 0) {
                                    array_push($tagsToAdd, $tag);
                                } else {
                                    $tagId = $t->tag_id;
                                    array_push($tagIdsStored, $tagId);
                                }
                            }

                            // How many tags should be added
                            $numberOfTagsToAdd = count($tagsToAdd);
                            $query = "INSERT INTO whwp_Tag (tag_description) VALUES (:tag)";
                            $conn->prepQuery($query);
                            for ($i = 0; $i < $numberOfTagsToAdd; $i++) {
                                $conn->bind('tag', $tagsToAdd[0]);
                                $conn->execute();
                                array_shift($tagsToAdd);
                                array_push($tagIdsStored, $conn->lastInsertId());
                            }
//                                    $query7 = "SELECT tag_id FROM whwp_Tag ORDER BY tag_id DESC LIMIT :numberOfTagsToAdd";
//                                    $prepared_statement7 = $conn -> prepare($query7);
//                                    $prepared_statement7 -> bindValue(':numberOfTagsToAdd', (int)$numberOfTagsToAdd, PDO::PARAM_INT);
//                                    $prepared_statement7 -> execute();
//                                    while ($tagset = $prepared_statement7 -> fetch(PDO::FETCH_OBJ))
//                                    {
//                                        $tagId = $tagset -> tag_id;
//                                        array_push($tagIdsStored, $tagId);
//                                    }

                            $query = "INSERT INTO whwp_AdTag (adtag_advert, adtag_tag) "
                                . "VALUES (:advert_id, :tag_id)";
                            $conn->prepQuery($query);
                            $conn->bindArrayValue(array('advert_id' => $advert_id, 'tag_id' => $tag_id));
                            for ($i = 0; $i < $numberOfTags; $i++) {
                                $tag_id = $tagIdsStored[$i];
                                $conn->execute();
                            }

                            $conn->endTransaction();
                            echo "Your ad was posted!";
                            echo "You can see it "
                                . "<a href='showAdvert.php?advert_id=".$advert_id."'>here</a>";
                        }
                        catch(PDOException $e){
                            echo "Something went wrong...";
                            $conn->cancelTransaction();
                        }
                    }
                    else
                    {
                        echo "You have to enter at least 1 tag!";
                    }
                }
                else
                {
                    echo "Not all mandatory fields were filled in!";
                }

            }
        }
        ?>
    </div>
    <div id="footer">

    </div>
</div>
</body>
</html>