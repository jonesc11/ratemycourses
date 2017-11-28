<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'course-helpers.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Welcome - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="/resources/welcome.css">
  </head>
  <body>
    <?php include('lib/navbar.php'); ?>
    <div class="container">
      <div class="output-container">
        <h1>Welcome to Rate My Courses!</h1>
        <h3>Select your school to view its courses and their ratings.</h3>
        <form class="form" action="/lib/form-submit-redirect-major.php" method="POST">
          <label>Select a School: </label>
          <?php echo getSchoolSelect(); ?>
          <input class="btn" type="submit" name="submit" value="Go" />
        </form>
        <h3>Don't see your school listed? Have any suggestions? <a href="/suggest/index.php">Click here!</a></h3>
      </div>
    </div>
  </body>
</html>