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
     * Returns the next hex value for the course IDs.
     */
    function genNewCourseId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `courses` WHERE 1 = 1;");
        
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
     * Returns the next hex value for the major IDs.
     */
    function genNewMajorId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `majors` WHERE 1 = 1;");
        
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
        
        //- Insert school
        if (isset($array['schoolname'])) {
            $school = $array['schoolname'];
            $id = genNewSchoolId();
            
            //- Check if school by that name already exists.
            $statement = $db->prepare("SELECT * FROM `schools` WHERE `name` = :name");
            $statement->execute(array(':name' => trim(strtoupper($school))));
            
            if ($statement->fetch() !== FALSE)
                return false;
            
            $statement = $db->prepare("INSERT INTO `schools` (`id`, `name`) VALUES (:id, :name)");
            $statement->execute(array(':id' => $id, ':name' => trim(strtoupper($school))));
            
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
        
        $ret = '<table id="schools"><th>School</th><th>Number of Courses</th>';
        
        while ($school = $statementSchools->fetch()) {
            $statementCount = $db->prepare('SELECT COUNT(id) AS count FROM `courses` WHERE `schoolid` = :sid');
            $statementCount->execute(array(':sid' => $school['id']));
            
            $count = $statementCount->fetch();
            
            $ret .= '<tr><td>' . ucwords(strtolower($school['name'])) . '</td>';
            
            if (isset($count) && isset($count['count'])) {
                $ret .= '<td>' . $count['count'] . '</td>';
            } else {
                $ret .= '<td>0</td>';
            }
            
            $ret .= '<td><form method="POST" action="/lib/form-submit-school-delete.php"><input class="btn" type="submit" name="delete" value="Delete School" /><input type="hidden" name="id" value="' . $school['id'] . '" /></form>';
        }
        
        $ret .= '</table>';
        
        return $ret;
    }
    
    /**
     * Returns a select field with all of the schools.
     */
    function getSchoolSelect() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `schools` ORDER BY `name`");
        $statement->execute();
        
        $ret  = '<select class="school-input-field" name="school">';
        $ret .= '<option value="-1" selected>-- SELECT A SCHOOL --</option>';
        
        while ($school = $statement->fetch()) {
            $ret .= '<option value="' . $school['id'] . '">' . ucwords(strtolower($school['name'])) . '</option>';
        }
        
        $ret .= '</select>';
        
        return $ret;
    }
    
    /**
     * Deletes a school with a given id and all courses, majors, and comments related to it.
     */
    function deleteSchool($schoolid) {
        global $db;
        
        $statement = $db->prepare("DELETE FROM `schools` WHERE `id` = :id");
        $statement->execute(array(':id' => $_POST['id']));
        
        //- Get all courses
        $statement = $db->prepare("SELECT * FROM `courses` WHERE `schoolid` = :schoolid");
        $statement->execute(array(':schoolid' => $schoolid));
        $courseids = array();
        
        //- Loop through courses and delete all votes on the comments, then delete comments on that course, then delete the course
        while ($course = $statement->fetch()) {
            $courseids[] = $course['id'];
            
            $statementGetComments = $db->prepare("SELECT * FROM `comments` WHERE `courseid` = :courseid");
            $statementGetComments->execute(array(':courseid' => $course['id']));
            $commentids = array();
            
            while ($comment = $statementGetComments->fetch()) {
                $commentids[] = $comment['id'];
                
                $statementGetVotes = $db->prepare("SELECT * FROM `votes` WHERE `commentid` = :commentid");
                $statementGetVotes->execute(array(':commentid' => $comment['id']));
                $voteids = array();
                
                while ($vote = $statementGetVotes->fetch())
                    $voteids[] = $vote['id'];
                
                foreach ($voteids as $id) {
                    $statementDelVotes = $db->prepare("DELETE FROM `votes` WHERE `id` = :id");
                    $statementDelVotes->execute(array(':id' => $id));
                }
            }
            
            foreach ($commentids as $id) {
                $statementDelComment = $db->prepare("DELETE FROM `comments` WHERE `id` = :id");
                $statementDelComment->execute(array(':id' => $id));
            }
        }
    
        foreach ($courseids as $id) {
            $statement = $db->prepare("DELETE FROM `courses` WHERE `id` = :id");
            $statement->execute(array(':id' => $id));
        }
        
        //- Delete all majors
        $statement = $db->prepare("SELECT * FROM `majors` WHERE `schoolid` = :schoolid");
        $statement->execute(array(':schoolid' => $schoolid));
        $majorids = array();
        
        while ($major = $statement->fetch())
            $majorids[] = $major['id'];
        
        foreach ($majorids as $id) {
            $statement = $db->prepare("DELETE FROM `majors` WHERE `id` = :id");
            $statement->execute(array(':id' => $id));
        }
    }
    
    /**
     * Creates a new course, returns true if successful, error code otherwise. Array must have schoolid, coursename, major, coursenum.
     */
    function createCourse($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('Input must be an array.');
        
        //- Check inputs
        if (isset($array['schoolid']))
            $schoolid = $array['schoolid'];
        else
            throw new Exception('schoolid not sent in input.');
        
        if (isset($array['coursename']))
            $coursename = $array['coursename'];
        else
            throw new Exception('coursename not sent in input.');
        
        if (isset($array['major']))
            $major = $array['major'];
        else
            throw new Exception('major not sent in input.');
        
        if (isset($array['coursenum']))
            $coursenum = $array['coursenum'];
        else
            throw new Exception('coursenum not sent in input.');
        
        //- Check school ID
        $statement = $db->prepare("SELECT * FROM `schools` WHERE `id` = :id");
        $statement->execute(array(':id' => $schoolid));
        
        if ($statement->fetch() === FALSE)
            return 's';
        
        //- Check major exists
        $statement = $db->prepare("SELECT * FROM `majors` WHERE `major` = :major AND `schoolid` = :schoolid;");
        $statement->execute(array(':schoolid' => $schoolid, ':major' => $major));
        
        if ($statement->fetch() === FALSE)
            return 'm';
        
        //- Check course exists
        $statement = $db->prepare("SELECT * FROM `courses` WHERE `major` = :major AND `schoolid` = :schoolid AND `coursenum` = :coursenum;");
        $statement->execute(array(':schoolid' => $schoolid, ':major' => $major, ':coursenum' => $coursenum));
        
        if ($statement->fetch() !== FALSE)
            return 'n';
        
        $id = genNewCourseId();
        
        //- Insert
        $statement = $db->prepare("INSERT INTO `courses` (`id`, `coursename`, `major`, `coursenum`, `schoolid`) VALUES (:id, :coursename, :major, :coursenum, :schoolid)");
        $statement->execute(array(':id' => $id, ':coursename' => $coursename, ':major' => $major, ':coursenum' => $coursenum, ':schoolid' => $schoolid));
        
        return true;
    }
    
    /**
     * Returns a table that has the number of courses for each school.
     */
    function getCourses($school) {
        global $db;
        
        $statementSchools = $db->prepare("SELECT * FROM `schools` ORDER BY `name`");
        $statementSchools->execute();
        
        $ret = '<table id="courses">';
        
        while ($school = $statementSchools->fetch()) {
            $statementCount = $db->prepare('SELECT COUNT(id) AS count FROM `courses` WHERE `schoolid` = :sid');
            $statementCount->execute(array(':sid' => $school['id']));
            
            $count = $statementCount->fetch();
            
            $ret .= '<tr><td>' . ucwords(strtolower($school['name'])) . '</td>';
            
            if (isset($count) && isset($count['count'])) {
                $ret .= '<td>' . $count['count'] . '</td>';
            } else {
                $ret .= '<td>0</td>';
            }
            
            $ret .= '<td><form method="POST" action="/lib/form-submit-school-delete.php"><input class="btn" type="submit" name="delete" value="Delete School" /><input type="hidden" name="id" value="' . $school['id'] . '" /></form>';
        }
        
        $ret .= '</table>';
        
        return $ret;
    }
    
    /**
     * Returns a table that has all of the courses for the specified school.
     */
    function listCourses($school) {
        global $db;
        
        $ret = '<div id="courses">';
        
        $statement = $db->prepare("SELECT * FROM `schools` WHERE `id` = :id");
        $statement->execute(array(':id' => $school));
        
        if ($schoolRow = $statement->fetch()) {
            $ret .= '<h1>' . ucwords(strtolower($schoolRow['name'])) . '</h1>';
            
            $statement = $db->prepare("SELECT * FROM `courses` WHERE `schoolid` = :schoolid ORDER BY `major`, `coursenum`");
            $statement->execute(array(':schoolid' => $school));
            
            $ret .= '<table><th>Course</th><th>Major Code</th><th>Course Number</th><th>Delete Course</th>';
            
            while ($course = $statement->fetch()) {
                $ret .= '<tr><td>' . $course['coursename'] . '</td>';
                $ret .= '<td>' . $course['major'] . '</td>';
                $ret .= '<td>' . $course['coursenum'] . '</td></tr>';
                $ret .= '<td><form method="POST" action="/lib/form-submit-course-delete.php"><input class="btn" type="submit" name="delete" value="Delete Course" /><input type="hidden" name="id" value="' . $course['id'] . '" /></form> </td> </tr>';
            }
            
            $ret .= '</table>';
        }
        
        $ret .= '</div>';
        
        return $ret;
    }

    /**
     * Deletes a course and everything associated with it.
     */
    function deleteCourse($courseid) {
        global $db;
        
        $statementGetComments = $db->prepare("SELECT * FROM `comments` WHERE `courseid` = :courseid");
        $statementGetComments->execute(array(':courseid' => $courseid));
        $commentids = array();
        
        while ($comment = $statementGetComments->fetch()) {
            $commentids[] = $comment['id'];
            
            $statementGetVotes = $db->prepare("SELECT * FROM `votes` WHERE `commentid` = :commentid");
            $statementGetVotes->execute(array(':commentid' => $comment['id']));
            $voteids = array();
            
            while ($vote = $statementGetVotes->fetch())
                $voteids[] = $vote['id'];
            
            foreach ($voteids as $id) {
                $statementDelVotes = $db->prepare("DELETE FROM `votes` WHERE `id` = :id");
                $statementDelVotes->execute(array(':id' => $id));
            }
        }
        
        foreach ($commentids as $id) {
            $statementDelComment = $db->prepare("DELETE FROM `comments` WHERE `id` = :id");
            $statementDelComment->execute(array(':id' => $id));
        }
        
        $statement = $db->prepare("DELETE FROM `courses` WHERE `id` = :id");
        $statement->execute(array(':id' => $courseid));
    }
    
    /**
     * Creates a new major. Returns true or an error code.
     */
    function createMajor($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('Input must be an array.');
        
        $statement = $db->prepare("SELECT * FROM `schools` WHERE `id` = :id");
        $statement->execute(array(':id' => $array['schoolid']));
        
        if ($statement->fetch() === FALSE)
            return 'u';
        
        $id = genNewMajorId();
        
        $statement = $db->prepare("INSERT INTO `majors` (`id`, `major`, `school`, `name`, `schoolid`) VALUES (:id, :major, :school, :name, :schoolid)");
        $statement->execute(array(':id' => $id, ':major' => $array['major'], ':school' => $array['school'], ':name' => $array['name'], ':schoolid' => $array['schoolid']));
        
        return true;
    }
    
    /**
     * Returns a table of the majors for the school with the specified ID.
     */
    function getMajors($school) {
        global $db;
        
        $ret = '<div id="majors">';
        
        $statement = $db->prepare("SELECT * FROM `schools` WHERE `id` = :id");
        $statement->execute(array(':id' => $school));
        
        if ($schoolRow = $statement->fetch()) {
            $ret .= '<h1>' . ucwords(strtolower($schoolRow['name'])) . '</h1>';
            
            $statement = $db->prepare("SELECT * FROM `majors` WHERE `schoolid` = :schoolid ORDER BY `school`, `major`");
            $statement->execute(array(':schoolid' => $school));
            
            $ret .= '<table><th>Major</th><th>Major Code</th><th>School</th> <th> Delete </th>';
            
            while ($major = $statement->fetch()) {
                $ret .= '<tr><td>' . $major['name'] . '</td>';
                $ret .= '<td>' . $major['major'] . '</td>';
                $ret .= '<td>' . $major['school'] . '</td></tr>';
                $ret .= '<td><form method="POST" action="/lib/form-submit-major-delete.php"><input class="btn" type="submit" name="delete" value="Delete Major" /><input type="hidden" name="id" value="' . $major['id'] . '" /></form> </td> </tr>';
            }
            
            $ret .= '</table>';
        }
        
        $ret .= '</div>';
        
        return $ret;
    }
    //Deletes a major
    function deleteMajor($majorid) {
        global $db;
        echo '<script>alert("' . $majorid . '");</script>';
        //get major
        $statement = $db->prepare("SELECT * FROM `majors` WHERE `id` = :id");
        $statement->execute(array(':id' => $majorid));
        if (($major = $statement->fetch()) === false){
            die();
        }

        //get courses by major and school
        $statementGetCourses = $db->prepare("SELECT * FROM `courses` WHERE `major` = :major and `schoolid` = :schoolid");
        $statementGetCourses->execute(array(':major' => $major['major'], ':schoolid' => $major['schoolid']));

        $courseids = array();
        
        $courseids = $statementGetCourses->fetchall();
        //Delete each course in the array
        for ($i=0; $i<count($courseids);$i++){
            echo deleteCourse($courseids[$i]['id']);
        }
        $delMajor = $db->prepare("DELETE FROM `majors` WHERE `id` = :id");
        $delMajor->execute(array(':id' => $majorid));
    }

?>