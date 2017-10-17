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
        $query .= "('$id', '$username', '$password', '$salt', '$email', '$firstname', '$lastname');";
        
        try {
            $statement = $db->prepare($query);
            $statement->execute();
        } catch (Exception $e) {
            echo $e;
            return FALSE;
        }
        
        return TRUE;
    }
    
    function getErrorMessage($errorKey) {
    	    
    }
	
	function isLoggedIn(){ //determines whether user is logged in or not
		return isset($_SESSION["user"]) && isValid($_SESSION["user"]["email"], $_SESSION["user"]["password"]);
	}


	//Determines whether or not uname and password combination is correct
	//pulls database values and checks against hashed password

	function isValid($id, $hash_password){
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

	//Logs in the user if uname or password is correct

	function login($id,$password){
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
			
		if(isValid($username,$password) == true){
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
    
?>