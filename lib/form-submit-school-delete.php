<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for deleting a school. The required post fields are:
     *   - delete (button)
     *   - id
     */
    
    
    
    if (isset($_POST['delete']) && $_POST['delete'] == 'Delete School' && isset($_POST['id']))
        deleteSchool($_POST['id']);
    
    header ('Location: /createschool');