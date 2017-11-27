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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="../lib/submit-forms.css">
  </head>
  <body>
    <?php
      include('../lib/navbar.php');
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
    <div class="container">
      <div class="output-container">
        <h2>Create a Major</h2>
        <form class="form" action="/lib/form-submit-create-major.php" method="POST">
          <table class ="create-major">
            <tr>
              <td>
                <label>University Name: </label>
              </td>
              <td>
                <?php echo getSchoolSelect(); ?>
              </td>
            </tr>
            <tr>
              <td>
                <label>Major Name: </label>
              </td>
              <td>
                <input class="input-field" type="text" name="majorname" placeholder="Major Name" required />
              </td>
            </tr>
            <tr>
              <td>
                <label>Major Code: </label>
              </td>
              <td>
                <input class="input-field" type="text" name="major" placeholder="Major" required />
              </td>
            </tr>
            <tr>
              <td>
                <label>School Name: </label>
              </td>
              <td>
                <input class="input-field" type="text" name="schoolname" placeholder="School Name" required />
              </td>
            </tr>
            <tr>
              <td>
                <input class="btn" type="submit" name="submit" value="Create Major" />
              </td>
            </tr>
          </table>
        </form>
        <h2>View Existing Majors</h2>
        <form class="form" action="/lib/form-submit-get-majors.php" method="POST">
          <label>University: </label>
          <?php echo getSchoolSelect(); ?>
          <input class="btn" type="submit" name="submit" value="Get Majors" />
        </form>
        <?php
          if (isset($_GET['s'])) {
              echo getMajors(trim($_GET['s']));
          }
        ?>
      </div>
    </div>
  </body>
</html>