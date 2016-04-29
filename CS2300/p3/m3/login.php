<?php
session_start();
if (isset($_SESSION['logged_user'])) {
	$olduser = $_SESSION['logged_user'];
	header('Location:index.php');
	//unset($_SESSION[ 'logged_user'] );
} else {
	$olduser = false;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title>login</title>
    <?php
    	require_once "config.php";
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		if($mysqli->errno){
			print("error");
			exit();
		}
	?>
</head>

<?php
	if(isset($_GET['logout'])){
		unset($_SESSION['logged_user']);
		unset( $_SESSION );
		$_SESSION = array();
		session_destroy();
	}
?>

<?php
	$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
	$password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
	if (empty($username) || empty($password)) {
		$hash = password_hash( 'tony', PASSWORD_DEFAULT);
?>

<h2>Log in</h2>

<form action="login.php" method="post">

	Username: <input type="text" name="username"> <br>
	Password: <input type="password" name="password"> <br>
	<input type="submit" value="Submit">
</form>

<?php
	} else {
	
		$sql = "SELECT password FROM admin WHERE username = '$username'";
		$users = $mysqli->query($sql);

		if ($users->num_rows == 1) {
			$user = $users->fetch_assoc();
			if(password_verify($password,$user['password'])){
				$_SESSION['logged_user'] = $username;
				echo '<p>cool you have login</p>';
				
				header('Location:index.php');

			}else{
				echo '<p>You did not login successfully.</p>';
				echo '<p>Please <a href="login.php">login</a></p>';	
			}			
		}else{
			echo "<p>You don't register as a member</p>";
			echo '<p>Please <a href="login.php">login</a></p>';
		}
	}
?>

</html>