<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for creating a new school. The required post fields are:
     *   - schoolname
     */
    
    $courseid = $_POST['schoolname'];
    
    $schoolParam = array('schoolname' => $_POST['schoolname']);
    createSchool($schoolParam);
    
    header ('Location: /createschool');