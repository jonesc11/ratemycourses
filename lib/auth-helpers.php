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
    function getNextId($db, $dbname) {
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
    function createNewUser($username, $firstname, $lastname, $email, $password, $db, $dbname) {
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
        $focus = '';
        
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
        
        if (isset($array['focus']))
            $focus = $array['focus'];
        
        //- Populate return variable (HTML form)
        if ($error != '') {
            $ret  = $error;
            $ret .= '<form name="create-account" method="POST">';
            $ret .= '<input name="username" type="text" value="' . $username . '" placeholder="Username" required/>';
            $ret .= '<input name="firstname" type="text" value="' . $firstname . '" placeholder="First Name" required/>';
            $ret .= '<input name="lastname" type="text" value="' . $lastname . '" placeholder="Last Name" required/>';
            $ret .= '<input name="email" type="text" value="' . $email . '" placeholder="Email" required/>';
            $ret .= '<input name="conf_email" type="text" placeholder="Confirm Email" required/>';
            $ret .= '<input name="password" type="password" placeholder="Password" required/>';
            $ret .= '<input name="conf_password" type="password" placeholder="Confirm Password required"/>';
            $ret .= '<input type="hidden" name="focus" value="' . $focus . '"/>';
            $ret .= '</form>';
            $ret .= '<button class="btn btn-primary" id="submit-create">Submit</button>';
        } else {
            $ret  = '<form name="create-account" method="POST">';
            $ret .= '<input name="username" type="text" value="' . $username . '" placeholder="Username" required/>';
            $ret .= '<input name="firstname" type="text" value="' . $firstname . '" placeholder="First Name" required/>';
            $ret .= '<input name="lastname" type="text" value="' . $lastname . '" placeholder="Last Name" required/>';
            $ret .= '<input name="email" type="text" value="' . $email . '" placeholder="Email" required/>';
            $ret .= '<input name="conf_email" type="text" placeholder="Confirm Email" required/>';
            $ret .= '<input name="password" type="password" placeholder="Password" required/>';
            $ret .= '<input name="conf_password" type="password" placeholder="Confirm Password" required/>';
            $ret .= '<input type="hidden" name="focus" value="' . $focus . '"/>';
            $ret .= '</form>';
            $ret .= '<button class="btn btn-primary" id="submit-create">Submit</button>';
        }
        
        return $ret;
    }
    
    
    
?>