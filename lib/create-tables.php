<?php
    
    
    $errorMessage = "Error creating table: ";
    
    $query  = 'CREATE TABLE IF NOT EXISTS users (';
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
    
    $query  = 'CREATE TABLE IF NOT EXISTS courses (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'coursename varchar(54) NOT NULL,';
    $query .= 'major varchar(4) NOT NULL,';
    $query .= 'coursenum int NOT NULL,';
    $query .= 'schoolid varchar(8) NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "courses");
    } catch (Exception $e) {
        die ($errorMessage . "courses");
    }
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "votes");
    } catch (Exception $e) {
        die ($errorMessage . "votes");
    }
    
    $query  = 'CREATE TABLE IF NOT EXISTS comments (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'courseid varchar(8) NOT NULL,';
    $query .= 'comment varchar(2048) NOT NULL,';
    $query .= 'active tinyint DEFAULT 1,';
    $query .= 'ratingid varchar(8) NOT NULL,';
    $query .= 'userid varchar(8) NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ')';
    $query .= 'DEFAULT CHARSET=utf8 Collate utf8_unicode_ci;';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "comments");
    } catch (Exception $e) {
        die ($errorMessage . "comments");
    }
    
    $query  = 'CREATE TABLE IF NOT EXISTS ratings (';
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
    
    $query  = 'CREATE TABLE IF NOT EXISTS suggestions (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'userid varchar(8) DEFAULT \'FFFFFFFF\',';
    $query .= 'suggestion varchar(2048) NOT NULL,';
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
    
    $query  = 'CREATE TABLE IF NOT EXISTS majors (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'major varchar(10) NOT NULL,';
    $query .= 'school varchar(20) NOT NULL,';
    $query .= 'name varchar(50) NOT NULL,';
    $query .= 'schoolid varchar(8) NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "majors");
    } catch (Exception $e) {
        die ($errorMessage . "majors");
    }
    
    $query  = 'CREATE TABLE IF NOT EXISTS schools (';
    $query .= 'id varchar(8) NOT NULL,';
    $query .= 'name varchar(50) NOT NULL,';
    $query .= 'PRIMARY KEY(id)';
    $query .= ');';
    
    try {
        $statement = $db->prepare($query);
        if ($statement->execute() === FALSE)
            die ($errorMessage . "schools");
    } catch (Exception $e) {
        die ($errorMessage . "schools");
    }
    
?>
