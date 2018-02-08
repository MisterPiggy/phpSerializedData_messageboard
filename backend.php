<?php
session_start();
// send users away if login bad. return and to messages page 
// or if user called this page without logging in
if(file_exists('log.txt')) { file_put_contents('log.txt', "\n".date("i:s\t")."backend.php", FILE_APPEND ); }


if(!isset($_SESSION['loginGood']) || !$_SESSION['loginGood']) 
    { header('location:messageboard.php'); exit(); }


// making a function to process various arrays and return as table
// or rather, it will update sesion foot accordingly
function makeTable($arr,  $optional = NULL) // optional parameter, eg array, to exclude columns
{
    $out = '';
    $out = '<table><th><tr>'; // concat header. header is still empty
        // get the headers = keys from the first [0] entry
        foreach($arr[0] as $key => $head)
            {
                // 
                if(isset($optional) && in_array($key,$optional))
                    {continue;} // goto next iteration
                else 
                    {$out .= '<td>'.$key.'</td>';}
            }
            $out .= '</tr>'; // close header row
        // now loop through messages
        foreach($arr as $msg )
            {
                /*row*/ $out.='<tr>';  // concat tr row
                 foreach($msg as $key => $dat) 
                    {  // again exclude the optional 
                        if(isset($optional) && in_array($key,$optional))
                        {continue;}  // go to next iteration
                    else 
                        {/*date*/ $out.= '<td>'.$dat.'</td>';}
                    } 
                $out.='</tr>';  // end row with /tr
            } 
        $out.='</th></table>'; // end header
$_SESSION['foot'] = $out;
}



// btn query:
// depending which button was clicked, the SESSION var 'foot' will be loaded and later output


// button messages  show table of messages
if(isset($_POST['btnMsg']))
    { 
        if(!isset($_SESSION['messages'])) 
            { $_SESSION['foot'] = "<p>There are no messages</p>"; 
                goto jump; // wonderful! goto!
            }
        $_SESSION['foot'] = 'threads<br>';
        // using function
        makeTable($_SESSION['messages']);
        jump:
    }

// todo button 'threads'
elseif(isset($_POST['btnThreads'])) 
    { // loop through all messages and get threads
        if(isset($_SESSION['messages'])) 
        { 
            $_SESSION['foot'] = 'threads<br>';  // do not show messageID, comment or date
            makeTable($_SESSION['messages'], ['userId','messageId','comment','date']); 
        }
        else $_SESSION['foot'] = "<p>There are no messages</p>";  
    }


// todo still causes problems because once user is gone his messages cant remain 
// button 'delete user leave messages'
elseif(isset($_POST['btnDelUser'])) 
{ 
   goto jump2;
   if(isset($_SESSION['users']) && $_POST['searchText'])
   {
       foreach($_SESSION['users'] as $key => $value)
    {
        if ($value['id'] == $_POST['searchText'])
        { //unset($_SESSION['users'][$value['id']]);
            array_splice
                ($_SESSION['users'][$value['id']],0,5,[$value['id'],'x','x','x','x']);
        }
    }
    file_put_contents('regUsers.txt', serialize($_SESSION['users']));
    //serialize($_SESSION['users'])
    makeTable($_SESSION['users']);
    jump2:
    // todo create array %Session or $UserSession
    // userId, 
    // logIn Time, 
    // logOut Time, 
    // current status
    // to force the user out, we just set the logout Time from open to curTime
}
}

// button 'button delete all messages'
elseif(isset($_POST['btnKillMsgFile'])) 
{ 
    $result = false;
    ?> 
    <form display:"inline"; method="get" action=<?php $result = true ?> >
    <input type="submit" name = "btnYes" value="press yes to delete"></form>
    <?php
    if($result)
    {
    if (file_exists('./messages.txt')) {unlink('./messages.txt');}
    unset($_SESSION['messages']);
    }
}


// button 'button delete all USERS'
elseif(isset($_POST['btnKillUserFile'])) 
{ 
    $result = false;
    ?> 
    <form display:"inline"; method="get" action=<?php $result = true ?> >
    <input type="submit" name = "btnYes" value="press yes to delete user.txt"></form>
    <?php
    if($result)
    {
    if (file_exists('./regUsers.txt')) {unlink('./regUsers.txt');}
    unset($_SESSION['users']);
    }
}

// button 'users'. show table of users. 
elseif(isset($_POST['btnUsers']))
    {
        if(isset($_SESSION['users']))
            { makeTable($_SESSION['users']/*, ['email']*/); }
        else 
            $_SESSION['foot'] = "<p>There are no users.</p>"; 
    }

    // button frontend
elseif(isset($_POST['btnFrontend'])) header('location:messageboard.php') ;
// when page is loaded and no button pushed yet
else $_SESSION['foot'] = 'please push a button';

?>

<body>
<style> /* we use a different, sober, css style for the backend */
    :root {--col1:HSLA(10,100%,50%,1);} /*color variable to reuse*/
    table, th, td { border: 1px solid black; background:wheat; border-collapse:collapse} 
    td{background: var(--col1)}
    body{background:darkred; /*overflow:hidden*/;margin:0px; }  /*overflow:hidden is great but not here*/
    div{font: 20px verdana; border:0; padding:1%;}
    #div1{background:gray;}
    #div2{/*no background: be use the body's background;*/}
    h2{padding: 0.5em; background:var(--col1) ; border:0; margin:0 }
    input{height:2em; background: var(--col1) }
</style>

<div id='div1'>
<h2>maintainance area</h2>
    <form method='post' action='backend.php'>
        <input type=text name='searchText'>
        <input type='submit' name='btnUsers' value='show Users'>
        <input type='submit' name='btnThreads' value='show Threads'>
        <input type='submit' name='btnMsg' value='show msg from user'>
        <input type='submit' name='btnKillUserFile' value='delete all users and file'>
        <input type='submit' name='btnDelUser' value='delete user.leave messages'>
        <input type='submit' name='btnKillMsgFile' value='delete ALL messages'>
        <input type='submit' name='btnFrontend' value='Frontend'>
    </form>
</div>
<div id='div2'>
    <?php echo $_SESSION['foot']; ?>
</div>

</body>