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
        
        $query = "INSERT INTO `ratings` (`id`, `category1`, `category2`, `category3`, `category4`, `category5`, `userid`) VALUES (:id, :c1, :c2, :c3, :c4, :c5, :userid);";
        $param = array (':id' => $newId, ':c1' => $array['rating1'], ':c2' => $array['rating2'], ':c3' => $array['rating3'], ':c4' => $array['rating4'], ':c5' => $array['rating5'], ':userid' => $array['userid']);
        
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
        $ret['content'] .= '<h2>Course not found.</h2>';
        $ret['content'] .= '<p><a href="/index.php">Click here to return to main page.</a></p>';
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
            $total_average = 0;
            
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
            if(count($comments) != 0) {
              $ratings[0] /= count($comments);
              $ratings[1] /= count($comments);
              $ratings[2] /= count($comments);
              $ratings[3] /= count($comments);
              $ratings[4] /= count($comments);
            }
          
            //- Calculate Overall Average for Course
            $temp_sum = 0;
            for($i = 0; $i < 5; $i++) {
              $temp_sum += $ratings[$i];
            }
            $average = $temp_sum / 4;
            
            if (count($comments) == 0) {
                //- Display no posts yet
                $ret['title'] = $course['coursename'] . ' - RateMyCourses';
                
                $ret['content']  = '<div id="content">';
                $ret['content'] .= '<h1>' . $course['major'] . ' ' . $course['coursenum'] . ' - '. $course['coursename'] . '</h1>';
                $ret['content'] .= '<h2>There are no ratings for this course... yet!</h2>';
                $ret['content'] .= '<a class="btn" href="/createcomment?c=' . $courseid . '" title="Rate this course">Rate this course</a><a href="../majors-page.php/?s=' . $course['schoolid'] . '" class="btn return_2">Return to School</a>';
                $ret['content'] .= '</div>';
            } else {
                $ret['title'] = $course['coursename'] . ' - RateMyCourses';
                
                //- Overview - averages, etc
                $ret['content']  = '<div id="content">';
                $ret['content'] .= '<h1><strong>' . $course['major'] . ' ' . $course['coursenum'] . ' -</strong> ' . $course['coursename'] . '<a href="../majors-page.php/?s=' . $course['schoolid'] . '" class="btn return">Return to School</a></h1>';
                $ret['content'] .= '<div class="averages-container"><h2>Overall Average: ' . number_format($average, 2) . '</h2>';
                $ret['content'] .= '<table class="ratings-averages"><th>Easiness:</th><th>Free Time:</th><th>Skippability:</th><th>Interesting:</th>
                <tr><td>' . number_format($ratings[0],1) . ' / 5</td><td>' . number_format($ratings[1],1) . '/ 5</td><td>' . number_format($ratings[2],1) . '/ 5</td><td>' . number_format($ratings[3],1) . '/ 5</td></tr></table>';
                $ret['content'] .= '<div class="rating-image-container"><h3>Your Verdict:</h3><img class="rating-image" src="/resources/images/rating'. round($average) . '.jpg" alt="Rating image"/></div></div>';
//                $ret['content'] .= '<h3>Difficulty:</h3><p>' . number_format($ratings[0],1) . ' / 5</p>';
//                $ret['content'] .= '<h3>Workload:</h3><p>' . number_format($ratings[1],1) . ' / 5</p>';
//                $ret['content'] .= '<h3>Attendance:</h3><p>' . number_format($ratings[2],1) . ' / 5</p>';
//                $ret['content'] .= '<h3>Interesting:</h3><p>' . number_format($ratings[3],1) . ' / 5</p>';
                
                //- Counter for paginating.
                $counter = 0;
                $ret['content'] .= '<div class="comments"><h2>User Ratings:<a class="btn rating-link" href="/createcomment?c=' . $courseid . '" title="Rate this course">Review this course</a></h2><hr>';
                //- List all comments.
                foreach ($comments as $comment) {
                    if ($counter >= $offset && $counter < $offset + 25) {
                        $ret['content'] .= '<div class="comment">';
                        $ret['content'] .= '<em>User Rating</em>'; 
                        $ret['content'] .= '<div class="comment-ratings">';
                        $ret['content'] .= '<table class="ratings-averages"><th>Easiness:</th><th>Free Time:</th><th>Skippability</th><th>Interesting:</th>
                        <tr><td>' . $comment['rating1'] . ' / 5</td><td>' . $comment['rating2'] . '/ 5</td><td>' . $comment['rating3'] . '/ 5</td><td>' . $comment['rating4'] . '/ 5</td></tr></table>';
                        $ret['content'] .= '</div>';
                        $ret['content'] .= '<div class="comment-content"><strong>Comment:</strong> ';
                        if($comment['comment'] == "") {
                          $ret['content'] .= 'none';
                        }
                        else {
                          $ret['content'] .= $comment['comment'];
                        }
                        $ret['content'] .= '<form method="POST" action="/lib/form-submit-flag-comment.php"><input type="submit" class = "btn" name="flag" value="Flag Comment" /><input type="hidden" name="id" value="' . $comment['id'] . '" /><input type="hidden" name="cid" value="' . $comment['courseid'] . '" /></form>';
                        $ret['content'] .= '</div>';
                        $ret['content'] .= '</div><hr>';
                    }
                    
                    $counter++;
                }
                
                $ret['content'] .= '</div><div class="clear"></div></div>';
            }
        } else {
            $ret = courseNotFound();
        }
        
        return $ret;
    }
    //Flags a comment for moderations
    function flagComment($commentid){
        global $db;
        $statement = $db->prepare("UPDATE `comments` SET `flagged`= 1 WHERE `id`=:id;");
        $statement->execute(array(':id'=>$commentid));
    }
    //Unflags a comment
    function unflagComment($commentid){
        global $db;
        $statement = $db->prepare("UPDATE `comments` SET `flagged`= 0 WHERE `id`=:id;");
        $statement->execute(array(':id'=>$commentid));
    }
    //Deletes a comment
    function deleteComment($commentid){
        global $db;
        $statement = $db->prepare("DELETE From `comments` WHERE `id`=:id;");
        $statement->execute(array(':id'=>$commentid));
    }
    //View all the flagged comments
    function getflaggedComments(){
        global $db;
        $statement = $db->prepare("SELECT * from `comments`WHERE `flagged`=1;");
        $statement->execute();
        $ret = '<table> <tr><th><h3> Flagged Comment </h3></th> <th> <h3>Username </h3></th><th><h3>Actions </h3></th></tr>';
        
        while ($flagged = $statement->fetch()) {
            $statement = $db->prepare("SELECT * FROM `users` WHERE `id` = :id");
            $statement->execute(array(':id' => $flagged['userid']));
            
            $user = $statement->fetch();
            
            $ret .= '<tr><td>' . $flagged['comment'] . '</td>';
            $ret .= '<td>' . $user['username'] . '</td>';
            $ret .= '<td><form action="/lib/form-submit-comment-actions.php" method="POST"> <input id = "Reg" type="radio" name="flagged"  value="Delete Comment"> Delete Comment<br> <input id = "Mod"type="radio" name="flagged"  value="Unflag Comment"> Unflag Comment<input type="hidden" name="id" value="' . $flagged['id'] . '" /> <br> <input class = "btn"type="submit" value="Submit"> </form> <br> </form> </td></tr>';
        } 
        $ret .= '</table>';
        
        $ret .= '</div>';
        
        return $ret;
    }