<?php

    require_once (__DIR__  . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    /**
     * Returns the next hex value for the comment IDs.
     */
    function genNewCommentId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `comments` WHERE 1 = 1;");
        
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
     * Returns the next hex value for the rating IDs.
     */
    function genNewRatingId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `ratings` WHERE 1 = 1;");
        
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
     * Takes in an array that must have values courseid, comment, userid, and ratingid. Returns the new comment ID or false.
     */
    function createComment($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('comment-helpers.php/createComment -> Parameter must be an array.');
        
        $newId = genNewCommentId();
        
        $query = "INSERT INTO `comments` (`id`, `courseid`, `comment`, `ratingid`, `userid`) VALUES (:id, :courseid, :comment, :ratingid, :userid);";
        $param = array (':id' => $newId, ':courseid' => $array['courseid'], ':comment' => $array['comment'], ':ratingid' => $array['ratingid'], ':userid' => $array['userid']);
        
        $statement = $db->prepare($query);
        $result = $statement->execute($param);
        
        if ($result !== FALSE)
            return $newId;
        else
            return false;
    }
    
    /**
     * Takes in an array that must have values at rating1, rating2, rating3, rating4, rating5. Returns the new rating ID or false.
     */
    function createRating($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('comment-helpers.php/createRating -> Parameter must be an array.');
        
        $newId = genNewRatingId();
        
        $query = "INSERT INTO `ratings` (`id`, `category1`, `category2`, `category3`, `category4`, `category5`) VALUES (:id, :c1, :c2, :c3, :c4, :c5);";
        $param = array (':id' => $newId, ':c1' => $array['rating1'], ':c2' => $array['rating2'], ':c3' => $array['rating3'], ':c4' => $array['rating4'], ':c5' => $array['rating5']);
        
        $statement = $db->prepare($query);
        $result = $statement->execute($param);
        
        if ($result !== FALSE)
            return $newId;
        else
            return false;
    }
    
    /**
     * Returns a course name given a course ID. Returns null if course ID is not in the table.
     */
    function getCourseName($courseId) {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `courses` WHERE `id` = :id;");
        $statement->execute(array(':id' => trim($courseId)));
        
        if ($course = $statement->fetch()) {
            return $course['coursename'];
        } else {
            return null;
        }
    }
    
    /**
     * Returns the content for when the course isn't found.
     */
    function courseNotFound() {
        $ret = array();
        
        $ret['title'] = 'Course not found - RateMyCourses';
        
        $ret['content']  = '<div id="content">';
        $ret['content'] .= '<h1>Course not found.</h2>';
        $ret['content'] .= '<p><a href="/browsecourses">Click here to return to course page.</a></p>';
        $ret['content'] .= '</div>';
        
        return $ret;
    }
     
    /**
     * Returns the content for the specified course and offset.
     */
    function getCourseContent($courseid, $offset) {
        global $db;
        
        $ret = array();
        
        $query = "SELECT * FROM `courses` WHERE `id` = :id;";
        $statement = $db->prepare($query);
        $statement->execute(array(':id' => $courseid));
        
        if (($course = $statement->fetch()) !== FALSE) {
            $statement = $db->prepare("SELECT * FROM `comments` WHERE `courseid` = :courseid");
            $statement->execute(array(':courseid' => $courseid));
            
            $comments = array();
            
            while ($row = $statement->fetch())
                $comments[] = $row;
            
            $ratings = array(0,0,0,0,0);
            
            //- Convert ratings from ratings table to comments.
            foreach ($comments as $key => $comment) {
                $statement = $db->prepare("SELECT * FROM `ratings` WHERE `id` = :id;");
                $statement->execute(array(':id' => $comment['ratingid']));
                
                $row = $statement->fetch();
                
                //- Set comments ratings
                $comments[$key]['rating1'] = $row['category1'];
                $comments[$key]['rating2'] = $row['category2'];
                $comments[$key]['rating3'] = $row['category3'];
                $comments[$key]['rating4'] = $row['category4'];
                $comments[$key]['rating5'] = $row['category5'];
                
                //- For averages
                $ratings[0] += $row['category1'];
                $ratings[1] += $row['category2'];
                $ratings[2] += $row['category3'];
                $ratings[3] += $row['category4'];
                $ratings[4] += $row['category5'];
            }
            
            //- Calculate averages
            $ratings[0] /= count($comments);
            $ratings[1] /= count($comments);
            $ratings[2] /= count($comments);
            $ratings[3] /= count($comments);
            $ratings[4] /= count($comments);
            
            if (count($comments) == 0) {
                //- Display no posts yet
                $ret['title'] = $course['coursename'] . ' - RateMyCourses';
                
                $ret['content']  = '<div id="content">';
                $ret['content'] .= '<h1>There are no reviews of this course... yet!</h1>';
                $ret['content'] .= '<a href="/createcomment?c=' . $courseid . '" title="Review this course">Review this course</a>';
                $ret['content'] .= '</div>';
            } else {
                $ret['title'] = $course['coursename'] . ' - RateMyCourses';
                
                //- Overview - averages, etc
                $ret['content']  = '<div id="content">';
                $ret['content'] .= '<h1>' . $course['coursename'] . '</h1>';
                $ret['content'] .= '<h2>Overview:</h2>';
                $ret['content'] .= '<h3>Difficulty:</h3><p>' . number_format($ratings[0],1) . ' / 5</p><img src="/resources/images/rating' . round($ratings[0]) . '.jpg" alt="Rating of ' . number_format($ratings[0],1) . '" />';
                $ret['content'] .= '<h3>Workload:</h3><p>' . number_format($ratings[1],1) . ' / 5</p><img src="/resources/images/rating' . round($ratings[1]) . '.jpg" alt="Rating of ' . number_format($ratings[1],1) . '" />';
                $ret['content'] .= '<h3>Attendance:</h3><p>' . number_format($ratings[2],1) . ' / 5</p><img src="/resources/images/rating' . round($ratings[2]) . '.jpg" alt="Rating of ' . number_format($ratings[2],1) . '" />';
                $ret['content'] .= '<h3>Interesting:</h3><p>' . number_format($ratings[3],1) . ' / 5</p><img src="/resources/images/rating' . round($ratings[3]) . '.jpg" alt="Rating of ' . number_format($ratings[3],1) . '" />';
                
                //- Counter for paginating.
                $counter = 0;
                
                //- List all comments.
                foreach ($comments as $comment) {
                    if ($counter >= $offset && $counter < $offset + 25) {
                        $ret['content'] .= '<div class="comment">';
                        $ret['content'] .= '<div class="comment-ratings">';
                        $ret['content'] .= '<h3>Difficulty:</h3><p>' . $comment['rating1'] . ' / 5</p><img src="/resources/images/rating' . $comment['rating1'] . '.jpg" alt="Rating of ' . $comment['rating1'] . '" />';
                        $ret['content'] .= '<h3>Workload:</h3><p>' . $comment['rating2'] . ' / 5</p><img src="/resources/images/rating' . $comment['rating2'] . '.jpg" alt="Rating of ' . $comment['rating2'] . '" />';
                        $ret['content'] .= '<h3>Attendance:</h3><p>' . $comment['rating3'] . ' / 5</p><img src="/resources/images/rating' . $comment['rating3'] . '.jpg" alt="Rating of ' . $comment['rating3'] . '" />';
                        $ret['content'] .= '<h3>Interesting:</h3><p>' . $comment['rating4'] . ' / 5</p><img src="/resources/images/rating' . $comment['rating4'] . '.jpg" alt="Rating of ' . $comment['rating4'] . '" />';
                        $ret['content'] .= '</div>';
                        $ret['content'] .= '<div class="comment-content">';
                        $ret['content'] .= $comment['comment'];
                        $ret['content'] .= '</div>';
                        $ret['content'] .= '</div>';
                    }
                    
                    $counter++;
                }
                
                $ret['content'] .= '</div>';
            }
        } else {
            $ret = courseNotFound();
        }
        
        return $ret;
    }