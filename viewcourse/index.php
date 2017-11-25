<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    //- In the get request, c is the course ID, and s is the starting point (only show 25 comments per page, so we can start at other offsets).
    
    if (isset($_GET['c'])) {
        if (isset($_GET['s'])) {
            $output = getCourseContent($_GET['c'], $_GET['s']);
        } else {
            $output = getCourseContent($_GET['c'], 0);
        }
    } else {
        $output = courseNotFound();
    }
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo $output['title']; ?></title>
  </head>
  <body>
    <?php echo $output['content']; ?>
  </body>
</html>