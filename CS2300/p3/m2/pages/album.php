
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>album</title>
    <link rel="stylesheet" href="../css/main.css">
    <?php
    	require_once "../config.php";
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		if($mysqli->errno){
			print("error");
			exit();
		}
	?>
</head>

<body>
	<div class= "upper">
    <div class="container">
        <h2>Albums</h2> 
        <nav>
        <ul>
            <li><a href="../index.php">home</a></li>
            <li><a class="current" href="album.php">album</a></li>
            <li><a href="upload.php">upload</a></li>
        </ul>
        </nav>      
    </div>    
    </div>

    <?php
		if(isset($_POST["create"])){
			$name = filter_input( INPUT_POST,"album",FILTER_SANITIZE_STRING);
			$sql = "SELECT * FROM album;";
			$val = true;
			$albums = $mysqli->query($sql);
			$album_num = $albums->num_rows;
			for ($i = 0; $i < $album_num; $i++) {
				$album = $albums->fetch_assoc();
				if($name === $album['name']){
					echo '<h3>This album has already created</h3>';
					$val = false;
				} 
			}
			if($val === true){
				$sql = 'INSERT INTO album (name) VALUES ("'. $name . '");';
				if($mysqli->query($sql)){
					echo "<h2>the creation is done</h2>";
				}
			}
		}
	?>

	<?php
		$sql = "SELECT * FROM album;";

		$albums = $mysqli->query($sql);
		
		$album_num = $albums->num_rows;

		echo "<div id = 'album'>";
		for ($i = 0; $i < $album_num; $i++) {
			echo "<tr>";
			$album = $albums->fetch_assoc();
			$name = $album['name'];
			$aid = $album['aid'];
			echo "<td><a href = 'album.php?aid=$aid'>Name: $name</a></td>";
			echo "<br>";
			echo "</tr>";

		}
			echo "</div>";
	?>
	<form class = "create" action = "album.php" method="POST">
		album name : <input type = "text" name = "album">
		<input type = "submit" name="create">
	</form>
	


	<?php
		if(isset($_GET['aid'])){
			$aid = filter_input( INPUT_GET, 'aid',FILTER_SANITIZE_NUMBER_INT );

			$sql = "SELECT * FROM photo where pid in (SELECT pid FROM relation where aid = " . $aid .");";

			$images = $mysqli->query($sql);
			$len = 2;
			$image_num = $images->num_rows;
			$row_num = $image_num / $len;

			echo "<div id = 'image'>";
			for ($i = 0; $i <= $row_num; $i++) {
				echo "<tr>";
				for ($j = 0; $j < $len; $j++) {
				
					$image = $images->fetch_assoc();

					if ($i * $len + $j >= $image_num) {
						break;
					}
					$purl = $image['purl'];
					$pname = $image['pname'];
					echo "<td>
						<img src='../image/$purl'>
						<p>Name: $pname</p>
						</td>";
				}
				echo "</tr>";
			}
		}

	?>

    
</body>
</html>