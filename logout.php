<?php
unset($_COOKIE['loggedInUser']); 
setcookie('loggedInUser', null, -1, '/'); 
header("Location: login.php");
?>