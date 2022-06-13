<!DOCTYPE HTML>
<?php
	require("Functions.php");
	session_start();
	$SQLcon = new sql();
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
		<!-- Main -->

		<form method="post">
			<div class="main-grid-container">
				<?php
					/* Variables */
					$columnCounter = 1;
					$activeImages = array();
					$activeTable = $SQLcon->readDB("SELECT pk, fileEnding FROM `images` WHERE active = 1 ");
					$allPK = $SQLcon->readDB("SELECT pk FROM `images`");

					/* Schaut für jeden PK ob das Passende Bild deliked wurde */
					while($row = $allPK->fetch_assoc()){

						if(!isset($_SESSION['liked_' . $row['pk']])){
							$_SESSION['liked_' . $row['pk']] = "0";
						}
					}

					/* Erhöt oder senkt anzahl likes */
					if(isset($_POST['like'])){
						if($_SESSION['liked_' . $_POST['like']] == "0" ) {
							$SQLcon->writeDB('UPDATE `images` SET likes = likes + 1 WHERE pk = "' . $_POST['like'] . '"');
							$_SESSION['liked_' . $_POST['like']] = "1";

						}elseif (isset($_POST['like']) && $_SESSION['liked_' . $_POST['like']] == "1" ) {
							$SQLcon->writeDB('UPDATE `images` SET likes = likes - 1 WHERE pk = "' . $_POST['like'] . '"');
							$_SESSION['liked_' . $_POST['like']] = "0";

						}
					}

					/* Zeigt alle Bilder an */
					while ($row = $activeTable->fetch_assoc()) {
						$liked = 0;
						if(isset($_SESSION['liked_' . $row["pk"]]) && $_SESSION['liked_' . $row["pk"]] == 1) {
							$liked = 1;
						}

						echo '
									<div class="grid-detail image" >
										<img src="images/pic' . $row['pk'] . '.' . $row['fileEnding']. '" alt="">
										<button style="background-image: url(assets/images/like_' . $liked . '.png);" class="like_button" name="like" value="' . $row['pk'] . '" onchange="this.form.submit()" />
									</div>';

					}
				?>
			</div>
		</form>
	</body>
</html>