<?php session_start(); ?>
<!DOCTYPE html>
<html>

<?php
    if (isset( $_SESSION['logged_user'])) {
        //Protected content here
        $logged_user = $_SESSION['logged_user'];
?>
<head>
    <meta charset="UTF-8">
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
            <li><a href="upload.php">upload</a></li>
            <li><a class="current" href="edit.php">edit</a></li>
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


    <form class = "delete_album" method="post">
    <br>
        delete album : 

   <?php
        $sql = "SELECT * FROM album;";
        $albums = $mysqli->query($sql);
        $album_num = $albums->num_rows;
        for ($i = 0; $i < $album_num; $i++) {
            echo "<ul>";
            $album = $albums->fetch_assoc();
            $name = $album['name'];
            $aid = $album['aid'];
            echo "<li><input type='radio' name='albums' value='$aid'> $name </li>";
            echo "<br>";
            echo "</ul>";
        }
    ?>
    
    <input type="submit" name="delete_album">
    </form>
    
    <?php
        if(isset($_POST['albums'])){
            $aid = filter_input( INPUT_POST,'albums',FILTER_SANITIZE_NUMBER_INT );
            $sql = "DELETE FROM relation where aid = '$aid';";
            $mysqli->query($sql);

            $sql = "DELETE FROM album where aid = '$aid';";
            $mysqli->query($sql);
        }

    ?>

</body>
<?php 
} else {
    print "<p>Please <a href='../login.php'>login</a></p>";
}
?>
</html>