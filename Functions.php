<?php

  class sql{
    // Everything DB related
    function readDB($sql) {
      $connection = mysqli_connect("localhost","root","","fotoblock");

      if($connection){
        $result = mysqli_query($connection, $sql);
        $connection->close();
      }
      return $result;
    }

    function writeDB($sql) {
      $connection = mysqli_connect("localhost","root","","fotoblock");

      if($connection){
        $connection->query($sql);
        $connection->close();
      }
    }

    function getIdWriteDB($sql) {
      $connection = mysqli_connect("localhost","root","","fotoblock");
      $last_id = "";

      if($connection){
        $connection->query($sql);
        $last_id = mysqli_insert_id($connection);
        $connection->close();
      }
      return $last_id;
    }
  }


  // Hash : CRYPT_BLOWFISH
  function validateLogin($username, $password) {
    if($username != "" && $password != ""){
      $connection = mysqli_connect("localhost","root","","fotoblock");

      if($connection){
        $passwordHash = mysqli_query($connection, 'SELECT PASSWORD FROM `login` WHERE username = "'.$username.'"');
        $connection->close();

        if ($row = $passwordHash->fetch_assoc()) {

          if(password_verify($password,$row['PASSWORD'])){
            return "true";
          }
        }
      }
    }
    return "false";
  }

  // register
  function registerUser($username, $password) {
    console_log("registering");
    if($username != "" && $password != ""){
      $connection = mysqli_connect("localhost","root","","fotoblock");

      if($connection){
        if($username != mysqli_query($connection, 'SELECT SINGLE username FROM `login` WHERE username = "'.$username.'"')){
          if(strlen($password) > 3){

            $passwordHash = password_hash( $password, PASSWORD_BCRYPT);
            mysqli_query($connection, "INSERT INTO `login` (`pk`, `username`, `password`) VALUES
            (null, '$username', '$passwordHash')");
            $connection->close();
            return "true";

          } else{
            alert('Das Passwort muss mindestens 4 Zeichen lang sein.');
            $connection->close();
          
          }

        } else{
          alert('Dieser Benutzername ist leider schon vergeben.');
          $connection->close();
        
        }
      }
    }
    return "false";
  }


  /* GET / POST / SESSION  */

  function _end() {
    session_unset();
    $_POST = array();
    $_SESSION = array();
  }

  /* HTML shortcuts */

  function displayNav() {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    $listItem = "";

    if(isset($_SESSION['username'])) {
      $listItem = '<li><a href="edit.php">Bearbeiten</a></li>
                   <li><a href="upload.php">Hochladen</a></li>
                   <li><a href="login.php">Logout</a></li>';
    }else {
      $listItem = '<li><a href="login.php">Login</a></li>
                   <li><a href="register.php">Registrieren</a></li>';
    }

    echo'
    <ul class="hidden">
      <li><a href="index.php">Home</a></li>
      <li><a href="most_liked.php">Am populärsten</a></li>
      ' . $listItem . '
    </ul>';
  }

  /* PHP Functions */
  function dir_is_empty($dir) {
    $handle = opendir($dir);
    while (false !== ($entry = readdir($handle))) {

      if ($entry != "." && $entry != "..") {
        closedir($handle);
        return false;
      }
    }
    closedir($handle);
    return true;
  }

  function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
    ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
  }

  function alert($output) {
    echo "<script type='text/javascript'>alert('$output');</script>";
  }
?>
