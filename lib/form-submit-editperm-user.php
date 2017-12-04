<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /**
     * This is the form handler for changing user permissions. The required post fields are:
     *   - permissions (button)
     *   - id
     */
    
    
    if (isset($_POST['permissions']) && isset($_POST['id']) && ($_POST['permissions'] == 'Admin' || $_POST['permissions'] == 'Mod' || $_POST['permissions'] == 'Reg')){
        editUserperms($_POST['id'],$_POST['permissions'] );
    }
    header ('Location: ../admin-panel.php');
?>