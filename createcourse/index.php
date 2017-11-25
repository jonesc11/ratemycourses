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
    <title>Add a Course - RateMyCourses</title>
  </head>
  <body>
    <?php
      if (isset($_GET['e'])) {
          switch ($_GET['e']) {
              case 's':
                  echo '<div class="alert alert-danger">School invalid.</div>';
                  break;
              case 'c':
                  echo '<div class="alert alert-danger">Course name invalid.</div>';
                  break;
              case 'm':
                  echo '<div class="alert alert-danger">Major invalid or does not exist.</div>';
                  break;
              case 'n': 
                  echo '<div class="alert alert-danger">Course number invalid or already exists.</div>';
                  break;
          }
      }
    ?>
    <form action="/lib/form-submit-create-course.php" method="POST">
      <label>School Name </label>
      <?php echo getSchoolSelect(); ?>
      <label>Course Name </label>
      <input type="text" name="coursename" placeholder="Course Name" required />
      <label>Major Code </label>
      <input type="text" name="major" placeholder="Major" required />
      <label>Course Number </label>
      <input type="text" name="coursenum" placeholder="Course Number" required />
      <input type="submit" name="submit" value="Create Course" />
    </form>
    <?php
      echo getCourses();
    ?>
  </body>
</html>