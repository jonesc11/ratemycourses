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
    
    
    
    if (isset($_POST['school']) && $_POST['school'] != -1)
        $schoolid = strip_tags($_POST['school']);
    else
        header ('Location: /createcourse?e=s');
    
    if (isset($_POST['coursename']) && $_POST['coursename'] != '')
        $coursename = strip_tags($_POST['coursename']);
    else
        header ('Location: /createcourse?e=c');
    
    if (isset($_POST['major']) && $_POST['major'] != '')
        $major = strip_tags($_POST['major']);
    else
        header ('Location: /createcourse?e=m');
    
    if (isset($_POST['coursenum']) && is_numeric($_POST['coursenum']))
        $coursenum = strip_tags($_POST['coursenum']);
    else
        header ('Location: /createcourse?e=n');
    
    if ($_SESSION['user']['permissions'] >= 1) {
        $createParam = array('coursenum' => $coursenum, 'major' => $major, 'coursename' => $coursename, 'schoolid' => $schoolid);
        $result = createCourse($createParam);
    }
    
    if ($result === TRUE)
        header ('Location: /createcourse?s=' . $_POST['school']);
    else
        header ('Location: /createcourse?e=' . $result);