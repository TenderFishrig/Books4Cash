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

    ?>
</div>
<div class="container" id="searchResults">
    <div class="panel panel-default">


        <?php
        // Getting the id of the advertisement
        $search_term = "";
        if(isset($_GET['search']))
        {
            $search_term = $_GET['search'];
            if(!empty($search_term))
            {
                $search_string = explode(' ', $search_term);
                $keywords = sizeof($search_string);
                try
                {
                    // Establishing a connection to the database
                    $conn = new DBCommunication();
                    $results = [];
                    $results = nameSearch($conn, $search_term);

                    for($i = 0; $i < $keywords; $i++)
                    {
                        $partialNameResults = partialNameSearch($conn, $search_string[$i]);
                        foreach($partialNameResults as $result)
                        {
                            if(!in_array($result, $results))
                            {
                                array_push($results, $result);
                            }
                        }

                        $tagResults = tagSearch($conn, $search_string[$i]);
                        foreach($tagResults as $result)
                        {
                            if(!in_array($result, $results))
                            {
                                array_push($results, $result);
                            }
                        }

                        $descriptionResults = descriptionSearch($conn, $search_string[$i]);
                        {
                            foreach($descriptionResults as $result)
                            {
                                if(!in_array($result, $results))
                                {
                                    array_push($results, $result);
                                }
                            }
                        }

                        $searchResults=[];
                        for($i = 0; $i < sizeof($results); $i++)
                        {
                            $oneResult = gatherResults($conn, $results[$i]->advert_id);
                            array_push($searchResults, $oneResult);
                        }
                    }
                     $count = sizeof($searchResults);
                      if ($count ==1) {
                        echo "<div class='panel-heading'>Your search provided 1 result</div>";
                    } else {
                        echo "<div class='panel-heading'>Your search provided " . $count . " results</div>";
                    }

                    echo "<div class='panel-body'>";
                   
                    
                    foreach ($searchResults as $element)
                    {
                        echo "<div class=\"col-lg-4 col-sm-6 searchItem\">";
                        if(strlen($element->advert_bookname) > 20){

                            echo "<div class='well well-sm'><strong>Title:</strong> ". substr($element->advert_bookname, 0, 20) . "...</div>";
                        }
                        else
                        {
                            echo "<div class='well well-sm'><strong>Title:</strong> ". $element->advert_bookname . "</div>";
                        }
                        echo "<div class='well well-sm'><strong>Price:</strong> ". $element->advert_price . "£</div>";
                        echo "<a href='showAdvert.php?advert_id=". $element->advert_id . "'><button type=\"button\" class=\"btn btn-info btn-lg openAd\">Show more</button></a>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo "</div>";

                     // Determining how many pages will be needed and outputting them.
                                $pageLimit = 12;
                                $totalPages = ceil($count / $pageLimit);
                                if($totalPages > 1)
                                {
                             
                                echo "<div class=\"text-center\">";
                                echo "<ul class=\"pagination\">";
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    echo "<li><a class='pageNumber' href='search.php?search=$search_term&Search=Search&page=$i'>$i</a></li> ";
                                }
                                echo "</ul>";
                                echo "</div>";
                            }


                }
                catch (PDOException $e)
                {
                    echo 'Something went wrong.';
                }
            }
            else
            {
                echo "Please enter a search term!";
            }
        }

        // Where the book name is fully identical to search term
        function nameSearch($conn, $search_term)
        {
            $query = "SELECT DISTINCT whwp_Advert.advert_id FROM whwp_Advert "
                . "WHERE advert_bookname = :search_term "
                . "ORDER BY whwp_Advert.advert_price DESC";
            $conn->prepQuery($query);
            $conn->bind('search_term', $search_term);
            $advert = $conn->resultset();
            return $advert;
        }

        // Some part of the book name fits with the search term
        function partialNameSearch($conn, $keyword)
        {
            $query = "SELECT DISTINCT whwp_Advert.advert_id FROM whwp_Advert "
                . "WHERE advert_bookname LIKE :keyword "
                . "ORDER BY whwp_Advert.advert_price DESC";

            $conn->prepQuery($query);
            $conn->bind('keyword', "%".$keyword."%");
            $advert = $conn->resultset();
            return $advert;
        }

        // Search by tags.
        function tagSearch($conn, $keyword)
        {
            $query = "SELECT DISTINCT whwp_Advert.advert_id FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                . "WHERE whwp_Tag.tag_description LIKE :keyword "
                . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id "
                . "ORDER BY whwp_Advert.advert_price DESC";

            $conn->prepQuery($query);
            $conn->bind('keyword', "%".$keyword."%");
            $advert = $conn->resultset();
            return $advert;
        }

        // Search for matching words in the description
        function descriptionSearch($conn, $keyword)
        {
            $query = "SELECT DISTINCT whwp_Advert.advert_id FROM whwp_Advert "
                . "WHERE advert_description LIKE :keyword "
                . "ORDER BY whwp_Advert.advert_price DESC";
            $conn->prepQuery($query);
            $conn->bind('keyword', "%".$keyword."%");
            $advert = $conn->resultset();
            return $advert;
        }

        // Get the rows from the DB.
        function gatherResults($conn, $advert_id)
        {
            $query = "SELECT whwp_Advert.* FROM whwp_Advert "
                . "WHERE whwp_Advert.advert_id = :advert_id ";
            $conn->prepQuery($query);
            $conn->bind('advert_id', $advert_id);
            $advert=[];
            $advert = $conn->single();
            return $advert;
        }


        ?>
    </div>
  
<footer>
    <address>&copy; Copyright 2016 All Rights Reserved We Hope We Pass</address>
</footer>
   
</div>
<script src="js/bootstrap/jquery-2.2.0.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/custom scripts/EffectsIndex.js"></script>
<script src="js/bootstrap/bootstrap-notify.min.js"></script>
</body>
</html>