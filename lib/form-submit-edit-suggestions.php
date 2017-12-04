<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'suggestion-helpers.php');
    
    /**
     * This is the form handler for setting a suggestion as inactive or "done". The required post fields are:
     *   - Inactive (button)
     *   - id
     */
    
    
    if (isset($_POST['Inactive']) && isset($_POST['id'])){
        setcompletedSuggestion($_POST['id']);
    }
    header ('Location: ../admin-panel.php');
?>