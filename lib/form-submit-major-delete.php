<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for deleting a major. The required post fields are:
     *   - delete (button)
     *   - id
     */
    
    //- Delete the major and redirect
    if (isset($_POST['delete']) && $_POST['delete'] == 'Delete Major' && isset($_POST['id']) && $_SESSION['user']['permissions'] >= 1){
        deleteMajor($_POST['id']);
    }
    
    header ('Location: /createmajor?s=' . $_POST['schoolid']);

?>