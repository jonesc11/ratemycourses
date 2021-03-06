<?php
    
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    
    /*
     * The idea with this is to use AJAX to handle the form. This script will correctly
     * redirect if the form is successful, otherwise the form will empty the form of any
     * invalid information and passwords and refresh itself, and give an error.
     */
     
    //- Get theh data
    $fname     = trim(strip_tags($_POST['firstname']));
    $lname     = trim(strip_tags($_POST['lastname']));
    $uname     = trim(strip_tags($_POST['username']));
    $email     = trim(strip_tags($_POST['email']));
    $confEmail = trim(strip_tags($_POST['conf_email']));
    $password  = $_POST['password'];
    $confPass  = $_POST['conf_password'];
    
    /* 
     * $successPage is the page that we will redirect to if the creation was successful.
     * We will only redirect to $failurePage if there was an error inserting into the
     * database.
     * $continue just prevents ugly nested if statements.
     */
    $successPage = '/';
    $continue    = TRUE;
    
    //- Check if username is in use or invalid.
    if (!ctype_alnum($uname) && $continue) {
        $arr = array('error' => 'Username must be alphanumeric.',
                     'email' => $email,
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    //- For checking usernames
    $statement = $db->prepare("SELECT * FROM `users`");
    $statement->execute();
    
    while (($row = $statement->fetch()) && $continue) {
        if (strtolower($row['username']) == strtolower($uname)) {
            $arr = array('error' => 'Username in use, please use a different username.',
                         'email' => $email,
                         'firstname' => $fname,
                         'lastname' => $lname);
            echo genCreateForm($arr);
            $continue = FALSE;
        }
    }
    
    //- Check if email is in use or invalid.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $continue) {
        $arr = array('error' => 'Please enter a valid email address.',
                     'username' => $uname,
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    //- For checking emails
    $statement = $db->prepare('SELECT * FROM `users`;');
    $result = $statement->execute();
    
    while (($row = $statement->fetch()) && $continue) {
        if (strtolower($row['email']) == strtolower($email)) {
            $arr = array('error' => 'Email in use, please use a different email.',
                         'username' => $uname,
                         'firstname' => $fname,
                         'lastname' => $lname);
            echo genCreateForm($arr);
            $continue = FALSE;
        }
    }
    
    //- Check if email matches conf_email.
    if (strtolower($email) != strtolower($confEmail) && $continue) {
        $arr = array('error' => 'Emails do not match, please try again.',
                     'username' => $uname,
                     'focus' => 'email',
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    //- Check to see if password is powerful enough.
    if (!(preg_match('~[A-Z]~', $_POST['password']) && 
          preg_match('~[a-z]~', $_POST['password']) &&
          preg_match('~[0-9]~', $_POST['password'])
          ) && $continue) {
        $arr = array('error' => 'Password must contain at least 1 uppercase character, lowercase character, and number.',
                     'username' => $uname,
                     'firstname' => $fname,
                     'lastname' => $lname,
                     'email' => $email);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    //- Check to see if password matches conf_password.
    if ($password != $confPass && $continue) {
        $arr = array('error' => 'Passwords do not match.',
                     'username' => $uname,
                     'email' => $email,
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    $emailArray = array('username' => $uname,
                        'email' => $email,
                        'firstname' => $fname,
                        'lastname' => $lname);
    
    //- Submit the form (using function in auth-helpers.php) and redirect.
    if ($continue) {
        if (createNewUser($uname, $fname, $lname, strtolower($email), $password)) {
            echo '<script>window.location = "' . $successPage . '"</script>';
        } else {
            echo '<script>window.location = "' . $successPage . '"</script>';
        }
    }
    
?>