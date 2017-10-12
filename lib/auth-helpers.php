<?php
    
    require_once (__DIR__ . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    function salt() {
        return dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
    }
    
    function genHashedPassword($password, $salt) {
        $pw = hash('sha256', $password . $salt);
        
        for ($i = 0; $i < 22341; ++$i)
            $pw = hash('sha256', $pw . $salt);
        
        return $pw;
    }
    
    function getNextId($db, $dbname) {
        $query = "SELECT `id` FROM {$dbname}.`users`;";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        
        $max = -1;
        
        while ($row = $statement->fetch()) {
            if ($max < $row['id'])
                $max = hexdec($row['id']);
        }
        
        $max++;
        
        return str_pad(dechex($max), 8, '0', STR_PAD_LEFT);
    }
    
    function createNewUser($username, $firstname, $lastname, $email, $password, $db, $dbname) {
        $salt = salt();
        $password = genHashedPassword($password, $salt);
        $id = getNextId($db, $dbname);
        
        $query  = "INSERT INTO {$dbname}.`users` ";
        $query .= "(`id`, `username`, `password`, `salt`, `email`, `firstname`, `lastname`) VALUES ";
        $query .= "(:id, :username, :password, :salt, :email, :fname, :lname);";
        
        $parameters = array ( ':id' => $id,
                              ':username' => $username,
                              ':password' => $password,
                              ':salt' => $salt,
                              ':email' => $email,
                              ':fname' => $firstname,
                              ':lname' => $lastname );
        
        try {
            $statement = $db->prepare($query);
            $statement->execute($parameters);
        } catch (Exception $e) {
            echo $e;
            return FALSE;
        }
        
        return TRUE;
    }
    
    function getErrorMessage($errorKey) {
        
    }
    
    function genCreateForm($array) {
        if (!is_array($array))
            throw new Exception ("Input must be an array.");
        
        $error = '';
        $username = '';
        $email = '';
        $firstname = '';
        $lastname = '';
        $focus = '';
        
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
            $ret .= '<form name="create-account" method="POST">';
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