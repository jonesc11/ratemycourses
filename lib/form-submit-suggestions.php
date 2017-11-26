<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'suggestion-helpers.php');
    
    /**
     * This is the form handler for creating a new school. The required post fields are:
     *   - suggestion
     *   - userid (optional)
     */
    
    $param = array();
    
    if (isset($_POST['userid']) && $_POST['userid'] != '')
        $param['userid'] = $_POST['userid'];
    else
        $param['userid'] = 'FFFFFFFF';
    
    $param['suggestion'] = $_POST['suggestion'];
    
    $result = createSuggestion($param);
    
    header ("Location: /suggest?s=t");