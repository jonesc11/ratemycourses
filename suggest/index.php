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
    <title>Make a Suggestion - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../lib/submit-forms.css">
  </head>
  <body>
    <?php
      include('../lib/navbar.php');
      if (isset($_GET['s']) && $_GET['s'] == 't')
          echo '<div class="alert alert-success">Suggestion successfully created.</div>';
    ?>
    <div class="container">
      <div class="output-container">
        <h2>Make a Suggestion</h2>
        <form class="form" action="/lib/form-submit-suggestions.php" method="POST">
        <?php
            if (isset($_SESSION['user']['username']))
                echo '<input type="hidden" name="userid" value="' . $_SESSION['user']['username'] . '" />';
        ?>
          <table class ="create-major">
            <tr>
              <td>
                <label>Enter your Suggestion: </label>
              </td>
              <td>
                <textarea name="suggestion" rows="4" cols="50" required></textarea>
              </td>
            </tr>
            <tr>
              <td>
                <input class="btn" type="submit" name="submit" value="Submit" />
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </body>
</html>