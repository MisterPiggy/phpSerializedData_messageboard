<?php 
file_put_contents('log.txt', "\n".date("i:s\t")."\tindex_loginForm_RegisterButton_Top.php", FILE_APPEND );
//include 'scrutinizeAndLogin.php';


//index_loginForm_RegisterButton_Top.php
if(isset($_SESSION))session_destroy();
if(!isset($_SESSION)) session_start();
//else echo 'session was not running. starting it'; 

echo "<h1>Pain Appreciation Society</h1>";
//echo session_id();
session_unset();
// initialize $output variable which gives out login or msg status to user on every page
//$_SESSION['loginStatus'] = 'you are not logged in';
$_SESSION['loginGood'] = False;
$_SESSION['username'] = null;
//if ( isset($_SESSION['username'])) echo '<br>username session ist set<br>'; else echo 'username sess not set';
//$_SESSION['output'] = '';
$_SESSION['log'] = 'events: '; // this will be constantly concatenated to debug better
$_SESSION['chosenThread'] = null;
$_SESSION['threads'] = null;
$_SESSION['userId'] = null;
//end php
?>

<!-- log in form -->
<form 	method="post" action='scrutinizeAndLogin.php'>    
Username:<input type="text" name="username"><br>
Password:<input type="password" name="pw"><br>
<input type="submit" name="login" value="login" >
</form>

<!-- register button todo fix get to POST -->
<form action="register.php" method="get">  
  <input type="hidden" name="act" value="run">
  <input type="submit" name = "register" value="register">
</form>