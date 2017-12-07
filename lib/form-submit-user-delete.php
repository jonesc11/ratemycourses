<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /**
     * This is the form handler for deleting a course. The required post fields are:
     *   - delete (button)
     *   - id
     */
    
    //- Call the deleteUser function and redirect back to the admin panel
    if (isset($_POST['delete']) && $_POST['delete'] == 'Delete User' && isset($_POST['id']) && $_SESSION['user']['permissions'] >= 1)
        deleteUsers($_POST['id']);
    
    header ('Location: ../admin-panel.php');

?>