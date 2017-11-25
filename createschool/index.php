<?php
    
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'course-helpers.php');
    
    /*if (!isset($_SESSION['user']['permissions']) || $_SESSION['user']['permissions'] < 1) {
        header ('Location: /accesserror');
    }*/
    
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Add a school - RateMyCourses</title>
  </head>
  <body>
    <form action="/lib/form-submit-create-school.php" method="POST">
      <label>School Name</label>
      <input type="text" name="schoolname" placeholder="School Name" required />
      <input type="submit" name="submit" value="Create School" />
    </form>
    <?php
      echo getSchools();
    ?>
  </body>
</html>