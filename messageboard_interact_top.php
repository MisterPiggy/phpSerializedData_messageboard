<?php
file_put_contents('log.txt', "\n".date("i:s\t")."\tmessageboard_interact_top.php", FILE_APPEND );
file_put_contents('log.txt', "\n".date("i:s\t")."\tunserialize messages.txt array", FILE_APPEND );
file_put_contents('log.txt', "\n".date("i:s\t")."\titerate through array and html show", FILE_APPEND );
file_put_contents('log.txt', "\n".date("i:s\t")."\tbtn button ok, button btnBackend, button btnlogout", FILE_APPEND );
if(!isset($_SESSION)) session_start(); //else echo 'session was not running. starting it';
	
echo "<h1>Pain Appreciation Society</h1>";

$filePath = './messages.txt';
// before any button is pushed everytime site is updated
if(!isset($_SESSION['messages']) && file_exists($filePath) )
	{ 
		$_SESSION['messages'] = array();
		$_SESSION['messages'] = unserialize( file_get_contents( "messages.txt" ) );
	} 
// todo fix this. only shown after login processes
if(isset($_SESSION['username'])) { echo "<p>". $_SESSION['username']." is online</p>"; }


/* // get list of users before any button is pushed everytime site is updated
if(!isset($_SESSION['users']) && file_exists('./regUsers.txt') )
{ 
	$_SESSION['users'] = array();
	$_SESSION['users'] = unserialize( file_get_contents( "regUsers.txt" ) );
} else echo "no user file present."; */


// get and display unique subjects. 
if(isset($_SESSION['messages']) )
{   
?><div style=" margin: 1% 5% 1% 5%"><?php
		$tempSubjects = array();
		foreach( $_SESSION['messages'] as $key => $value )
		{
			if(!in_array($value['subject'], $tempSubjects, true))
			{ 
				array_push($tempSubjects, $value['subject']);
				?>
				<p style="margin:0; background:brown;display:inline;"><?= $value['subject']?></p>
				<?php
			}
		}
?></div><?php
}
?>


<!-- comment text and button  -->
<!-- redirecting to self with header to delete POST data and prevent submitting data 
if user reloads page -->
<form float:'left' margin-right:'50%' method="post" action="" >
	new/current topic. Leave comment field empty to only show posts<br>
	topic <input type="text" name="thread" value='' ><br>
	<textarea name="comment" ></textarea><br>
	<input  type="submit" name="OK" value="Comment!" >
</form>

<!-- back end button -->
<form  clear:'right'  method="get" action="backend.php" >
	<input type="submit" name = "btnBackend" value="backend">
</form>

<form method="get" action="loggedOut.php" >
	<input type="submit" name = "btnlogout" value="logout!">
</form>

