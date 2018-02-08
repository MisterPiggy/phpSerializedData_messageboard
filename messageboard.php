<?php
if(!isset($_SESSION)) session_start();
file_put_contents('log.txt', "\n".date("i:s\t")."messageboard.php", FILE_APPEND ); 

if(!isset($_SESSION['loginGood']) || !$_SESSION['loginGood']) {   header('location:index.php'); exit(); }

?>
<head>
<link rel='stylesheet' style='text/css' href='mystyle.css'>
<body>
<div id="header"><?php require 'messageboard_interact_top.php';?></div>
<div id="footer"><?php require 'messageboard_showMessages_bottom.php';?></div>

</body>
</head>