<?php
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php'); 

    //- Parse the variables
    if(isset($_POST["username"]))
        $username = strip_tags($_POST["username"]);
    if(isset($_POST["password"]))
        $password = $_POST["password"];
    
    //- Get the login stuff
    $ret = login($username, $password);
    if ($ret == true){
        echo '<script> window.location ="' . $_SERVER['HTTP_REFERER'] . '"; </script>';        
    }
    else{
        echo genLoginForm(array("error" => "Username and password do not match.", "username" => $username));
    }
        

?>