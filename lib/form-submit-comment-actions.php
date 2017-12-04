<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    /**
     * This is the form handler for unflagging or deleting a comment. The required post fields are:
     *   - delete  or unflag(button)
     *   - id
     */
    
    
    if (isset($_POST['flagged']) && isset($_POST['id'])){
        if ($_POST['flagged']== 'Unflag Comment'){
        unflagComment($_POST['id']);
        }
        else if ($_POST['flagged']== 'Delete Comment'){
            deleteComment($_POST['id']);
        }
    }
    
    header ('Location: ../admin-panel.php');

?>