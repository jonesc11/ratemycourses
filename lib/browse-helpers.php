<?php
    
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    /*
     * Returns a div for each school with a ul of all the majors in that school.
     * The majors are anchor tags that link to BASE/major?q=*CODE*
     * Each div has an ID "display-*code*"
     * 
     * Viable codes:
     *  - BUS (School of Business Management
     *  - SCI (School of Science)
     *  - HASS (School of Humanities, Arts, and Social Sciences)
     *  - ENG (School of Engineering)
     *  - ARCH (School of Architecture)
     *  - OTH (Other)
     */
    function getMajorNav($school) {
        $ret = '';
        
        global $db;
        global $dbname;
        
        //- Run SQL statement
        $statement = $db->prepare('SELECT * FROM `majors` WHERE `schoolid` = :school');
        $result = $statement->execute(array (':school' => $school));
        
        //- Set up base array
        $arr = array();
        
        //- Parse SQL
        while ($row = $statement->fetch()) {
            $arr[$row['school']]['majors'][$row['major']] = $row['name'];
            $arr[$row['school']]['name'] = $row['school'];
        }
        
        $statement = $db->prepare('SELECT * FROM `schools` WHERE `id` = :school');
        $result = $statement->execute(array (':school' => $school));
        $schoolname = $statement->fetch();
      
        //- Loops
        $ret .= '<div id="coursenav-container" class="initial-view"><h1>' . ucwords(strtolower($schoolname['name'])) . '</h1><div id ="coursenav" class="course">';
        foreach ($arr as $code => $school) {
            $name = $school['name'];
            $majors = $school['majors'];
            ksort($majors);
            
            $ret .= '<div id="display-' . $code . '" class="display-school">';
            $ret .= '<h2 class="school-name">' . ucwords($name) . '</h2><ul class="ul-school">';
            foreach ($majors as $majorCode => $majorName) {
                $ret .= '<li class="li-major"><a class="major-link" title="' . strtoupper($majorCode) . '"><span class="major-code">' . strtoupper($majorCode) . ' </span>' . ucwords($majorName) . '</a></li>';
            }
            $ret .= '</div>';
        }
        $ret .= '</div><h3>Don\'t see a course listed? Have any suggestions? <a href="/suggest/index.php">Click here!</a></h3></div>';
        if(empty($arr)) {
          $ret = '<div class="no-results"><h2>There are currently no courses listed for ' . ucwords(strtolower($schoolname['name'])) . '</h2>';
          $ret .= '<h3>Want to suggest a course? <a href="/suggest/index.php">Click here!</a></h3></div>';
        }
        return $ret;
    }
    
    /* 
     * Returns a bunch of divs with class 'course' in a div with id 'courses-$majorCode'.
     * Class names are in a span of class 'course-name', and class identifiers are in a
     * span with class 'course-identifier'. Gets all the courses under the major code
     * specified in the parameters.
     */
    if(isset($_POST['major'])) {
      echo getNavPerMajor($_POST['major']);
    }

    function getNavPerMajor($majorCode) {
        $ret = '';
        
        global $db;
        
        //- Execute SQL statement.
        $statement = $db->prepare('SELECT * FROM `courses` WHERE `major` = :major');
        $result = $statement->execute(array (':major' => $majorCode));
        
        $courses = array();
        
        //- Loop through, add to an array of courses with the course number as key
        while ($row = $statement->fetch())
            $courses[$row['coursenum']] = $row;
        
        //- Sort the array
        ksort($courses);
        
        //- Print the list of courses into a div.
        $ret .= '<div id="courses-' . $majorCode . '">';
        $ret .= '<h2>'. ucwords(strtoupper($majorCode)) .' Courses</h2>';
        foreach ($courses as $course) {
            $ret .= '<div class="course"><a href="../viewcourse/?c='. $course['id'] . '"><span class="course-identifier"> ' . strtoupper($course['major']) . ' ' . $course['coursenum'] . '</span>';
            $ret .= ' - <span class="course-name">' . $course['coursename'] . '</span></a></div>';
        }
        $ret .= '</div>';
        
        return $ret;
    }
    
?>