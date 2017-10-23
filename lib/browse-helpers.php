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
    function getMajorNav($db, $dbname) {
        $ret = '';
        
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
        foreach ($schools as $code => $school) {
            $name = $school['name'];
            $majors = $school['majors'];
            ksort($majors);
            
            $ret .= '<div id="display-' . $code . '">';
            $ret .= '<h2 class="school-name">' . $name . '</h2><ul class="ul-school">';
            foreach ($majors as $majorCode => $majorName) {
                $ret .= '<li class="li-major"><a href="/browse/?q=' . $majorCode . '" title="' . $majorName . '"><span class="major-code">' . $majorCode . '</span>' . $majorName . '</a></li>';
            }
            $ret .= '</div>';
        }
        
        return $ret;
    }
    
    /* 
     * 
     */
    function getNavPerMajor($majorCode) {
        
    }
    
?>