<?php 
file_put_contents('log.txt', "\n".date("i:s\t")."loggedOut.php", FILE_APPEND );

if(file_exists('log.txt')) 
{ file_put_contents('log.txt', "\n".date("i:s\t")."loggedOut.php", FILE_APPEND ); }
?>
<head>
<link rel='stylesheet' style='text/css' href='mystyle.css'>
<body>
<div id="header"><?php require 'loggedOut_header.php';?></div>
<div id="footer"><?php require 'loggedOut_footer.php';?></div>
</body>
</head>

