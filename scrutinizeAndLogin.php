<?php
if(!isset($_SESSION)) session_start();
file_put_contents('log.txt', "\n".date("i:s\t")."scrutinizeAndLogin.php", FILE_APPEND );

scrutinizeLoginData();

function scrutinizeLoginData()
{
    file_put_contents('log.txt', "\n".date("i:s\t")."function scritinizeLoginData()", FILE_APPEND );
    // todo check login username for testdata
    // lese login daten
    if (isset($_SESSION['userName']) ) 
        {echo 'bereits eingeloggt'; 
        return; } // todo fix this
    else // if not logged in
        if( isset($_POST['username']) &&   //isset checks if exists AND if not null  //$_POST['username'] &&
            isset($_POST['pw']) &&
            $_POST['pw'] != '' &&
            $_POST['username']!='' ) // todo can password be injection?
            {
                $username = $_POST['username'];
                $pw = $_POST['pw'];
                if
                ( $username == testData($username) &&
                  $pw == testData($pw) )
                    { 
                    login();
                    }
                else { header("Location:index.php"); exit();  }
            }
        else // if empty fields 
        {
            //echo 'no empty fields'; // todo get message to start screen
            header("Location:index.php");
            exit();  
        }
}


function login()
{  // tests name, then pw. 
    file_put_contents('log.txt', "\n".date("i:s\t")."\tfunction login().. unserializes regusers.txt compare username and pw", FILE_APPEND );
    $filePath = './regUsers.txt';
    // if no users exist go back
        if(!file_exists($filePath)) header('location:index.php'); 
    $users = unserialize( file_get_contents( $filePath ) );// no need to unserialize when registered
    $_SESSION['loginGood'] = false; // not need since set to false on index_loginForm_RegisterButton_Top
    foreach($users as $key => $value )
    { 
        // SUCCESS USERNAME 
        //$_SESSION['log'] . '; check if username is good; ';
        if ($value['username']== $_POST['username'])
        {   
            file_put_contents('log.txt', "\n".date("i:s\t")."\tfound Username in users.txt", FILE_APPEND );
            // BAD PW return to login index.php
            if ($value['pw'] != $_POST['pw'])
            {
                $_SESSION['loginGood'] = false;
                $_SESSION['log'] . '; password is bad; ';
                file_put_contents('log.txt', "\n".date("i:s\t")."\tpw is bad", FILE_APPEND );
                header("Location:index.php");
                exit();  
            }
            // SUCCESSFUL LOGIN
            else {   
            $_SESSION['loginGood'] = true; 
            $_SESSION['log'].= "; $ _SESSION ['loginGood'] = true; ";
            file_put_contents('log.txt', "\n".date("i:s\t")."\tpw is good", FILE_APPEND );
            $_SESSION['userId'] = $key; 
            $_SESSION['output'] = 'password correct';    
            $_SESSION['username'] = $_POST['username'];
            }// go back to messageboard_showMessages_bottom
        }
    
    if($_SESSION['loginGood']) 
        {
            file_put_contents('log.txt', "\n".date("i:s\t")."\tlogin() set loginGood to TRUE", FILE_APPEND );
            break; 
        }   // leaves the foreach loop and continues with below
    }
    // in any case delete variables
    unset($value,$key,$users);
    unset ($_POST['pw']); // for safety
	// get all users in order to display messages with names. with this user included
	$_SESSION['users'] = unserialize( file_get_contents( './regUsers.txt' ));

	// finally bad login takes back to login page
    if($_SESSION['loginGood'] == false) 
    {
        file_put_contents('log.txt', "\n".date("i:s\t")."\tlogin() set loginGood to FALSE", FILE_APPEND );
        $_SESSION['output'] = 'no such user'; // todo get message to start screen
        header("Location:index.php");
        exit();  
    }
    header("Location:messageboard.php");   // NEW entry. 
}


function testData($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data; 
}

?>