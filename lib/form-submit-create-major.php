<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /**
     * This is the form handler for creating a new course. The required post fields are:
     *   - school
     *   - majorname
     *   - major (must exist in majors table)
     *   - schoolname
     *
     * This also may redirect back with error codes to be processed by the createcourse page.
     *   - u: school ID invalid
     *   - s: schoolname invalid
     *   - m: major invalid
     *   - n: majorname invalid
     */
    
    
    
    if (isset($_POST['school']) && $_POST['school'] != -1)
        $schoolid = strip_tags($_POST['school']);
    else
        header ('Location: /createmajor?e=u');
    
    if (isset($_POST['majorname']) && $_POST['majorname'] != '')
        $majorname = strip_tags($_POST['majorname']);
    else
        header ('Location: /createmajor?e=n');
    
    if (isset($_POST['major']) && $_POST['major'] != '')
        $major = strip_tags($_POST['major']);
    else
        header ('Location: /createmajor?e=m');
    
    if (isset($_POST['schoolname']) && $_POST['schoolname'])
        $schoolname = strip_tags($_POST['schoolname']);
    else
        header ('Location: /createmajor?e=s');
    
    $createParam = array('name' => $majorname, 'school' => $schoolname, 'schoolid' => $schoolid, 'major' => $major);
    $result = createMajor($createParam);
    
    if ($result === TRUE)
        header ('Location: /createmajor?s=' . $schoolid);
    else
        header ('Location: /createmajor?e=' . $result);