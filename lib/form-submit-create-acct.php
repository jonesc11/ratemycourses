<?php
    
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /*
     * The idea with this is to use AJAX to handle the form. This script will correctly
     * redirect if the form is successful, otherwise the form will empty the form of any
     * invalid information and passwords and refresh itself, and give an error.
     * 
     * NOT IMPLEMENTED: Function to generate the form and any errors associated with it.
     *                  Errors will use Bootstrap alerts.
     */
    
    $fname     = $_POST['firstname'];
    $lname     = $_POST['lastname'];
    $uname     = $_POST['username'];
    $email     = $_POST['email'];
    $confEmail = $_POST['conf_email'];
    $password  = $_POST['password'];
    $confPass  = $_POST['conf_password'];
    
    /* 
     * $successPage is the page that we will redirect to if the creation was successful.
     * We will only redirect to $failurePage if there was an error inserting into the
     * database.
     * $continue just prevents ugly nested if statements.
     */
    $successPage = '';
    $failurePage = '';
    $continue    = TRUE;
    
    //- Check if username is in use or invalid.
    
    
    //- Check if email is in use or invalid.
    
    
    //- Check if email matches conf_email.
    
    
    //- Check to see if password is powerful enough.
    
    
    //- Check to see if password matches conf_password.
    
    
    //- Submit the form (using function in auth-helpers.php) and redirect.
    if ($continue) {
        if (createNewUser($username, $firstname, $lastname, strtolower($email), $password, $db, $dbname))
            header ('Location: ' . $successPage);
        else
            header ('Location: ' . $failurePage);
    }
    
?>