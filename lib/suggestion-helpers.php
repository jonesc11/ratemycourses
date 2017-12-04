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
    /* Returns all active suggestions */
    function getactiveSuggestions() {
         global $db;
        
        $ret = '<div id="suggestions">';
        
        $statement = $db->prepare("SELECT * FROM `suggestions` Where `status` = 0;");
        $statement->execute();
        
        $ret .= '<table> <tr><th><h3> Active Suggestions </h3></th> <th> <h3>Completed Suggestion? </h3></th></tr>';
        
        
        while ($suggestion = $statement->fetch()) {
            $ret .= '<tr><td>' . $suggestion['suggestion'] . '</td>';
            $ret .= '<td><form action="/lib/form-submit-edit-suggestions.php" method="POST"> <input class="btn" type="submit" name="Inactive"><br><input type="hidden" name="id" value ="'.$suggestion['id'].'" ><br> </form> </td></tr>';

        } 
        $ret .= '</table>';
        
        $ret .= '</div>';
        
        return $ret;
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

    function setcompletedSuggestion($suggestionid){
        global $db;
        $statement = $db->prepare("UPDATE `suggestions` SET `status`= 1 WHERE `id`=:id;");
        $statement->execute(array(':id'=>$suggestionid));
    }