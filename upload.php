<!DOCTYPE HTML>
<?php
  require('Functions.php');
  session_start();
	$SQLcon = new sql();

  /* Logged user ein */
  if(isset($_POST['username']) && isset($_POST['password'])
  	   && validateLogin($_POST['username'], $_POST['password']) == "true"){
			$_SESSION['username'] = $_POST['username'];
			$_POST['username'] = "";
			$_POST['password'] = "";
	}

  /* Weist nicht eingeloggte user ab */
	if(!isset($_SESSION['username'])){
		header('Location: login.php');
		die();
	}

?>
<html>
  <head>
    <link rel="stylesheet" href="assets/css/main.css" />
  </head>
  <body>
    <nav>
      <?php displayNav(); ?>
    </nav>
    <?php
        $tmpDir = "images Backup/";
        $Dir = "images/";
        $allowTypes = array('jpg','png','jpeg','gif');

        /* falls keine bilder im Freigebeorder sind */
        if(dir_is_empty('images Backup/')){

          echo '
          <form action="" method="post" enctype="multipart/form-data" class="login">
            <p>Bitte Dateien auswählen</p>
            <div class="overlay_button">
              <input class="UploadImage" type="file" name="files[]" multiple>
              <button>Durchsuchen</button>
            </div>

            <input type="submit" name="submit" value="Hochladen" class="fill-width">

            <ul class="message_Board">';


          if(isset($_POST['submit']) && !empty($_FILES['files'])) {

            $TmpID = 1;

            if(!empty(array_filter($_FILES['files']['name']))) {

              foreach($_FILES['files']['name'] as $key=>$val){

                $targetFilePath = $tmpDir . basename($_FILES['files']['name'][$key]);
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                $hash = hash_file('md5', $_FILES['files']['tmp_name'][$key]);
                $uploadOk = true;

                /* Is Image */
                if(!in_array($fileType, $allowTypes)){
                  echo "<li>Datei ist kein Bild!</li>";
                  $uploadOk = false;
                }

                /* doesn't exist already */
                if(mysqli_num_rows($SQLcon->readDB('SELECT pk FROM `images` WHERE hash = "' . $hash . '"')) > 0){
                  echo "<li>Bild existiert schon!</li>";
                  $uploadOk = false;
                }

                /* File size small enought */
                if ($_FILES["files"]["size"][$key] > 256000000) {
                  echo "<li>Bild ist zu gross!</li>";
                  $uploadOk = false;
                }

                if($uploadOk == true){

                  if(move_uploaded_file($_FILES['files']['tmp_name'][$key], $tmpDir . 'pic' . $TmpID . '.' . $fileType)){
                    $TmpID++;
                    echo "<li>Upload erfolgreich</li>";
                    header('location: upload.php');
                  }else {
                    echo "<li>Ein fehler ist aufgetreten!</li>";
                    //writeDB('DELETE FROM `images` WHERE `images`.`pk` = "' . $ID . '"');
                  }
                }
              }
            } else{
              echo "<li>keine Datei ausgewählt!</li>";
            }
          }
          echo '
          </ul>
        </form>';
        }else {
          /* Falls Bilder Hochladen wurden, aber nicht freigegeben werden */

          if(!isset($_POST['commit'])){

            echo '
            <form method="post">
              <dir class="upload-grid-container">';
            foreach (scandir('images Backup') as $file) {

              if($file !== '.' && $file !== '..' ){
                $fileWOExtention = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);

                echo '
                <div class="grid-detail image">
                  <img src="' . $tmpDir . $file . '" alt="">
                  <input type="hidden" name="active_' . $fileWOExtention . '" value="0" />
                  <input class="invisilbe_checkbox" type="checkbox" name="active_' . $fileWOExtention . '" value="1"/>
                </div>';
              }
            }
            echo '
                <button class="save_Button_7" type="submit" name="commit" value="true">Speichern</button>
              </div>
            </form>';
          }else {

            /* Zeigt alle nicht freigegeben dateien an */
            foreach (scandir('images Backup') as $file) {

              if($file !== '.' && $file !== '..' ){
                $hash = hash_file('md5', 'images Backup/' . $file);
                $fileWOExtention = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
                $extiention = pathinfo($file, PATHINFO_EXTENSION);
                $active = 0;

                if(isset($_POST['active_' . $fileWOExtention]) && $_POST['active_' . $fileWOExtention] == "1"){
                  $active = 1;
                }

                $ID = $SQLcon->getIdWriteDB('INSERT INTO `images` (`fileEnding`, `likes`, `active`, `hash`) VALUES ( "' . $extiention . '" , "0", "' . $active . '", "' . $hash . '" )');
                rename('images Backup/' . $file, 'images/pic' . $ID . '.' . $extiention);
                header('location: edit.php');
              }
            }
          }
        }
       ?>
  </body>
</html>
