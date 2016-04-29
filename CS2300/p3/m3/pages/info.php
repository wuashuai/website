<?php session_start();?>

<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <title>album home</title>
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
            <li><a class="current" href="../index.php">home</a></li>
            <li><a href="album.php">album</a></li>
            <li><a href="upload.php">upload</a></li>
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

    <?php
        if(isset($_GET['photo'])){
            $pid = $_GET['photo'];
            $photo_sql = "SELECT * FROM photo where pid = '$pid';"; 
            $relation_sql = "SELECT * FROM relation where pid = '$pid';";
            
            $photos = $mysqli->query($photo_sql);

            $photo = $photos->fetch_assoc();
            echo "<p> name : " . $photo['pname'] ."<br>
                    rating : " . $photo['rating'] ." <br>
                    time : ". $photo['addtime'] ."<br>";
                
            $relations = $mysqli->query($relation_sql);
            
            
            if($relations->num_rows){
                echo "this photo has been included in album ";   
            
                for($i = 0; $i < $relations->num_rows; $i++){
                    $relation = $relations->fetch_assoc();
                    $aid = $relation['aid'];
                    $album_sql = "SELECT * FROM album where aid = '$aid';";
                    $albums = $mysqli->query($album_sql);
                    $album = $albums->fetch_assoc();

                    echo $album['name'] ."  "; 
                    
                }
            }
            echo "</p>";


            if (isset( $_SESSION['logged_user'])) {
                
    ?>
    
    <h2> edit album</h2>
    <form class = "add_album" method="post">

    <br>
        add photo to: 
        <input type="text" name = "add_album" placeholder="album name"> 
    <input type="submit" name="add"> 
    </form>

    <form class = "delete_album" method="post">
    <br>
        delete photo from : 
        <input type="text" name = "delete_album" placeholder="album name"> 
    <input type="submit" name="delete_album">
    </form>

    <form class = "delete_photo" method="post">
    <br>
        If you want to delete this photo, please click the button : <br>
    <input type="submit" name="delete_photo" value="delete">
    </form>

    <?php            
            }
            if(isset($_POST['delete_photo'])){
                $sql = "DELETE FROM relation WHERE pid = '$pid';";
                $mysqli->query($sql);
                $sql = "DELETE FROM photo WHERE pid = '$pid';";
                $mysqli->query($sql);
                header("Location:../index.php");
            }
            if(isset($_POST['add_album'])){
                $name = filter_input( INPUT_POST, 'add_album',FILTER_SANITIZE_STRING);
                $sql = "SELECT * from album where name = '$name';";

                $albums = $mysqli->query($sql);
                if($albums->num_rows == 0){
                    echo "this is not a reasonable albums";
                    die();
                }
                $album = $albums->fetch_assoc();

                $sql = "SELECT * from relation where aid = '" . $album['aid'] . "'AND pid = '$pid';";
                $relations = $mysqli->query($sql);
                if($relations->num_rows > 0){
                    echo "this is already in albums";
                    die();
                }
                $relation = $relations->fetch_assoc();
                $aid = $album['aid'];
                $sql = "INSERT INTO relation(aid, pid) VALUES ($aid, $pid);";
                echo "$sql";
                $mysqli->query($sql);
            }
            if(isset($_POST['delete_album'])){
                $name = filter_input( INPUT_POST, 'delete_album',FILTER_SANITIZE_STRING);
                
                $sql = "SELECT * from album where name = '$name';";

                $albums = $mysqli->query($sql);
                if($albums->num_rows == 0){
                    echo "this is not a reasonal albums";
                    die();
                }
                $album = $albums->fetch_assoc();

                $sql = "SELECT * from relation where aid = '" . $album['aid'] . "'AND pid = '$pid';";
                $relations = $mysqli->query($sql);
                if($relations->num_rows == 0){
                    echo "this is already in albums";
                    die();
                }
                $relation = $relations->fetch_assoc();
                $aid = $album['aid'];
                $sql = "DELETE FROM relation WHERE aid = '$aid' and pid = '$pid';";
               
                $mysqli->query($sql);
            }

        }
    ?>
</body>
</html>