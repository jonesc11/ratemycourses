<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for deleting a course. The required post fields are:
     *   - delete (button)
     *   - id
     */
    
    
    if (isset($_POST['delete']) && $_POST['delete'] == 'Delete Course' && isset($_POST['id']))
        deleteCourse($_POST['id']);
    
    header ('Location: /createcourse');

?>