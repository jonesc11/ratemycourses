<?php
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'db-connect.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'course-helpers.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'suggestion-helpers.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'auth-helpers.php');
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'comment-helpers.php');


    if (!isset($_SESSION['user']['permissions']) || $_SESSION['user']['permissions'] < 1) {
        header ('Location: /'); 
    }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Admin and Moderator Panel - RateMyCourses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/resources/navbar-ajax.js"></script>
    <link rel="stylesheet" href="/resources/submit-forms.css">
  </head>
  <body>
    <?php require(__DIR__ . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'navbar.php'); ?>
    <div class="container">
    <center>
      <div class="output-container">
        <h1>Welcome to the Admin Page</h1>
        <form class="form" action="/createschool/index.php" method="POST">
          <label>Add/Modify a School </label>
          <input class="btn go" type="submit" name="submit" value="Go" />
        </form>
        <form class="form" action="/createmajor/index.php" method="POST">
          <label>Add/Modify a Major </label>
          <input class="btn go" type="submit" name="submit" value="Go" />
        </form>
        <form class="form" action="/createcourse/index.php" method="POST">
          <label>Add/Modify a Course </label>
          <input class="btn go" type="submit" name="submit" value="Go" />
        </form>
        <?php 
        	if ($_SESSION['user']['permissions'] ==2){
        		echo getUsers();
        	}
        	echo getactiveSuggestions();
        	echo getflaggedComments();
        ?> 
      </div>
      </center>
    </div>
  </body>
</html>