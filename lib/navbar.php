<!DOCTYPE html>
<?php require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php'); ?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="navbar.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="navbar.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-light">
      <a class="navbar-brand" href="#">RateMyCourses</a>
      
      <div id="navbarNavAltMarkup">
        <div class="navbar-nav" id="menu">
          <a class="nav-item nav-link" href="#">Home</a>
          <a class="nav-item nav-link" href="#">Tips</a>
          <a class="nav-item nav-link" data-toggle="modal" data-target="#login">Login</a>
          <a class="nav-item nav-link hidden" href="#">Logout</a>
          <a class="nav-item nav-link" data-toggle="modal" data-target="#signup">Sign up</a>
        </div>
        <form class="form-inline nav navbar-nav navbar-right navbar-right">
          <input id="search" class="form-control" type="text" placeholder="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </nav>
    
    <div class="modal fade" id="login">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="username" class="form-control-label">Username:</label>
                <input type="text" class="form-control" id="username">
              </div>
              <div class="form-group">
                <label for="password" class="form-control-label">Password:</label>
                <input type="password" class="form-control" id="password">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn">Login</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="modal fade" id="signup">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Sign Up</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="sign_up_form">
              <?php echo genCreateForm(array()); ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn">Sign up</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>