<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    if (isset($_GET['c'])) {
        $coursename = getCourseName($_GET['c']);
    } else {
        $coursename = null;
    }
    
    if ($coursename === null) {
        $title = 'Course not found - RateMyCourses';
    } else {
        $title = $coursename . ' - RateMyCourses';
    }
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $title; ?></title>
  </head>
  <body>
    <?php
      if ($coursename === null) {
          echo '<div id="content">';
          echo '<h1>Course not found.</h1>';
          echo '<a href="/browsecourses" title="Return to browse">Return to browse courses</a>';
          echo '</div></body></html>';
          die();
      }
    ?>
  </body>
</html>