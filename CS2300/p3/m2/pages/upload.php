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
            <li><a href="album.php">album</a></li>
            <li><a class="current" href="upload.php">upload</a></li>
        </ul>
        </nav>      
    </div>    
    </div>


    <form class = "upload" method="post" enctype="multipart/form-data">
    <br>
    photo name : <input type="text", name = "photo_name"> 
    
    <?php
        $sql = "SELECT * FROM album;";
        $albums = $mysqli->query($sql);
        $album_num = $albums->num_rows;

        echo "<h3>please check albums</h3>";
        for ($i = 0; $i < $album_num; $i++) {
            echo "<tr>";
                $album = $albums->fetch_assoc();
                $name = $album['name'];
                $aid = $album['aid'];
                echo " <input type='checkbox' name='album[]' value='". $aid ."'>" .$name . " <br> ";
            echo "</tr>";
        }
    ?>
    <input type="file" accept = "image/*" name='newfile'>
    <input type="submit" name="submit">
    </form>


<?php


    if(isset($_POST['submit'])){
        
        if(!empty($_FILES['newfile']) && !empty($_POST['photo_name']) && !empty($_POST['album'])){
            $tmp_path = $_FILES["newfile"]["tmp_name"];
            $photo_name = htmlentities($_POST['photo_name']);
            $url = $photo_name . ".jpg";
            $path = "../image/" . $url;
            $albums = $_POST['album'];

            

            // Check to see if no error occurs
            if($_FILES["newfile"]["error"] > 0){
                echo "Return Code: " . $_FILES["newfile"]["error"] . "<br>";
            }
            else{
                // Establish a new connection to the database
                
                move_uploaded_file($tmp_path, $path);
                
                $query = "INSERT INTO photo(pname, purl) VALUES ('" . $photo_name . "','" . $url . "');";
                $mysqli->query($query);
                $pid= $mysqli->insert_id;

                foreach($albums as $album){
                    $query = "INSERT INTO relation(pid, aid) VALUES ('" . $pid . "','" . $album . "');";
                    $mysqli->query($query);
                    
                }
                
                //TODO 3: Close the connection to the MySQL database
                $mysqli->close();
                
            }
        }
    }
?>
    
</body>
</html>