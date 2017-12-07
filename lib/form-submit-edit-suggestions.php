<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'suggestion-helpers.php');
    
    /**
     * This is the form handler for setting a suggestion as inactive or "done". The required post fields are:
     *   - Inactive (button)
     *   - id
     */
    
    //- Set the suggestion to inactive so that it doesn't show up
    if (isset($_POST['Inactive']) && isset($_POST['id']) && $_SESSION['user']['permissions'] >= 1){
        setcompletedSuggestion($_POST['id']);
    }
    
    header ('Location: ../admin-panel.php');
?>