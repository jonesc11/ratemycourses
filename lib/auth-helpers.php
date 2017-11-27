<?php
    
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    /*
     * Use random number generators to return a salt.
     */
    function salt() {
        return dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    }
    
    /*
     * Return a password hashed with a given salt and password.
     */
    function genHashedPassword($password, $salt) {
        $pw = hash('sha256', $password . $salt);
        
        for ($i = 0; $i < 22341; ++$i)
            $pw = hash('sha256', $pw . $salt);
        
        return $pw;
    }
    
    /*
     * Queries the database and gets the highest ID currently in the database.
     * Returns the next Hex ID.
     */
    function getNextId() {
        global $db;
        global $dbname;
        
        //- Get the IDs (returned in hex)
        $query = "SELECT `id` FROM {$dbname}.`users`;";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        
        $max = -1;
        
        //- Find the highest ID number.
        while ($row = $statement->fetch()) {
            if ($max < $row['id'])
                $max = hexdec($row['id']);
        }
        
        $max++;
        
        //- Return the next hex number.
        return str_pad(dechex($max), 8, '0', STR_PAD_LEFT);
    }
    
    /*
     * Handles the SQL commands to add a user to the database given whatever is submitted to
     * the form. Returns TRUE if successful, FALSE otherwise.
     */
    function createNewUser($username, $firstname, $lastname, $email, $password) {
        global $db;
        global $dbname;
        
        //- Generate the salt and hashed password, get next ID.
        $salt = salt();
        $password = genHashedPassword($password, $salt);
        $id = getNextId($db, $dbname);
        
        //- Construct query
        $query  = "INSERT INTO {$dbname}.`users` ";
        $query .= "(`id`, `username`, `password`, `salt`, `email`, `firstname`, `lastname`) VALUES ";
        $query .= "(:id, :username, :password, :salt, :email, :fname, :lname);";
        
        //- For binding parameters
        $parameters = array ( ':id' => $id,
                              ':username' => $username,
                              ':password' => $password,
                              ':salt' => $salt,
                              ':email' => $email,
                              ':fname' => $firstname,
                              ':lname' => $lastname );
        
        //- Send query
        try {
            $statement = $db->prepare($query);
            $statement->execute($parameters);
        } catch (Exception $e) {
            //- Return false if there was a SQL error.
            return FALSE;
        }
        
        return TRUE;
    }
    
    /*
     * Generates the Create Account form based on input. Allows for certain
     * items to be already filled (in case of resubmission) and creates a
     * Bootstrap alert with any errors (if any errors exist).
     */
    function genCreateForm($array) {
        if (!is_array($array))
            throw new Exception ("Input must be an array.");
        
        //- Create empty variables.
        $error = '';
        $username = '';
        $email = '';
        $firstname = '';
        $lastname = '';
        
        //- Fill the variables if necessary.
        if (isset($array['error']))
            $error = '<div class="alert alert-danger">' . $array['error'] . '</div>';
        
        if (isset($array['username']))
            $username = $array['username'];
        
        if (isset($array['email']))
            $email = $array['email'];
        
        if (isset($array['firstname']))
            $firstname = $array['firstname'];
        
        if (isset($array['lastname']))
            $lastname = $array['lastname'];
        
        //- Populate return variable (HTML form)
        $ret = '';
        if ($error != '') {
            $ret  .= $error;
        }
        $ret .= '<form name="create-account" method="POST">';
        $ret .= '<label for="username" class="form-control-label">Username:</label><input name="username" type="text" value="' . $username . '" class="form-control" required />';
        $ret .= '<label for="firstname" class="form-control-label">First Name:</label><input name="firstname" type="text" value="' . $firstname . '" class="form-control" required />';
        $ret .= '<label for="lastname" class="form-control-label">Last Name:</label><input name="lastname" type="text" value="' . $lastname . '" class="form-control" required />';
        $ret .= '<label for="email" class="form-control-label">Email:</label><input name="email" type="text" value="' . $email . '" class="form-control" required />';
        $ret .= '<label for="conf_email" class="form-control-label">Confirm Email:</label><input name="conf_email" type="text" class="form-control" required />';
        $ret .= '<label for="password" class="form-control-label">Password:</label><input name="password" type="password" class="form-control" required />';
        $ret .= '<label for="conf_password" class="form-control-label">Confirm Password:</label><input name="conf_password" type="password" class="form-control" required" />';
        $ret .= '</form>';
        return $ret;
    }
    
    /*
     * Sends an HTML email confirming that the user created an account.
     * Returns false if email was not successful, true otherwise.
     */
    function sendCreateSuccessEmail($array) {
        if (!is_array($array))
            throw new Exception ("Input must be an array.");
        
        //- Load variables
        $username = $array['username'];
        $email = $array['email'];
        $firstname = $array['firstname'];
        $lastname = $array['lastname'];
        
        //- Create header information
        $mail_subject = 'RateMyCourses Account Successfully Created!';
        
        $mail_headers = 'MIME-Version: 1.0' . "\r\n";
        $mail_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $mail_headers .= 'From: no_reply@ratemycourses.com\r\n' . 'Reply-to: jonesc11@rpi.edu\r\nX-Mailer: PHP/' . phpversion();
        
        //- TO BE FILLED WITH HTML CONTENT
        $mail_message = '';
        
        //- Send email, return appropriately.
        if (mail($email, $mail_subject, $mail_message, $mail_headers))
            return TRUE;
        
        return FALSE;
    }
    
?>