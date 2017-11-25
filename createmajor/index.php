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
    <title>Add a Major - RateMyCourses</title>
  </head>
  <body>
    <?php
      if (isset($_GET['e'])) {
          switch ($_GET['e']) {
              case 's':
                  echo '<div class="alert alert-danger">School Name invalid.</div>';
                  break;
              case 'u':
                  echo '<div class="alert alert-danger">University invalid.</div>';
                  break;
              case 'm':
                  echo '<div class="alert alert-danger">Major Code invalid.</div>';
                  break;
              case 'n':
                  echo '<div class="alert alert-danger">Major Name invalid.</div>';
                  break;
          }
      }
    ?>
    <form action="/lib/form-submit-create-major.php" method="POST">
      <label>University Name </label>
      <?php echo getSchoolSelect(); ?>
      <label>Major Name </label>
      <input type="text" name="majorname" placeholder="Major Name" required />
      <label>Major Code </label>
      <input type="text" name="major" placeholder="Major" required />
      <label>School Name </label>
      <input type="text" name="schoolname" placeholder="School Name" required />
      <input type="submit" name="submit" value="Create Major" />
    </form>
    <form action="/lib/form-submit-get-majors.php" method="POST">
      <label>University: </label>
      <?php echo getSchoolSelect(); ?>
      <input type="submit" name="submit" value="Get Majors" />
    </form>
    <?php
      if (isset($_GET['s'])) {
          echo getMajors(trim($_GET['s']));
      }
    ?>
  </body>
</html>