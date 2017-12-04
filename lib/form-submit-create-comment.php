<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    /**
     * This is the form handler for creating a new comment (with ratings). The required post fields are:
     *   - comment
     *   - userid
     *   - courseid
     * For ratings, you can have up to five ratings named in the form of rating{#} (e.g. rating1). Any ratings that
     * are not specified will simply be null, and will not play into any averages.
     */
    
    $courseid = strip_tags($_POST['courseid']);
    $comment  = strip_tags($_POST['comment']);
    $userid   = strip_tags($_POST['userid']);
    $rating1  = null;
    $rating2  = null;
    $rating3  = null;
    $rating4  = null;
    $rating5  = null;
    
    if (isset($_POST['rating1']))
        $rating1 = strip_tags($_POST['rating1']);
    if (isset($_POST['rating2']))
        $rating2 = strip_tags($_POST['rating2']);
    if (isset($_POST['rating3']))
        $rating3 = strip_tags($_POST['rating3']);
    if (isset($_POST['rating4']))
        $rating4 = strip_tags($_POST['rating4']);
    if (isset($_POST['rating5']))
        $rating5 = strip_tags($_POST['rating5']);
    
    $ratingParam = array('rating1' => $rating1, 'rating2' => $rating2, 'rating3' => $rating3, 'rating4' => $rating4, 'rating5' => $rating5, 'userid' => $userid);
    $ratingId = createRating($ratingParam);
    
    $commentParam = array('ratingid' => $ratingId, 'comment' => $comment, 'courseid' => $courseid, 'userid' => $userid);
    $commentId = createComment($commentParam);
    
    header ('Location: /viewcourse?c=' . $courseid);