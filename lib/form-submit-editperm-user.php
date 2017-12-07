<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /**
     * This is the form handler for changing user permissions. The required post fields are:
     *   - permissions (button)
     *   - id
     */
    
    //- Set the user permission and return back to the admin panel
    if (isset($_POST['permissions']) && isset($_POST['id']) && ($_POST['permissions'] == 'Admin' || $_POST['permissions'] == 'Mod' || $_POST['permissions'] == 'Reg') && $_SESSION['user']['permissions'] >= 2){
        editUserperms($_POST['id'],$_POST['permissions'] );
    }
    header ('Location: ../admin-panel.php');
?>