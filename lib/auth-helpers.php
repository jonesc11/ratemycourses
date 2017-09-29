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
    
?>