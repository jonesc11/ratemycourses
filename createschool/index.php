<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    if (!isset($_SESSION['user']['permissions']) || $_SESSION['user']['permissions'] < 1) {
        header ('Location: /');
    }
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Add a school - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="../resources/submit-forms.css">
  </head>
  <body>
    <?php require(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'navbar.php'); ?>
    <div class="container">
      <div class="output-container">
        <h2>Create a School</h2>
        <form class="form" action="/lib/form-submit-create-school.php" method="POST">
          <label>School Name: </label><br/>
          <input class="input-field" type="text" name="schoolname" placeholder="School Name" required />
          <input class="btn school-btn" type="submit" name="submit" value="Create School" />
        </form>
        <h2>Existing Schools</h2>
        <?php
          echo getSchools();
        ?>
      </div>
    </div>
  </body>
</html>