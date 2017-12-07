<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . "db-connect.php");
    
    //- Unset session and redirect
    if (isset($_SESSION['user']))
      unset($_SESSION['user']);
    
    header("Location: /");
    
?>