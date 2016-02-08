<?php 
session_start(); 
?>

        <?php
            session_destroy();    
//            echo "You have successfully logged out";
            header( "Location: ../index.php" );
        ?>
  