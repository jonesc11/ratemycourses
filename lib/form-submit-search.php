<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    //- Go the search page based on what's in the search box - If nothing's in the search box, /search will display an error.
    if (isset($_POST['submit-search']) && isset($_POST['search-text']) && $_POST['search-text'] != '') {
        header ("Location: /search?q=" . str_replace(' ', '+', $_POST['search-text']));
    } else {
        header ("Location: /search");
    }