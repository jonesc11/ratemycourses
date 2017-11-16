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
    
    $fname     = trim($_POST['firstname']);
    $lname     = trim($_POST['lastname']);
    $uname     = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $confEmail = trim($_POST['conf_email']);
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
    if (!ctype_alnum($uname) && $continue) {
        $arr = array('error' => 'Username must be alphanumeric.',
                     'email' => $email,
                     'focus' => 'username',
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    //- Check if email is in use or invalid.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $continue) {
        $arr = array('error' => 'Please enter a valid email address.',
                     'username' => $uname,
                     'focus' => 'email',
                     'firstname' => $fname,
                     'lastname' => $lname);
        echo genCreateForm($arr);
        $continue = FALSE;
    }
    
    $statement = $db->prepare('SELECT email,active FROM `users`;');
    $result = $statement->execute();
    
    while ($row = $statement->fetch() && $continue) {
        if (strtolower($row['email']) == strtolower($email) && $row['active'] == 1) {
            $arr = array('error' => 'Email in use, please use a different username.',
                         'username' => $uname,
                         'focus' => 'email',
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
                     'focus' => 'password',
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
                     'focus' => 'password',
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
        if (createNewUser($username, $firstname, $lastname, strtolower($email), $password)) {
            sendCreateSuccessEmail($emailArray)
            echo '<script>window.location = "' . $successPage . '"</script>';
        } else {
            echo '<script>window.location = "' . $successPage . '"</script>';
        }
    }
    
?>