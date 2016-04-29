
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
            <li><a href="../index.php">HOME</a></li>
            <li><a class="current" href="album.php">album</a></li>
        </ul>
        </nav>      
    </div>    
    </div>

	<?php
		$sql = "SELECT * FROM album;";
		$albums = $mysqli->query($sql);
		
		$album_num = $albums->num_rows;

		echo "<div id = 'album'>";
		for ($i = 0; $i < $album_num; $i++) {
			echo "<tr>";
				$album = $albums->fetch_assoc();
				$name = $album['name'];
				echo "<td>
						<p>Name: $name</p>
					</td>";
			echo "</tr>";
		}
			echo "</div>";
	?>
    
</body>
</html>