<?php
session_start();
?>

<?php
session_destroy();
header( "Location: ../index.php" );
$cookie_name = 'Books4Cash';
setcookie($cookie_name, "0", time() - 3600, "/");
?>
  