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
        global $db, $dbname;
        
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
	
	function isLoggedIn(){ //determines whether user is logged in or not
		return isset($_SESSION["user"]) && isValid($_SESSION["user"]["email"], $_SESSION["user"]["password"]);
	}


	//Determines whether or not uname and password combination is correct
	//pulls database values and checks against hashed password

	function isValid($id, $hash_password){
        global $db;
        
		$isEmail = false;
		
		if(strpos($id,'@') !== false){
			$isEmail = true;
		}
		
		$query = "SELECT * FROM `users`;";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        
        while ($row = $statement->fetch()) {
            if ($isEmail == true){
				if(strtolower($id) == strtolower($row["email"])){
					return $hash_password == $row["password"];
				}
			}
			else{
				if(strtolower($id) == strtolower($row["username"])){
					return $hash_password == $row["password"];
				}
			}
        }
		
		return false;
	}

	function genLoginForm($array) {
       if (!is_array($array))
            throw new Exception ("Input must be an array.");
        
        //- Create empty variables.
        $error = '';
        $username = '';
    
        //- Fill the variables if necessary.
        if (isset($array['error']))
            $error = '<div class="alert alert-danger">' . $array['error'] . '</div>';
        
        if (isset($array['username']))
            $username = $array['username'];
        
        //- Populate return variable (HTML form)
		$ret  = $error;
		$ret .= '<form name="login">';
        $ret .= '<div class="form-group">';
        $ret .= '<label for="username" class="form-control-label">Username or Email Address:</label>';
		$ret .= '<input name="username" type="text" value="' . $username . '" placeholder="Username or Email Address" class="form-control" />';
        $ret .= '</div><div class="form-group">';
        $ret .= '<label for="password" class="form-control-label">Password</label>';
		$ret .= '<input name="password" type="password" placeholder="Password" class="form-control" />';
        $ret .= '</div></form>';

        return $ret;
    }

	//Logs in the user if uname or password is correct

	function login($id, $password){
        global $db;
		$isEmail = false;
		
		if(strpos($id,'@') !== false){
			$isEmail = true;
		}
		
		$query = "SELECT * FROM `users`;";
        $statement = $db->prepare($query);
        $result = $statement->execute();
        
        while ($row = $statement->fetch()) {
            if ($isEmail == true){
				if(strtolower($id) == strtolower($row["email"])){
					$salt = $row["salt"];
					break;
				}
			}
			else{
				if(strtolower($id) == strtolower($row["username"])){
					$salt = $row["salt"];
					break;
				}
			}
        }
		if (!isset($salt)){
			return false;
		}
		
		
		
		$password = genHashedPassword($password,$salt);
			
		if(isValid($id,$password) == true){
			$_SESSION["user"]["id"] = $row["id"];
			$_SESSION["user"]["firstname"] = $row["firstname"];
			$_SESSION["user"]["lastname"] = $row["lastname"];
			$_SESSION["user"]["password"] = $row["password"];
			$_SESSION["user"]["username"] = $row["username"];
			$_SESSION["user"]["email"] = $row["email"];
			$_SESSION["user"]["permissions"] = $row["permissions"];
			return true;
		}
		return false;
	}
	
	//logs user out
	function logout(){
		if(isset($_SESSION["user"])){
			unset($_SESSION["user"]);
		}
	}
    /*
     * Generates the Create Account form based on input. Allows for certain
     * items to be already filled (in case of resubmission) and creates a
     * Bootstrap alert with any errors (if any errors exist).
     */
    function genCreateForm($array) {
        global $db;
        global $dbname;
        
        if (!is_array($array))
            throw new Exception ("Input must be an array.");
        
        //- Create empty variables.
        $error = '';
        $username = '';
    
        //- Fill the variables if necessary.
        if (isset($array['error']))
            $error = '<div class="alert alert-danger">' . $array['error'] . '</div>';
        
        if (isset($array['username']))
            $username = $array['username'];
        $email = '';
        $firstname = '';
        $lastname = '';
      
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
    
?>