<!DOCTYPE html>
<?php require_once(__DIR__ . DIRECTORY_SEPARATOR . 'auth-helpers.php'); ?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/lib/navbar.css">
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
        <form class="form-inline nav navbar-nav navbar-right">
          <input id="search" class="form-control" type="text" placeholder="Search">
          <button class="btn" type="submit">Search</button>
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