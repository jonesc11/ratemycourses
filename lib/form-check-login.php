<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    /**
     * This is the form handler for checking if a user is logged in before 
     * redirecting to the create comment page. The required post fields are:
     *   - rate (button)
     *   - courseid
     */
    
    //- Check if the user is logged in
    //- If the user is logged in, redirect to the create comment page for the course
    //- If the user is not logged in open the login modal
    if (isset($_POST['rate']) && isset($_POST['cid']) && $_POST['rate'] == 'Rate this course' ){
        if (!isset($_SESSION['user'])) {
          $courseid = $_POST['cid'];
          header ('Location: /viewcourse/?c=' . $courseid . '&l=1');
        }
        else {
          $courseid = $_POST['cid'];
          header ('Location: /createcomment/?c=' . $courseid);
        }
    }
?>