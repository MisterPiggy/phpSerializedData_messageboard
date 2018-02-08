<?php
file_put_contents('log.txt', "\n".date("i:s\t")."\tmessageboard_showMessages_bottom.php", FILE_APPEND );
// the header calls this page again if button comment is pushed, because action = '' empty
// it processes this footer script everytime the comment button is hit

if(!isset($_SESSION)) session_start(); //else echo 'session was not running. starting it'; 

if (!isset($_SESSION['chosenThread'])) echo "<h1>Tell us where it hurts</h1>"; 
else echo "<h1>".$_SESSION['chosenThread']."</h1>"; 

if ( !isset($_SESSION['loginGood']))
{ echo "Ihre Session ist vermutlich abgelaufen. 
	Ihre Session Variablen sind weg. Bitte ausloggen klicken."; 
	exit;}

// when page calls itself no need to log in again
if ( !$_SESSION['loginGood'] )
	{ require 'register_functions_cleanData_saveData_Login.php';}

// process and show messages ON button push
// means nothing happens here automatically when page loaded
if ($_SESSION['loginGood'] )// &&   isset($_POST['comment']))
	{ 
	require 'messageboard_func_save_output_messages.php';
	outputComment();
	}
else header('location:index.php');
?>