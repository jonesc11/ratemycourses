<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    
    $query = '';
    
    //- Get the search query
    if (isset($_GET['q']))
        $query = $_GET['q'];
    
    //- Turn it into an array so we can look at the number of word matches
    $queryarr = explode('+', $query);
    
    //- To be stored - All of the school data go to one array, majors to another, and courses to another.
    $schoolResults = array();
    $majorsResults = array();
    $courseResults = array();
    
    //- Search through the schools table
    $statement = $db->prepare("SELECT * FROM `schools`;");
    $statement->execute();
    
    while ($row = $statement->fetch()) {
        foreach ($queryarr as $q) {
            if (strpos(strtoupper($row['id']), strtoupper($q)) !== FALSE)
                $schoolResults[] = $row;
            if (strpos(strtoupper($row['name']), strtoupper($q)) !== FALSE)
                $schoolResults[] = $row;
        }
    }
    
    //- Search through the majors table
    $statement = $db->prepare("SELECT major, school, majors.name AS mname, schools.name AS sname, schoolid FROM `majors`, `schools` WHERE majors.schoolid = schools.id;");
    $statement->execute();
    
    while ($row = $statement->fetch()) {
        foreach ($queryarr as $q) {
            if (strpos(strtoupper($row['major']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
            if (strpos(strtoupper($row['school']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
            if (strpos(strtoupper($row['mname']), strtoupper($q)) !== FALSE)
                $majorsResults[] = $row;
        }
    }
    
    //- Search through the courses table
    $statement = $db->prepare("SELECT courses.id, coursename, coursenum, major, name FROM `courses`, `schools` WHERE courses.schoolid = schools.id;");
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
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="/resources/search.css">
  </head>
  <body>
    
    <?php
      require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'navbar.php');
    ?>
    <div class="container">
      <div class="output-container">
        <h2>Search Results for "<?php echo $query; ?>"</h2>
        <div class="search-results">
          <?php
            //- Display empty results
            if(empty($schoolResults) & empty($majorsResults) & empty($courseResults)) {
              echo '<h3>No results found</h3>';
            }
            
            //- Display school results if any exist
            if(!empty($schoolResults)) {
              echo '<h3>Schools:</h3>';
              $schools = '<ul>';
              foreach($schoolResults as $entry) {
                $schools .= '<li><a class="result" href="../majors-page.php/?s=' . $entry['id'] .'">'. ucwords(strtolower($entry['name'])) . '</a></li>';
              }
              $schools .= '</ul>';
              echo $schools;
            }
            
            //- Display majors results if any exist
            if(!empty($majorsResults)) {
              echo '<h3>Majors:</h3>';
              $majors = '<ul>';
              foreach($majorsResults as $entry) {
                $majors .= '<li><a class="result" href="../majors-page.php/?s=' . $entry['schoolid'] .'">'. $entry['mname'] . ' in ' . $entry['school'] . ' at ' . ucwords(strtolower($entry['sname'])) .'</a></li>';
              }
              $majors .= '</ul>';
              echo $majors;
            }
            
            //- Display course results if any exist
            if(!empty($courseResults)) {
              echo '<h3>Courses:</h3>';
              $courses = '<ul>';
              foreach($courseResults as $entry) {
                $courses .= '<li><a class="result" href="../viewcourse/?c=' . $entry['id'] .'">'. $entry['major'] . ' ' . $entry['coursenum'] . ' - '. $entry['coursename'] . '  at '. ucwords(strtolower($entry['name'])) .'</a></li>';
              }
              $courses .= '</ul>';
              echo $courses;
            }
          ?>
        </div>
        <h3 class="suggest">Don't see what you're looking for? Have any suggestions? <a href="/suggest/index.php">Click here!</a></h3>
      </div>
    </div>
  </body>
</html>