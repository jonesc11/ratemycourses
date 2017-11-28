<?php

    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'comment-helpers.php');
    
    if (!isset($_SESSION['user']) /*|| $_SESSION['user']['active'] != 1*/)
      //  header ("Location: /login");
        $_SESSION['user']['username'] = "collin"; // REMEMBER TO REMOVE THIS
    
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
      if ($coursename === null) {
          echo '<div id="content">';
          echo '<h1>Course not found.</h1>';
          echo '<a href="/browsecourses" title="Return to browse">Return to browse courses</a>';
          echo '</div></body></html>';
          die();
      }
    ?>
    <div class="container">
      <div class="output-container">
        <h2>Add a Rating for <?php echo $coursename; ?></h2>
        <form class="form" action="/lib/form-submit-create-comment.php" method="POST">
          <input type="hidden" name="courseid" value="<?php echo $_GET['c']; ?>" />
          <input type="hidden" name="userid" value="<?php echo $_SESSION['user']['username'] ?>" />
          <table>
            <tr>
              <td>
                <label>Difficulty (1 - easy A, 5 - good luck not dropping):</label>
              </td>
              <td>
                <select class="dropdown" name="rating1">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <label>Workload (1 - little to no homework, 5 - no sleep):</label>
              </td>
              <td>
                <select class="dropdown" name="rating2">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <label>Attendance (1 - unnecessary, 5 - critical):</label>
              </td>
              <td>
                <select class="dropdown" name="rating3">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>
                <label>Interesting (1 - fall asleep, 5 - didn't miss a word):</label>
              </td>
              <td>
                <select class="dropdown" name="rating4">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </td>
            </tr>
          </table>
          <div class="comment-container">
            <label class="comment-label">Enter your comment (optional) : </label><textarea class="comment" name="comment" rows="4" cols="50"></textarea>
          </div>
          <input class="btn left-align" type="submit" value="Submit" name="submit" />
        </form>
      </div>
    </div>
  </body>
</html>