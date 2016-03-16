<?php
session_start();
require ('includes/DBCommunication.php');
?>
<!DOCTYPE html>
<html lang="en">
 <head>
    <link rel="Stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <link rel="Stylesheet" type="text/css" href="css/style.css"/>
    <link rel="Stylesheet" type="text/css" href="css/animate.css"/>
      <meta charset="utf-8">
      <meta name="description" content="A page for buying and selling books">
    

      <title>Books4Cash</title>
  </head>
    
    <body>
<div class="container" style="margin-bottom: 50px">
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
   </div>
<div class="container" id="searchResults">


                <?php
                    // Getting the id of the advertisement
                    $search_term = "";
                    if(isset($_GET['search']))
                    {
                        $search_term = $_GET['search'];
                        $search_string = "%".$_GET['search']."%";
                        if(!empty($search_term))
                        {
                            try {
                                // Establishing a connection to the database
                                $conn = new DBCommunication();
                                // Run the query.
                                $query = "SELECT DISTINCT COUNT(*) as count FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                                    . "WHERE whwp_Tag.tag_description LIKE :search_string "
                                    . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                                    . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id";
                                $conn->prepQuery($query);
                                $conn->bind('search_string', $search_string);
                                // Counts how many results were returned from the search.
                                $count = $conn->single()->count;
                                if ($count ==1) {
                                    echo "<p>Your search provided 1 result</p>";
                                } else {
                                    echo "<p>Your search provided " . $count . " results</p>";
                                }
                                // Paging system
                                if (isset($_GET["page"])) {
                                    $page = $_GET["page"];
                                    $search_term = $_GET["search"];
                                } else {
                                    //$page = 10;
                                    $page = 1;
                                   // header("location:search.php?search=$search_term&Search=Search&page=1");
                                }
                                // Determine which results to show in which page.
                                //$start_from = ($page-1) * 10;
                                $start_from = ($page - 1) * 10;
                                // How many results per one page
                                $pageLimit = 10;
                                $query = "SELECT DISTINCT whwp_Advert.* FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                                    . "WHERE whwp_Tag.tag_description LIKE :search_string "
                                    . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                                    . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id "
                                    . "ORDER BY whwp_Advert.advert_id "
                                    . "LIMIT $start_from, $pageLimit";
                                $conn->prepQuery($query);
                                $conn->bind('search_string', $search_string);
                                $advert=$conn->resultset();
                                echo "<table class=\"table\">";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>ID</th>";
                                echo "<th>Book name</th>";
                                echo "<th>Price</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                

                                foreach ($advert as $element) {
        echo "<tr>";                   
        echo "<td><a href='showAdvert.php?advert_id=". $element->advert_id . "'></td>";
        echo "<td>" . $element->advert_bookname ."</td>";
        echo "<td>" . $element->advert_price . "</td>";
        echo "</tr>";  
     
}
   
        echo "</tbody>";
        echo "</table>";

                               
                                // Determining how many pages will be needed and outputting them.
                                $totalPages = ceil($count / $pageLimit);
                                echo "<ul class=\"pagination\">";
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo "<li><a href='search.php?search=$search_term&Search=Search&page=$i'>$i</a></li> ";
                                }
                                echo "</ul>";
                            }
                            catch (PDOException $e){
                                echo 'Something went wrong.';
                            }
                        }
                        else
                        {
                            echo "Please enter a search term!";
                        }
                    }
                ?>    
                
</div>
 <footer>
         <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
     </footer>
   

     <script src="js/bootstrap/jquery-2.2.0.min.js"></script>
     <script src="js/bootstrap/bootstrap.min.js"></script>
     <script src="js/custom scripts/EffectsIndex.js"></script>
     <script src="js/bootstrap/bootstrap-notify.min.js"></script>

  </body>
</html>