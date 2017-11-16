<?php
    
    require_once ('db-connect.php');
    
    $errorMessage = "Error creating table: ";
    
    $query  = 'CREATE TABLE users (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'username varchar(32) NOT NULL,';
    $query .= 'password varchar(128) NOT NULL,';
    $query .= 'salt varchar(16) NOT NULL,';
    $query .= 'email varchar(128) NOT NULL,';
    $query .= 'permissions int DEFAULT 0,';
    $query .= 'firstname varchar(16) NOT NULL,';
    $query .= 'lastname varchar(16) NOT NULL,';
    $query .= 'active tinyint DEFAULT 1,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "users");
    } catch (Exception $e) {
        die ($errorMessage . "users");
    }
    
    $query  = 'CREATE TABLE courses (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'coursename varchar(54) NOT NULL,';
    $query .= 'major varchar(4) NOT NULL,';
    $query .= 'coursenum int NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "courses");
    } catch (Exception $e) {
        die ($errorMessage . "courses");
    }
    
    $query  = 'CREATE TABLE votes (';
    $query .= 'id varchar(24) NOT NULL,';
    $query .= 'vote int NOT NULL,';
    $query .= 'commentid varchar(16) NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "votes");
    } catch (Exception $e) {
        die ($errorMessage . "votes");
    }
    
    $query  = 'CREATE TABLE comments (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'courseid varchar(8) NOT NULL,';
    $query .= 'comment varchar(2048) NOT NULL,';
    $query .= 'active tinyint DEFAULT 1,';
    $query .= 'ratingid varchar(8) NOT NULL,';
    $query .= 'userid varchar(8) NOT NULL';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "comments");
    } catch (Exception $e) {
        die ($errorMessage . "comments");
    }
    
    $query  = 'CREATE TABLE ratings (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'category1 int DEFAULT NULL,';
    $query .= 'category2 int DEFAULT NULL,';
    $query .= 'category3 int DEFAULT NULL,';
    $query .= 'category4 int DEFAULT NULL,';
    $query .= 'category5 int DEFAULT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "ratings");
    } catch (Exception $e) {
        die ($errorMessage . "ratings");
    }
    
    $query  = 'CREATE TABLE suggestions (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'coursename varchar(54) NOT NULL,';
    $query .= 'major varchar(4) NOT NULL,';
    $query .= 'coursenum int NOT NULL,';
    $query .= 'userid varchar(8) DEFAULT \'FFFFFFFF\',';
    $query .= 'suggestion varchar(2048) NOT NULL';
    $query .= 'status int DEFAULT 0,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "suggestions");
    } catch (Exception $e) {
        die ($errorMessage . "suggestions");
    }
    
    $query  = 'CREATE TABLE majors (';
    $query .= 'major varchar(4) NOT NULL,';
    $query .= "school enum('HASS','SCI','ENG','BUS','ARCH','OTH') NOT NULL,";
    $query .= 'name varchar(50) NOT NULL,';
    $query .= 'PRIMARY KEY(major)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "suggestions");
    } catch (Exception $e) {
        die ($errorMessage . "suggestions");
    }
    
?>