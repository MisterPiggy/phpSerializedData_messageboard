<?php
file_put_contents('log.txt', "\n".date("i:s\t")."\tmessageboard_func_save_output_messages.php", FILE_APPEND );
/* 
page loads
show messages if exist
if button pushed
	session = post
	reload page, empties post
*/


// Select Thread xor StartThread
// writemessage(thread)

// thread table
// ID unique, Subject unique, StartedBy FK unique
// message table
// ID unique, subject, text, Date, Thread FK, User FK,
// messageId, subject, msg, Date, userId
$maxMsgChars = 100;
$minMsgChars = 1;

if(isset($_POST['OK']) && $_POST['OK'] == "Comment!" && $_SESSION['loginGood']
&& isset($_POST['thread'])
)
{
	$_SESSION['comment'] = nl2br($_POST['comment']);
	$_SESSION['chosenThread'] = $_POST['thread']; 
	$_SESSION['log'] .= 'thread is set';
	// since only threadname but no message entered, we display messages from thread
/* 	if ($_SESSION['comment'] == '' && $_SESSION['chosenThread'] != '') 
		{ outputComment(); }  */
	// process and then display chosen thread. if thread not exists it will be created
	if($_SESSION['comment'] != '' && $_SESSION['chosenThread'] != '') 
		{saveThreadsMsgs();}
}


// save message to new or existing file via temp Msg array
function saveThreadsMsgs()
{
     if ($_SESSION['loginGood'] == false)  {  $_SESSION['output'] = 'you can\'t write msg if not logged in'; return; }
    $temp = array();
    $_SESSION['messages'] = array();
    // create new file if none, add userdata
    if(!file_exists('messages.txt'))
        {
		// messageId, subject, msg, Date, userId
        $temp['messageId'] = 0; // first entry xxx 
        $temp['subject'] = $_SESSION['chosenThread'];
		$temp['comment'] = $_SESSION['comment'];
		$temp['date'] = date('m/d/Y h:i:s a', time());
		$temp['userId'] =  $_SESSION['userId'];
         $_SESSION['messages'][] = $temp; 
        file_put_contents('messages.txt', serialize($_SESSION['messages']));
        }
    else// if there are already entries, push user data into existing file
    {
		$filePath = './messages.txt';
		// unserialise message file into session array
		$_SESSION['messages'] = unserialize( file_get_contents( $filePath ) );
		/* count messages */ 
			$nrOfMessages = count($_SESSION['messages']);
		/* auto increment messageId */ 
			$temp['messageId'] = 1+  $_SESSION['messages'][$nrOfMessages-1]['messageId'];
        $temp['subject'] = $_SESSION['chosenThread'];
        $temp['comment'] = $_SESSION['comment'];
        $temp['date'] = date('m/d/Y h:i:s a', time());
        $temp['userId'] = $_SESSION['userId'];
        array_push($_SESSION['messages'],$temp); 
        file_put_contents('messages.txt', serialize($_SESSION['messages']));
	}
	header("location:messageboard.php"); 
	exit;
}

// todo checks and inputs comment field todo check data
function outputComment()
{

	if(isset($_SESSION['messages']) && isset($_SESSION['chosenThread']) )
	{
	?><div style="background:hsla(200,100%,25%,0.3); margin: 1% 5% 1% 5%"><?php
		echo "<p style='margin:0'>The topic is ".$_SESSION['chosenThread']."</p>";
		//$_SESSION['']
		foreach( $_SESSION['messages'] as $key => $value )
			{	
			// unique color for every user
				$col = 0 +  $value['userId']*250; // todo. fix this cheap trick only works up to 255 people

			if($value['subject'] == $_SESSION['chosenThread'] ) // get only messages of current Subject
				{?> <p style="font: .8em verdana; background: linear-gradient(to right,
					hsla(<?php echo $col ?>,100%,50%,0.2) 
					, hsla(200,100%,25%,0.0) 20%)"><?php 
					echo $_SESSION['users'][$value['userId']]['username']. " ".$value['date']; ?> </p>
				<p style="background: linear-gradient(to right,
				hsla(<?php echo $col ?>,100%,50%,0.6)
				, hsla(200,100%,25%,0.0))"><?php echo $value['comment'];  ?></p>
				<?php 			
				}
			}
	?></div><?php
	}
}
?>
