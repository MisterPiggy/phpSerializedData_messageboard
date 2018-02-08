<?php 
if(file_exists('log.txt')){
    file_put_contents('log.txt', "\n".date("i:s\t")."index.php", FILE_APPEND );
}
else 
    {
        file_put_contents('log.txt', "\n".date("i:s\t")."index.php", FILE_APPEND );
    }


?>
<head>
    <link rel='stylesheet' style='text/css' href='mystyle.css'>

    <body>
        <div id="header"><?php require 'index_loginForm_RegisterButton_Top.php';?></div>
        <div id="footer"><?php require 'index_pleaseLogIn_footer.php';?></div>
    </body>
</head>

