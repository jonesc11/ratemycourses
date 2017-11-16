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
     * Takes in an array that must have values courseid, comment, and ratingid. Returns the new comment ID or false.
     */
    function createComment($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception('comment-helpers.php/createComment -> Parameter must be an array.');
        
        $newId = genNewCommentId();
        
        $query = "INSERT INTO `comments` (`id`, `courseid`, `comment`, `ratingid`) VALUES (:id, :courseid, :comment, :ratingid);";
        $param = array (':id' => $newId, ':courseid' => $array['courseid'], ':comment' => $array['comment'], ':ratingid' => $array['ratingid']);
        
        $statement = $db->prepare($statement);
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
        
        $statement = $db->prepare($statement);
        $result = $statement->execute($param);
        
        if ($result !== FALSE)
            return $newId;
        else
            return false;
    }