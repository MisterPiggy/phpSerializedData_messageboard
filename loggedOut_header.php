<?php 
file_put_contents('log.txt', "\n".date("i:s\t")."\tloggedOut_header.php", FILE_APPEND );
if(!isset($_SESSION)) session_start();
session_unset(); // del all sess var
session_destroy();
if(file_exists('log.txt')) 
  { file_put_contents('log.txt', "\n".date("i:s\t")."\tloggedOut_header.php, session_unset(), session_destroy(), loginButtonForm", FILE_APPEND ); }

//if(isset($_SESSION)) { $_SESSION['output'] =  'session still running'; echo $_SESSION['output'];} 

echo "<h1>Pain Appreciation Society</h1>"

?>
<!-- log in as diff -->
<form action="index.php" method="get">
  <input type="hidden" name="act" value="run">
  <input type="submit" name = "OK" value="log in again">
</form>

