
<?php
  require_once (__DIR__ . DIRECTORY_SEPARATOR . 'browse-helpers.php');
  
  //- Get just courses for the major
  if(isset($_POST['major'])) {
    $major = $_POST['major'];
    return getNavPerMajor($major); 
  }

?>