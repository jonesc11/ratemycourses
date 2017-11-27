<?php
    
    require_once(__DIR__  . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    /**
     * Returns the next hex value for the suggestion IDs.
     */
    function genNewSuggestionId() {
        global $db;
        
        $statement = $db->prepare("SELECT * FROM `suggestions` WHERE 1 = 1;");
        
        if ($statement->execute()) {
            $max = -1;
            
            while ($row = $statement->fetch()) {
                if ($max < hexdec($row['id'])) {
                    $max = hexdec($row['id']);
                }
            }
            
            $max++;
            return dechex($max);
        } else {
            return false;
        }
    }
    
    /**
     * Creates a new suggestion. Returns the ID of the suggestion if it was created, false otherwise
     */
    function createSuggestion($array) {
        global $db;
        
        if (!is_array($array))
            throw new Exception("Input must be an array.");
        
        $sugg = $array['suggestion'];
        $user = $array['userid'];
        $id   = genNewSuggestionId();
        
        $statement = $db->prepare("INSERT INTO `suggestions` (`userid`, `suggestion`, `id`) VALUES (:userid, :suggestion, :id);");
        $result = $statement->execute(array(':userid' => $user, ':suggestion' => $sugg, ':id' => $id));
        
        if ($result !== FALSE) {
            return $id;
        } else {
            return false;
        }
    }