<?php
/*
 * Error codes:
 * 1 - Not logged in.
 * 2 - PDO Exception.
 * 3- Invalid advert_id.
 *
 */
session_start();
require 'DBCommunication.php';

$response_array=array('success' => false,'error_code'=>array(),'message' => '');
if(empty($_SESSION['username']))
{
    array_push($response_array['error_code'], 1);
}
else
{
    if(!empty($_POST['advert_id'])) {
        $username = $_SESSION['username'];
        $advert_id = $_POST['advert_id'];
        try {
            // Connect to the database
            $conn = new DBCommunication();
            $query="SELECT * FROM whwp_Advert WHERE advert_id=:advert_id";
            $conn->prepQuery($query);
            $conn->bind('advert_id',$advert_id);
            $conn->execute();
            if($conn->rowCount()>0) {
                $conn->beginTransaction();
                // Get user, who is logged in and posting ad, id
                $query = "SELECT user_id FROM whwp_User WHERE user_username = :username";
                $conn->prepQuery($query);
                $conn->bind('username', $username);
                $resultset = $conn->single();
                $user_id = $resultset->user_id;
                if (isset($_FILES["image"]["type"])) {
                    $validextensions = array("jpeg", "jpg", "png");
                    $temporary = explode(".", $_FILES["image"]["name"]);
                    $file_extension = strtolower(end($temporary));
                    if ((($_FILES["image"]["type"] == "image/png") || ($_FILES["image"]["type"] == "image/jpg") || ($_FILES["image"]["type"] == "image/jpeg")
                        ) && ($_FILES["image"]["size"] < 10000000)//Approx. 10mb files can be uploaded.
                        && in_array($file_extension, $validextensions)
                    ) {
                        if ($_FILES["image"]["error"] > 0) {
                            //TODO add error code.
                        } else {
                            $image = uniqid('', true) . "." . $file_extension;
                            While (file_exists(__DIR__ . "/../uploadedImages/" . $image)) {
                                $image = uniqid('', true) . "." . $file_extension;
                            }

                            $sourcePath = $_FILES['image']['tmp_name']; // Storing source path of the file in a variable
                            $filepath = __DIR__ . "/../uploadedImages/" . basename($image); // Target path where file is to be stored
                            if (is_uploaded_file($sourcePath)) move_uploaded_file($sourcePath, $filepath);
                            if ($file_extension == 'jpeg' || $file_extension == 'jpg')
                                $img = imagecreatefromjpeg($filepath);
                            elseif ($file_extension == 'png')
                                $img = imagecreatefrompng($filepath);
                            $width = imagesx($img);
                            $height = imagesy($img);
                            $new_width = 200;
                            $new_height = floor($height * ($new_width / $width));
                            $tmp_img = imagecreatetruecolor($new_width, $new_height);
                            imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            imagejpeg($tmp_img, __DIR__ . "/../thumbnails/" . basename($image));
                        }
                    }
                }
                if (!empty($_POST['title'])) {
                    $query = "UPDATE whwp_Advert SET advert_bookname=:title WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('title' => $_POST['title'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($_POST['condition'])) {
                    $query = "UPDATE whwp_Advert SET advert_condition=:condition WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('condition' => $_POST['condition'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($_POST['category'])) {
                    $query = "UPDATE whwp_Advert SET advert_category=:category WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('category' => $_POST['category'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($_POST['price'])) {
                    $query = "UPDATE whwp_Advert SET advert_price=:price WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('price' => $_POST['price'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($_POST['description'])) {
                    $query = "UPDATE whwp_Advert SET advert_description=:description WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('description' => $_POST['description'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($_POST['author'])) {
                    $query = "UPDATE whwp_Advert SET advert_bookauthor=:advert_author WHERE advert_id = :advert_id";
                    $conn->prepQuery($query);
                    $conn->bindArrayValue(array('advert_author' => $_POST['author'], 'advert_id' => $advert_id));
                    $conn->execute();
                }
                if (!empty($image)) {
                    $query = "DELETE FROM whwp_AdImage WHERE adimage_advert=:advertid";
                    $conn->prepQuery($query);
                    $conn->bind('advertid', $advert_id);
                    $conn->execute();
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
                }
                // Count how many tags were stored.
                if (!empty($_POST['tags'])) {
                    $tags = $_POST['tags'];
                    $numberOfTags = count($tags);
                    $query = "DELETE FROM whwp_AdTag WHERE adtag_advert=:advertid";
                    $conn->prepQuery($query);
                    $conn->bind('advertid', $advert_id);
                    $conn->execute();
                    $tagsToAdd = array();
                    $tagIdsStored = array();
                    // Query to check if such tag exists.
                    $query = "SELECT tag_id FROM whwp_Tag WHERE tag_description = :tag";
                    $conn->prepQuery($query);
                    for ($i = 0; $i < $numberOfTags; $i++) {
                        $tag = $tags[$i];
                        $conn->bind('tag', $tag);
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
                    $query = "INSERT INTO whwp_AdTag (adtag_advert, adtag_tag) "
                        . "VALUES (:advert_id, :tag_id)";
                    $conn->prepQuery($query);
                    $conn->bind('advert_id', $advert_id);
                    for ($i = 0; $i < $numberOfTags; $i++) {
                        $tag_id = $tagIdsStored[$i];
                        $conn->bind('tag_id', $tag_id);
                        $conn->execute();
                    }
                }
                $conn->endTransaction();

                $response_array['message'] = "You can see it "
                    . "<a href='showAdvert.php?advert_id=" . $advert_id . "'>here</a>";
                $response_array['success'] = true;
            }
            else {
                array_push($response_array['error_code'], 3);
            }
        } catch (PDOException $e) {
            $conn->cancelTransaction();
            array_push($response_array['error_code'], 2);
        }
    }
    else {
        array_push($response_array['error_code'], 3);
    }
}
echo json_encode($response_array);