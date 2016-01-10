<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search</title>
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
                        $conn = new PDO('mysql:host=localhost;dbname=wehope', 'wehope', 'l4ndofg10ry');
                    }
                    catch (PDOException $exception) 
                    {
                        echo "There was a problem " . $exception -> getMessage();
                    }
                    // Getting the id of the advertisement
                    $search_term = "";
                    if(isset($_GET['search']))
                    {
                        $search_term = $_GET['search'];
                        $search_string = "%".$_GET['search']."%";
                        if(!empty($search_term))
                        {
                            // Run the query.
                            $query = "SELECT DISTINCT whwp_Advert.* FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                                . "WHERE whwp_Tag.tag_description LIKE :search_string "
                                . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                                . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id";
                                
                            $prepared_statement = $conn -> prepare($query);
                            $prepared_statement -> bindValue(':search_string', $search_string);
                            $prepared_statement -> execute();
                                                
                            // Counts how many results were returned from the search.
                            $count = $prepared_statement -> rowCount();
                            if ($count == 1)
                            {
                                echo "Your search provided " . $count . " result";
                            }
                            else
                            {
                                echo "Your search provided " . $count . " results";
                            }
                            // Paging system
                            if (isset($_GET["page"])) 
                            { 
                                $page = $_GET["page"]; 
                                $search_term = $_GET["search"];
                            } 
                            else 
                            { 
                                //$page = 10;    
                                $page = 1;
                                header("location:search.php?search=$search_term&Search=Search&page=1");
                            } 
                            // Determine which results to show in which page.
                            //$start_from = ($page-1) * 10;
                            $start_from = ($page-1) * 10;

                            // How many results per one page
                            $pageLimit = 10;
                            //Todo: inefficent we already have all the rows from previous query
                            $query2 = "SELECT DISTINCT whwp_Advert.* FROM whwp_Advert, whwp_AdTag, whwp_Tag "
                                . "WHERE whwp_Tag.tag_description LIKE :search_string "
                                . "AND whwp_Tag.tag_id = whwp_AdTag.adtag_tag "
                                . "AND whwp_AdTag.adtag_advert = whwp_Advert.advert_id "
                                . "ORDER BY whwp_Advert.advert_id "
                                . "LIMIT $start_from, $pageLimit";

                            $prepared_statement2 = $conn -> prepare($query2);
                            $prepared_statement2 -> bindValue(':search_string', $search_string);
                            $prepared_statement2 -> execute();
                            while ($advert = $prepared_statement2 -> fetch(PDO::FETCH_OBJ))
                            {
                                echo "<p>";
                                echo "<a href='showAdvert.php?advert_id="
                                    . $advert -> advert_id."'>";
                                echo $advert -> advert_bookname;
                                echo "</a>";
                                echo " " . $advert -> advert_price;
                                echo "</p>";
                            }
                            // Determining how many pages will be needed and outputting them.
                            $totalPages = ceil($count / $pageLimit);
                            for ($i = 1; $i <= $totalPages; $i++) 
                            {
                                echo "<a href='search.php?search=$search_term&Search=Search&page=$i'>$i</a> "; 
                            } 
                        }
                        else
                        {
                            echo "Please enter a search term!";
                        }
                    }
                ?>    
            </div>    
            <div id="footer">
                
            </div> 
        </div>
    </body>
</html>