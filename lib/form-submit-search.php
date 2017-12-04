<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    if (isset($_POST['submit-search']) && isset($_POST['search-text']) && $_POST['search-text'] != '') {
        header ("Location: /search?q=" . str_replace(' ', '+', $_POST['search-text']));
    } else {
        header ("Location: /search");
    }