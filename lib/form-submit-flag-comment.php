<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    /**
     * This is the form handler for flagging a comment. The required post fields are:
     *   - flag (button)
     *   - id
     */
    
    
    if (isset($_POST['flag']) && isset($_POST['id']) && isset($_POST['cid']) && $_POST['flag'] == 'Flag Comment' ){
        $courseid = $_POST['cid'];
        flagComment($_POST['id']);
    }
    header ('Location: /viewcourse?c=' . $courseid);
?>