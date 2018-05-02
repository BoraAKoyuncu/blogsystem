<?php

session_start();
include('../includes/db_connection.php');
if(!isset($_SESSION['user_id'])){
	header('Location:login.php');
	exit();	
}
else{
	$id = $_SESSION['user_id'];
}



$query = $db->prepare("SELECT post_id, title, LEFT(post, 100) AS post, tag FROM posts WHERE posts.user_id=$id order by post_id desc");

$query->execute();
$query->bind_result($post_id, $title, $post, $tag);


?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv = "X-UA-Compatible" content="IE=9" />
<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
<style>
body{
	
}
#container{
	padding:10px;
	width:800px;
	margin: auto;
	background:white;
}
#menu{
	height: 40px;
	line-height: 40px;
}
#menu ul{
	margin:0;
	padding:0;
}
#menu ul li{
	display:inline;
	list-style:none;
	margin-right:10px;
	font-size:18px;
}
#mainContent{
	clear:both;
	margin-top:5px;
	font-size:25px;
}
#header{
	height:80px;
	line-height:80px;
}
#container #header h1{
	font-size: 45px;
	margin:0;
}
</style>
</head>
<body>
<div id="container">
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="createpost.php">Create New Post</a></li>
				<li><a href="yourposts.php">Your Posts</a></li>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
		
				<div id="container">
					<?php
						while($query->fetch()):
						$lastspace = strrpos($post, ' ');
					?>
					<hr />
					<article>
						<h2><?php echo $title?></h2>
						<p><?php echo substr($post, 0, $lastspace)."<a href='post.php?id=$post_id'>..</a>"?></p>
						<p>Tag: <?php echo $tag?>	
					</article>					
						<?php endwhile?>
						

				</div>
		
		
		
</div>
</body>
</html>