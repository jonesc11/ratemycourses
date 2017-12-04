<!DOCTYPE html>
<?php require_once(__DIR__ . DIRECTORY_SEPARATOR . '../lib/auth-helpers.php'); ?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="/resources/navbar.css">
  </head>
  <body>
    <div class="nav-container">
      <nav class="navbar navbar-light">
        <a class="navbar-brand" href="/">RateMyCourses</a>

        <div id="navbarNavAltMarkup">
          <div class="navbar-nav" id="menu">
            <a class="nav-item nav-link" href="/">Home</a>
            <?php
              if (isset($_SESSION['user'])) {
                echo '<a class="nav-item nav-link" href="/lib/logout.php">Logout</a>';

                if (isset($_SESSION['user']['permissions']) && $_SESSION['user']['permissions'] >=1){
                  echo '<a class="nav-item nav-link" href="/admin-panel.php"> Admin Panel </a>';
                }
              } else {
                echo '<a class="nav-item nav-link" data-toggle="modal" data-target="#login">Login</a>';
                echo '<a class="nav-item nav-link" data-toggle="modal" data-target="#signup">Sign up</a>';
              }
            ?>
          </div>
          <form class="form-inline nav navbar-nav navbar-right" method="POST" action="/lib/form-submit-search.php">
            <input id="search" class="form-control" type="text" placeholder="Search" name="search-text" />
            <button class="btn" type="submit" name="submit-search">Search</button>
          </form>
        </div>
      </nav>
    </div>
    
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
            <div id="login_form">
              <?php echo genLoginForm(array()); ?>
            </div>
          </div>
          <div class="modal-footer">
            <p class="redirect-text">Don't have an account? <a class="redirect">Sign up now!</a></p>
            <button type="button" class="btn" id="login-submit">Login</button>
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
            <p class="redirect-text">Already have an account? <a class="redirect">Log in now!</a></p>
            <button type="button" class="btn" id="sign-up">Sign up</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      $(document).ready(function() {
        $(".redirect").on('click', function() {
          $("#login").modal('toggle');
          $("#signup").modal('toggle');
        });
      });
    </script>
  </body>
</html>