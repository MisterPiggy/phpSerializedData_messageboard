<?php

//register_functions_cleanData_saveData_Login.php
//if (!isset($_SESSION)) 
//    {echo 'starting session'; session_start();} 
//else { echo 'session running<br>';}
file_put_contents('log.txt', "\n".date("i:s\t")."\tregister_functions_cleanData_saveData_Login.php", FILE_APPEND );


scrutinizeRegisterData();

//button push registerme
function scrutinizeRegisterData() 
{
    // to do prevent double username
    if(isset($_POST['register']) && $_POST['register'] == "Register Me")
    {
        echo "reading user data";
        if( isset($_POST['username']) && $_POST['username'] &&
            isset($_POST['email']) && $_POST['email'] &&
            isset($_POST['pw'])  && $_POST['pw'])
            // local variables passed on
            {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $pw = $_POST['pw'];
            if
                (
                $username == testData2($username) &&
                $email == testData2($email) &&
                $pw == testData2($pw)
                )
                {   //all ok
                    $regDateT = date('m/d/Y h:i:s a', time());
                    saveRegisDataInUserFile($username,$email,$pw,$regDateT);
                }
            }
            else header('location:index.php'); // todo error msg wrong login
    }
}

function saveRegisDataInUserFile($username, $email, $pw, $regDateT)
{ //paramter könnten auch einfacher sein
    file_put_contents('log.txt', "\n".date("i:s\t")."function saveRegisDataInUserFile()", FILE_APPEND );
    $daten = array();
    $users = array();
    //todo check for doubles first by calling login
    // create NEW file if none, add userdata
    if(file_exists('regUsers.txt')== False)
    {
        $daten['id'] = 0; // first entry
        $daten['username'] = $username;
        $daten['email'] = $email;
        $daten['pw'] = $pw; 
        $daten['regDateT'] = $regDateT; 
        //
        $users[] = $daten; // mulitdimensionales array, je am Ende neuer Kunde dazu

        file_put_contents('regUsers.txt', serialize($users));
    }
    else// push user data into existing file
    {
        $filePath = './regUsers.txt';
        $users = unserialize( file_get_contents( $filePath ) );

        $daten['id'] = $users[count($users)-1]['id']+1;
        $daten['username'] = $username;
        $daten['email'] = $email;
        $daten['pw'] = $pw; 
        $daten['regDateT'] = $regDateT; 
		//print_r($daten);
        array_push($users,$daten); 
        file_put_contents('regUsers.txt', serialize($users));
    }
    // auto login after registered
    include 'scrutinizeAndLogin.php';
    //login();
}

// button login pushed; get login data from form 
// isset prevents error when user reloads page and post is empty, since
// page redirects to itself
if(isset($_POST['login']) && $_POST['login'] == "login") 
    scrutinizeLoginData();


function testData2($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data; 
}

?>