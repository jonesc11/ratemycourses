<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    /**
     * Returns the next hex value for the school IDs.
     */
    function genNewSchoolId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `schools` WHERE 1 = 1;");
        
        if ($statement->execute()) {
            $max = -1;
            
            while ($row = $statement->fetch()) {
                if ($max < hexdec($row['id'])) {
                    $max = hexdec($row['id']);
                }
            }
            
            $max++;
            return dechex($max);
        } else {
            return false;
        }
    }
    
    /**
     * Takes in an array with a school name and adds that to the database.
     */
    function createSchool($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('Input must be an array.');
        
        if (isset($array['schoolname'])) {
            $school = $array['schoolname'];
            $id = genNewSchoolId();
            
            $statement = $db->prepare("INSERT INTO `schools` (`id`, `name`) VALUES (:id, :name)");
            $statement->execute(array(':id' => $id, ':name' => $school));
            
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns a table with all of the schools and the number of courses in the schools.
     */
    function getSchools() {
        global $db;
        
        $statementSchools = $db->prepare("SELECT * FROM `schools` ORDER BY `name`");
        $statementSchools->execute();
        
        $ret = '<table id="schools">';
        
        while ($school = $statementSchools->fetch()) {
            $statementCount = $db->prepare('SELECT COUNT(id) AS count FROM `courses` WHERE `schoolid` = :sid');
            $statementCount->execute(array(':sid' => $school['id']));
            
            $count = $statementCount->fetch();
            
            $ret .= '<tr><td>' . $school['name'] . '</td>';
            
            if (isset($count) && isset($count['count'])) {
                $ret .= '<td>' . $count['count'] . '</td></tr>';
            } else {
                $ret .= '<td>0</td></tr>';
            }
        }
        
        $ret .= '</table>';
        
        return $ret;
    }

?>