<!DOCTYPE html>
<?php
session_start();
require ('includes/DBCommunication.php');
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

<div class="container" id="accountMenu">

<ul class="list-group">
<li class="list-group-item">My Books</li>
  <li class="list-group-item"><a href="userSettings.php">Edit profile</a></li>
  <li class="list-group-item">Messages</li>
</ul>

</div>

<div class="container" id="myAds">

    <div class="row">
        <section id="account">
            <h1>Account page.</h1>
            <?php
                try{
                    $conn=new DBCommunication();
                    if(isset($_SESSION['user_id'])){
                        $query="SELECT advert_id,advert_bookname,advert_price FROM whwp_Advert WHERE advert_owner=:user_id AND ((NOT advert_expired=1) OR (advert_expired IS NULL))";
                        $conn->prepQuery($query);
                        $conn->bind('user_id',$_SESSION['user_id']);
                        $result=$conn->resultset();

                            echo "<h2>My Ads</h2>";
                            echo "<table class=\"table table-hover\">";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>ID</th>";
                            echo "<th>Title</th>";
                            echo "<th>Price</th>";
                            echo "<th></th>";
                            echo "</tr>";
                            echo "</thead>"; 
                            echo "<tbody>";
                        foreach($result as $item){
                           echo"<tr>";
                            echo"<td>" . $item->advert_id . "</td>";
                            echo "<td>" . $item->advert_bookname . "</td>";
                            echo "<td>" . $item->advert_price . "</td>";
                           
                            echo "<td>";

                                 echo "<form role='form' method='get' action='editAdvert.php'>";
                            echo "<input type='hidden' name='advert_id' value='".$item->advert_id."'>";
                            echo "<button id='editButton".$item->advert_id."' type='submit' class='btn btn-default'>Edit</button>";
                            echo "</form>";

                            echo "<button class=\"btn btn-default\"><a href='showAdvert.php?advert_id=". $item->advert_id . "'>View Ad</a></button>"
                                
                                ."<button onclick='deleteAdvert(".$item->advert_id.")' id='deleteButton".$item->advert_id."' type='button' class='btn btn-default'>Delete</button>";
                            
                            echo "</td>";
                         echo "</tr>";
                        }
                         echo "</tbody>";
                      echo "</table>";
                    }
                    else {
                        echo "Please log-in.";
                    }

                }
                catch(PDOException $e){
                    echo $e->getMessage();
                }

            ?>
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
<script src="js/custom scripts/advertDelete.js"></script>

</body>
</html>