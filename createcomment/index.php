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
    <form action="/lib/form-submit-create-comment.php" method="POST">
      <input type="hidden" name="courseid" value="<?php echo $_GET['c']; ?>" />
      <input type="hidden" name="userid" value="<?php echo $_SESSION['user']['username'] ?>" />
      <label>Enter your comment here</label><textarea name="comment" rows="4" cols="50"></textarea>
      <label>Difficulty (1 - easy A, 5 - good luck not dropping)</label>
      <select name="rating1">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <label>Workload (1 - little to no homework, 5 - no sleep)</label>
      <select name="rating2">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <label>Attendance (1 - unnecessary, 5 - critical)</label>
      <select name="rating3">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <label>Interesting (1 - fall asleep, 5 - didn't miss a word)</label>
      <select name="rating4">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
      </select>
      <input type="submit" value="Submit" name="submit" />
    </form>
  </body>
</html>