<?php session_start(); ?>
<!DOCTYPE html>
<html>

<?php
    if (isset( $_SESSION['logged_user'])) {
        //Protected content here
        $logged_user = $_SESSION['logged_user'];
?>
<head>
    <title>album upload</title>
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
            <li><a href="edit.php">edit</a></li>
        <?php
            if(isset($_SESSION['logged_user'])){
                $logged_user = $_SESSION['logged_user'];
                echo '<li><a href="../login.php?logout=logout">logout</a></li>';
            }else{
                echo '<li><a href="../login.php">login</a></li>';
            }
        ?>
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
        echo "<br><ul>";
        for ($i = 0; $i < $album_num; $i++) {
            echo "<li>";
                $album = $albums->fetch_assoc();
                $name = $album['name'];
                $aid = $album['aid'];
                echo " <input type='checkbox' name='album[]' value='". $aid ."'>" .$name . " <br> ";
            echo "</li>";
        }
        echo "</ul>";
    ?>
    <input type="file" accept = "image/*" name='newfile'>
    <input type="submit" name="submit">
    </form>


<?php


    if(isset($_POST['submit'])){
        
        if(!empty($_FILES['newfile']) && !empty($_POST['photo_name']) ){
            $tmp_path = $_FILES["newfile"]["tmp_name"];
            $photo_name = htmlentities($_POST['photo_name']);
            
            $check_sql= "SELECT * FROM photo where pname ='$photo_name';";
            $checks = $mysqli->query($check_sql);
            if($checks->num_rows > 0){
                echo "this photo is already exist";
                die();   
            }

            $url = $photo_name . ".jpg";
            $path = "../image/" . $url;

            // Check to see if no error occurs
            if($_FILES["newfile"]["error"] > 0){
                echo "Return Code: " . $_FILES["newfile"]["error"] . "<br>";
            }
            else{
                // Establish a new connection to the database
                
                move_uploaded_file($tmp_path, $path);
                
                $query = "INSERT INTO photo(pname,purl) VALUES ('" . $photo_name . "','" . $url . "');";

                $mysqli->query($query);
                $pid= $mysqli->insert_id;
                if(isset($_POST['album'])){
                    $albums = $_POST['album'];
                    foreach($albums as $album){
                        $query = "INSERT INTO relation(pid, aid) VALUES ('" . $pid . "','" . $album . "');";
                        $mysqli->query($query);
                    
                    }
                }
                //TODO 3: Close the connection to the MySQL database
                $mysqli->close();
                
            }
        }
    }
?>
    
</body>

<?php 
} else {
    print "<p>Please <a href='../login.php'>login</a></p>";
}
?>
</html>