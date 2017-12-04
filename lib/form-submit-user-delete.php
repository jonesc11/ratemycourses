<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /**
     * This is the form handler for deleting a course. The required post fields are:
     *   - delete (button)
     *   - id
     */
    
    
    if (isset($_POST['delete']) && $_POST['delete'] == 'Delete User' && isset($_POST['id']))
        deleteUsers($_POST['id']);
    
    header ('Location: ../admin-panel.php');

?>