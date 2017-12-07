<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'suggestion-helpers.php');
    
    /**
     * This is the form handler for creating a new school. The required post fields are:
     *   - suggestion
     *   - userid (optional)
     */
    
    $param = array();
    
    //- Set user ID parameters if there is a userid, if there's not, just set it to FFFFFFFF to indicate a generic user
    if (isset($_POST['userid']) && $_POST['userid'] != '')
        $param['userid'] = $_POST['userid'];
    else
        $param['userid'] = 'FFFFFFFF';
    
    //- Cleanse the input for HTML
    $param['suggestion'] = strip_tags($_POST['suggestion']);
    
    //- Create the suggestion and redirect
    $result = createSuggestion($param);
    
    header ("Location: /suggest?s=t");