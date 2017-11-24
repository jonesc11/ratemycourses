
<?php
  require_once (__DIR__ . DIRECTORY_SEPARATOR . 'browse-helpers.php');

  if(isset($_POST['major'])) {
    $major = $_POST['major'];
    return getNavPerMajor($major); 
  }

?>