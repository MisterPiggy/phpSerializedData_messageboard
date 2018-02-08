<?php
file_put_contents('log.txt', "\n".date("i:s\t")."\tregister_form_top.php", FILE_APPEND );
if(!isset($_SESSION)) session_start();
echo "<h1>Tell us where it hurts</h1>"; 
echo '<p>please log in or register. Do not use silly characters.</p>';
?>

