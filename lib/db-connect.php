<?php

    //- Fill in fields as necessary.
    $username = '';
    $password = '';
    $host     = '';
    $dbname   = 'ratemycourses';
    
    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    
    $errorMessage  = "Error connecting to database. Please contact <a href=\"mailto:jonesc11@rpi.edu\">jonesc11@rpi.edu</a>\n";
    
    try {
        $db = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8", $username, $password, $options);
    } catch (PDOException $e) {
        die ($errorMessage);
    }
    
    //- Set defaults to make things easier to read.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    //- Loads session variables. Due to this, make sure this script is included on every page.
    session_start();