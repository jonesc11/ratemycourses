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
    function getMajorNav() {
        $ret = '';
        
        global $db;
        global $dbname;
        
        //- Run SQL statement
        $statement = $db->prepare('SELECT * FROM `majors`;');
        $result = $statement->execute();
        
        //- Set up base array
        $arr = array('HASS' => array('name' => 'School of Humanities, Arts, and Social Sciences',
                                     'majors' => array()),
                     'ENG' => array('name' => 'School of Engineering',
                                    'majors' => array()),
                     'SCI' => array('name' => 'School of Science',
                                    'majors' => array()),
                     'ARCH' => array('name' => 'School of Architecture',
                                     'majors' => array()),
                     'BUS' => array('name' => 'School of Business Management',
                                    'majors' => array()),
                     'OTH' => array('name' => 'Other',
                                    'majors' => array()));
        
        //- Parse SQL
        while ($row = $statement->fetch())
            $arr[$row['school']]['majors'][$row['major']] = $row['name'];
        
        
        
        //- Loops
        foreach ($arr as $code => $school) {
            $name = $school['name'];
            $majors = $school['majors'];
            ksort($majors);
            
            $ret .= '<div id="display-' . $code . '" class="display-school">';
            $ret .= '<h2 class="school-name">' . $name . '</h2><ul class="ul-school">';
            foreach ($majors as $majorCode => $majorName) {
                $ret .= '<li class="li-major"><a class="major-link" title="' . $majorCode . '"><span class="major-code">' . $majorCode . ' </span>' . $majorName . '</a></li>';
            }
            $ret .= '</div>';
        }
        
        return $ret;
    }
    
    /* 
     * Returns a bunch of divs with class 'course' in a div with id 'courses-$majorCode'.
     * Class names are in a span of class 'course-name', and class identifiers are in a
     * span with class 'course-identifier'. Gets all the courses under the major code
     * specified in the parameters.
     */
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
        $ret .= '<h2>'. $majorCode .' Courses</h2>';
        foreach ($courses as $course) {
            $ret .= '<div class="course"><a href="#"><span class="course-identifier"> ' . $course['major'] . ' ' . $course['coursenum'] . '</span>';
            $ret .= ' - <span class="course-name">' . $course['coursename'] . '</span></a></div>';
        }
        $ret .= '</div>';
        
        return $ret;
    }
    
?>