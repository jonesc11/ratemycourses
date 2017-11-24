<!DOCTYPE html>
<?php require_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib/browse-helpers.php'); ?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="resources/course.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/base.css">
  </head>
  <body>
    <?php include('lib/navbar.php'); ?>
    <div class="container">
      <div id ="coursenav" class="initial-view">
		<div class="row">
			<div class="col-sm-12">
              <?php echo getMajorNav(); ?>
			</div>
		</div>
	</div>
    <div id="courseinfo">
      <div id="major_container">  
      </div>
    </div>
    </div>
  </body>
</html>