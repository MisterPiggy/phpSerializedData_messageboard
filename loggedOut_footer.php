<?php
file_put_contents('log.txt', "\n".date("i:s\t")."\tloggedOut_footer.php", FILE_APPEND );

if(!isset($_SESSION)) session_start();
//else echo 'session was not running. starting it'; 

echo "<h1>Tell us where it hurts</h1>"; 
$output = '';
if ( isset($_SESSION['userName']) )
{
    $output= 'userName: '.$_SESSION['userName'].' ist still online.<br>';
}
else { $output = 'please log in';} 
?>

<p><?=$output?></p>