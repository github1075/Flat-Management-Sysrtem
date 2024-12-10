<?php 

setcookie('id_of_website', '', strtotime("+1 year")); 
setcookie('key_of_website', '', strtotime("+1 year"));

header("Location: index.php");
exit();