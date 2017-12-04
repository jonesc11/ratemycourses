<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    $query = '';
    
    if (isset($_GET['q']))
        $query = $_GET['q'];
    
    $queryarr = explode('+', $query);
    
    $schoolResults = array();
    $majorsResults = array();
    $courseResults = array();
    
    $statement = $db->prepare("SELECT * FROM `schools`;");
    $statement->execute();
    
    while ($row = $statement->fetch()) {
        foreach ($queryarr as $q) {
            if (strpos(strtoupper($row['name']), strtoupper($q)) !== FALSE)
                $schoolResults[] = $row;
        }
    }
    
    $statement = $db->prepare("SELECT * FROM `majors`;");
    $statement->execute();
    
    while ($row = $statement->fetch()) {
        foreach ($queryarr as $q) {
            if (strpos(strtoupper($row['major']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
            if (strpos(strtoupper($row['school']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
            if (strpos(strtoupper($row['name']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
        }
    }
    
    $statement = $db->prepare("SELECT * FROM `courses`;");
    $statement->execute();
    
    while ($row = $statement->fetch()) {
        foreach ($queryarr as $q) {
            if (strpos(strtoupper($row['coursename']), strtoupper($q)) !== FALSE)
                $courseResults[] = $row;
            if (strpos(strtoupper($row['coursenum']), strtoupper($q)) !== FALSE)
                $courseResults[] = $row;
            if (strpos(strtoupper($row['major']), strtoupper($q)) !== FALSE)
                $courseResults[] = $row;
        }
    }
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Search Results - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php print_r($courseResults); ?>
  </body>
</html>