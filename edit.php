<!DOCTYPE HTML>
<?php
	require("Functions.php");
	session_start();
	$SQLcon = new sql();

	/* Überprüft login */
	if(isset($_POST['username']) && isset($_POST['password']) && $_POST['register'] == "false"
		&& validateLogin($_POST['username'], $_POST['password']) == "true"){
			$_SESSION['username'] = $_POST['username'];
			$_POST['username'] = "";
			$_POST['password'] = "";
			file_put_contents('log.txt', 'User '.$_SESSION['username'].' logged in at '.date("h:i:sa").'.'.PHP_EOL , FILE_APPEND | LOCK_EX);
	} else{
		console_log("Fail Login");
	}

	/* Überprüft registrierung */
	if(isset($_POST['username']) && isset($_POST['password']) && $_POST['register'] == "true"
		&& registerUser($_POST['username'], $_POST['password']) == "true"){
			$_SESSION['username'] = $_POST['username'];
			$_POST['username'] = "";
			$_POST['password'] = "";
			file_put_contents('log.txt', 'User '.$_SESSION['username'].' registered at '.date("h:i:sa").'.'.PHP_EOL , FILE_APPEND | LOCK_EX);
	} else{
		console_log("Fail Register");
	}

	/* Weist nicht eingeloggte user ab */
	if(!isset($_SESSION['username'])){
		header('Location: login.php');
		die();
	}
?>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<nav>
			<?php
				displayNav();
			?>
		</nav>
		<p class="tipp"><span style="color:#2EBA2B">active</span> <span style="color:grey">inactive</span></p>
		<form method="post">
			<div id="main" class="edit-grid-container">
				<?php
				  /* Variablen */
					$allPK = $SQLcon->readDB("SELECT pk, fileEnding FROM `images`");
					$updateActive = $SQLcon->readDB("SELECT pk, active FROM `images`");
					$activeTable = $SQLcon->readDB("SELECT pk, fileEnding, active FROM `images`");

					/* löscht ausgewählte Bilder */
					while ($row = $allPK->fetch_assoc()) {
						if(isset($_POST['delete_' . $row['pk']]) && $_POST['delete_' . $row['pk']] == "delete") {
							$SQLcon->writeDB('DELETE FROM `images` WHERE pk = "' . $row['pk'] . '"');
							unlink('images/pic' . $row['pk'] . '.' . $row['fileEnding']);
						}
					}

					/* ändert ob Bidler aktiv sind */
					while ($row = $updateActive->fetch_assoc()) {
						if(isset($_POST['active_pic' . $row['pk']]) && !($_POST['active_pic' . $row['pk']] == $row['active'])) {
							$SQLcon->writeDB('UPDATE `images` SET `active` = '. $_POST['active_pic' . $row['pk']] .' WHERE `images`.`pk` = ' . $row['pk']);
						}
					}


					/* Zeigt Bilder an */
					while ($row = $activeTable->fetch_assoc()) {
						$class = "";
						$ischecked = "";

						if($row['active'] == 0){
							$class = ' class="inactive"';
						}

						if($row['active'] == 1){
						 	$ischecked = "checked";
					 	}

						echo '<div class="grid-detail image">
										<img src="images/pic' . $row['pk'] . '.' . $row['fileEnding'] . '"' . $class . ' alt="">
										<input type="hidden" name="active_pic'. $row['pk'] . '" value="0" />
										<input class="invisilbe_checkbox" type="checkbox" name="active_pic'. $row['pk'] . '" value="1" ' . $ischecked . '/>
										<button class="delete_button" type="submit"name="delete_' . $row['pk'] . '" value="delete">löschen<button>
									</div>';
					}
				?>

				<button class="save_Button_8" type="submit" name="commit" value="true">Speichern</button>
			</div>
		</form>
	</body>
</html>
