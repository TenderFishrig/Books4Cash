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
?>

<div class="container" id="userContent">
<div class="row">
<div class="col-lg-3">
          <div class="panel panel-default">
          <div class="panel-heading">My Account
          </div>
          <div class="panel-body">
               <ul class="nav nav-list">
                <li class="usermenuActive"><a href="userSettings.php"><i class="glyphicon glyphicon-user"></i> Edit profile</a>
                </li>
                <li><a href="#"><i class="glyphicon glyphicon-list-alt"></i>
                                My Books</a></li>
                <li><a href="message.php"><i class="glyphicon glyphicon-envelope"></i> Inbox</a>
                        </li>
                        <li><a href="send_message.php"><i class="glyphicon glyphicon-pencil"></i> Send a Message</a>
                        </li>
                        
                </ul>
          </div>
          </div>
          </div>
<div class="col-lg-9">
   <div class="panel panel-default">
   <div class="panel-heading">My Books</div>
   <div class="panel-body">
        <?php
                try{
                    $conn=new DBCommunication();
                    if(isset($_SESSION['user_id'])){
                        $query="SELECT advert_id,advert_bookname,advert_price FROM whwp_Advert WHERE advert_owner=:user_id AND ((NOT advert_expired=1) OR (advert_expired IS NULL))";
                        $conn->prepQuery($query);
                        $conn->bind('user_id',$_SESSION['user_id']);
                        $result=$conn->resultset();

                            
                            echo "<table class=\"table table-hover\">";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th style=\"width:20%\">ID</th>";
                            echo "<th style=\"width:20%\">Title</th>";
                            echo "<th style=\"width:20%\">Price</th>";
                            echo "<th style=\"width:40%\"></th>";
                            echo "</tr>";
                            echo "</thead>"; 
                            echo "<tbody>";
                        foreach($result as $item){
                           echo"<tr>";
                            echo"<td>" . $item->advert_id . "</td>";
                            echo "<td>" . $item->advert_bookname . "</td>";
                            echo "<td>" . $item->advert_price . "</td>";
                           
                            echo "<td>";
                                echo "<div class='btn-group' role='group' id='adButtons'>";
                                 echo "<form role='form' class='btn-group' method='get' action='editAdvert.php'>";
                            echo "<input type='hidden' name='advert_id' value='".$item->advert_id."'>";
                            echo "<button id='editButton".$item->advert_id."' type='submit' class='btn btn-default editButton'>Edit</button>";
                            echo "</form>";
   

                              echo "<form class='btn-group' action='showAdvert.php?advert_id=". $item->advert_id ."' method='get'>";
                              echo "<input type='hidden' name='advert_id' value='".$item->advert_id."'>";
                              echo "<button type='submit' class='btn btn-default'>View Ad</button>";
                              echo "</form>";
                              
                              echo "<button onclick='deleteAdvert(".$item->advert_id.")' id='deleteButton".$item->advert_id."' type='button' class='btn btn-default'>Delete</button>";
                                echo "</div>";
                            
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



        </div>
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
<script src="js/custom scripts/advertDelete.js"></script>

</body>
</html>