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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="/resources/viewcourse.css">
  </head>
  <body>
    <?php 
      require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'navbar.php');
    ?>
    <div class="container">
      <div class="output-container">
        <?php echo $output['content']; ?>
      </div>
    </div>
  </body>
</html>