<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for creating a new course. The required post fields are:
     *   - schoolid
     *   - coursename
     *   - major (must exist in majors table)
     *   - coursenum
     *
     * This also may redirect back with error codes to be processed by the createcourse page.
     *   - s: school ID invalid
     *   - c: coursename invalid
     *   - m: major invalid
     *   - n: coursenum invalid
     */
    
    if (isset($_POST['submit']) && $_POST['submit'] == 'Get Courses') {
        if (isset($_POST['school']) && $_POST['school'] != -1) {
            header ('Location: /createcourse?s=' . trim($_POST['school']));
        } else {
            header ('Location: /createcourse');
        }
    } else {
        header ('Location: /createcourse');
    }
?>