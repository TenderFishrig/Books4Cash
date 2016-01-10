<?php 
session_start(); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Log Out</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="container">
            <div id="header">
                <img src="images/logo.png" alt="logo"/>
                
            </div>
            <div id="content">
                <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <span id="logout">You have successfully logged out!</span>
            </div>    
            <div id="footer">
                
            </div>
        </div>
        <?php
            session_destroy();    
            header( "refresh:2;url=index.php" );
        ?>
    </body>
</html>    


