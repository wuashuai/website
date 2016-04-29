<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>employee home</title>
    <link rel="stylesheet" href="css/main.css">
    <?php
    	require_once "config.php";
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
            <li><a class="current" href="index.php">HOME</a></li>
            <li><a href="pages/album.php">album</a></li>
        </ul>
        </nav>      
    </div>    
    </div>

	<?php
		$sql = "SELECT * FROM photo;";
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
						<img src='image/$purl'>
						<p>Name: $pname</p>
					</td>";
			}
			echo "</tr>";
		}
			echo "</div>";
	?>
    
</body>
</html>