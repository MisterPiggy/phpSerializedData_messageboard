<?php 
file_put_contents('log.txt', "\n".date("i:s\t")."\tregister_form_top.php", FILE_APPEND );


if(isset($_SESSION))session_destroy();
if(!isset($_SESSION)) session_start();
//else echo 'session was not running. starting it'; 

echo "<h1>Pain Appreciation Society</h1>";
?>
<!-- todo password confirmation to type in again. -->
<!-- register form and button -->
<form 	method="post" action='register_functions_cleanData_saveData_Login.php'>
Username:<input type="text" name ="username"><br>
E-mail:<input type="text" name="email" ><br>
Password:<input type="password" name="pw"><br>
<input type="submit" name="register" value="Register Me">
</form>

<!-- login button -->
<form method="get" action="index.php" >
<input type="submit" name = "btnlogin" value="login">
</form>
