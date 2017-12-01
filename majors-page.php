<!DOCTYPE html>
<?php require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib/browse-helpers.php'); ?>
<html>
  <head>
    <title>Majors - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <script type="text/javascript" src="/resources/course.js"></script>
    <link rel="stylesheet" type="text/css" href="/resources/base.css">
  </head>
  <body>
    <?php 
      include('/resources/navbar.php');
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
    <div class="container">
        <?php 
          if (isset($_GET['s'])) {
              echo getMajorNav(trim($_GET['s']));
          } 
        ?>
      <input type="hidden" name="schoolid" value="<?php echo $_GET['s']; ?>" />
      <div id="courseinfo">
        <div id="major_container"> 
          <input type="hidden" name="schoolid" value="<?php echo $_GET['s']; ?>" />
        </div>
      </div>
    </div>
  </body>
</html>