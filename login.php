<!DOCTYPE html>
<?php
  require("functions.php");
  session_start();
	$SQLcon = new sql();
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login-Seite</title>
		<link rel="stylesheet" href="assets/css/main.css" />
  </head>
  <body>
    <nav>
      <?php displayNav(); ?>
    </nav>
    <?php
    if(isset($_SESSION['username'])){

        /* logged aus */
        if(isset($_POST['deleteSession']) && $_POST['deleteSession'] == "true"){
  				_end();
          header('Location: login.php');
  			}

        /* zeigt logout form an */
  			if(isset($_SESSION['username'])){
  				echo '
  				<form method="post" class="login">
  					<p>Hallo ' . $_SESSION['username'] . ', Willst du jetzt schon gehen?</p>
  					<button type="submit" name="deleteSession" value="true">Logout</button>
  				</form>';
  			}

      }else{

      $postUsername = "";
      $postPassword = "";
      $_POST['register'] = false;

      if(isset($_POST['username'])){
        $postUsername = $_POST['username'];
      }

      if(isset($_POST['password'])){
        $postPassword = $_POST['password'];
      }

      /* Zeigt login Formular an */
      echo'
        <form method="POST" action="edit.php" class="login center">
          <label>Benutzername</label>
          <input type="text" name="username" value="' . $postUsername . '" required/>
          <label>Passwort</label>
          <input type="password" name="password" value="' . $postPassword . '" required/>
          <input type="hidden" name="register" value="false"/>
          <button type="submit" name="senden" class="fill-width">Login</button>
        </form>';
      }
    ?>
  </body>
</html>
