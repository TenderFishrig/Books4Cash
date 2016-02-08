<?php 
session_start(); 
?>

        <?php
            session_destroy();    
            echo "You have successfully logged out";
            header( "refresh:2;url=../index.php" );
        ?>
  