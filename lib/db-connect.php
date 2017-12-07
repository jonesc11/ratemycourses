<?php

    //- Fill in fields as necessary.
    $username = 'root';
    $password = '';
    $host     = 'localhost';
    $dbname   = 'ratemycourses';
    
    try{
        $conn = new PDO('mysql:host=localhost', $username, 
        $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo "ERROR:" . $e->getMessage();
    }

    $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    
    $errorMessage  = "Error connecting to database. Please contact <a href=\"mailto:jonesc11@rpi.edu\">jonesc11@rpi.edu</a>\n";
    
    //- Check creating the databases
    try {
        $sql = "CREATE DATABASE IF NOT EXISTS ratemycourses";

        $conn->exec($sql);
        $db = new PDO("mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8", $username, $password, $options);
    } catch (PDOException $e) {
        die ($errorMessage);
    }
    
    //- Set defaults to make things easier to read.
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    header('Content-Type: text/html; charset=utf-8');
    
    //- Loads session variables. Due to this, make sure this script is included on every page.
    session_start();
    
    //- Run create tables to create the tables if they don't already exist
    require('create-tables.php');