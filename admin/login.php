<?php
session_start();
include('../includes/db_connection.php');

 if (isset($_POST['submit'])){

	$user = $_POST['username'];
	$pass = $_POST['pass'];
	
	//include('../include/db_connection.php');
	if(empty($user)) {
		echo 'Can not blank user name';
	
	}else{
		$user= strip_tags($user);
		$user =$db->real_escape_string($user);
		$pass= strip_tags($pass);
		$pass = $db->real_escape_string($pass);
		$query = $db-> query("SELECT user_id, username FROM user WHERE username='$user' AND password='$pass'");
		if($query->num_rows===1){
			echo 'Log in successful!';
			while($row = $query->fetch_object()){
				$_SESSION['user_id'] = $row->user_id;
				
			}//session_destroy();
			
				header("Location:index.php");
				exit();
	    }
	else{
		echo'Missing information';
	}
	}
	
 }
 ?>
 <!DOCTYPE html>
 <html lang="en">
	<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
	</head>
	<body>
	
	<div id="container">
		<form action ="login.php" method="post">
			<p>
			<label>UserName</label><input type="text" name="username" />
			</p>
			<p>
			<label>Password</label><input type="password" name="pass" />
			</p>
			<input type="submit" name="submit" value="LogIn" />
		</form>
	</div>
	</body>
</html>