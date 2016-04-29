<?php session_start();?>
<?php
	//if(isset($_SESSION['logged_user'])){
	//	$logged_user = $_SESSION['logged_user'];
?>


<!DOCTYPE html>
<html>


<head>
	<meta charset="UTF-8">
    <title>album home</title>
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
            <li><a class="current" href="index.php">home</a></li>
            <li><a href="pages/album.php">album</a></li>
            <li><a href="pages/upload.php">upload</a></li>
            <li><a href="pages/edit.php">edit</a></li>

            <?php
				if(isset($_SESSION['logged_user'])){
					$logged_user = $_SESSION['logged_user'];
					echo '<li><a href="login.php?logout=logout">logout</a></li>';
				}else{
					echo '<li><a href="login.php">login</a></li>';
				}
			?>
        </ul>
        </nav>      
    </div>    
    </div>

    <div class="search">
    	<form id="search_photo" method="post">
    
        	Photo's name <br>
        	<input id="describe" type="text" class="column1" name="describe">
      	
      		photos's id<br>
        	<input id="pid" type="text" class="column2" name="pid">
        
        	<button type = "submit" name="search">search</button>

    	</form>
    </div>



	<?php
		$describe = filter_input( INPUT_POST, 'describe', FILTER_SANITIZE_STRING );
		$pid = filter_input( INPUT_POST, 'pid', FILTER_SANITIZE_NUMBER_INT );

		$sql = "SELECT * FROM photo;";
		$images = $mysqli->query($sql);
		$image_num = $images->num_rows;

		echo "<div class='image' id ='image'>";
		echo "<ul>";


		for ($i = 0; $i < $image_num; $i++) {
		
			$image = $images->fetch_assoc();
			$purl = $image['purl'];
			$pname = $image['pname'];
			$id = $image['pid'];
			if(empty($describe) && empty($pid)){
				echo "<li>
				<a href = 'pages/info.php?photo=$id'><img src='image/$purl' alt='$pname'></a>
				<p>Name: $pname</p>
				</li>";
			}elseif(empty($describe)!==false && empty($pid)!==false) {
				if($pid == $id && strpos($pname, $describe) !== false){
					echo "<li>
					<a href = 'pages/info.php?photo=$id'><img src='image/$purl' alt='$pname'></a>
					<p>Name: $pname</p>
					</li>";
				}
			}else{
				if(empty($describe) && $pid == $id){
					echo "<li>
					<a href = 'pages/info.php?photo=$id'><img src='image/$purl' alt='$pname'></a>
					<p>Name: $pname</p>
					</li>";
				}
				if(empty($pid) && strpos($pname, $describe)!==false){
					echo "<li>
					<a href = 'pages/info.php?photo=$id'><img src='image/$purl' alt='$pname'></a>
					<p>Name: $pname</p>
					</li>";
				}
			}
		}
		echo "</ul>";
		echo "</div>";
	?>
    
</body>

<?php 
	//} else {
		// header('Location:login.php');
	//}
?> 
</html>