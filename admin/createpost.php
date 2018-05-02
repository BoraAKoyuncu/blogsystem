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

//checking validation to inputs
$check='F';
	if(isset($_POST['submit'])){
	$post_date= date("Y.m.d");
	echo $post_date;
	echo $id;
	$title = $_POST['title'];
	$post = $_POST['post'];
	$tag = $_POST['tag'];
	
	if( $title && $post&& $tag){
		$title = $db->real_escape_string($title);
		$post = $db->real_escape_string($post);
		$tag = $db->real_escape_string($tag);
		$check='T';
		
		}																								
		else{
			echo "ERROR";
			$check='F';
			}
			
			//insert into database
				if($check==='T'&& $addPost = $db->prepare("INSERT INTO posts (user_id, title, post, post_date, tag) VALUES (?,?,?,?,?)")){ ;
				$addPost->bind_param('sssss',  $id, $title, $post, $post_date, $tag);
				$addPost->execute();
				$sql= "INSERT INTO tag (tag) VALUES('$tag')";
				$query = $db->query($sql);
				echo $id." ".$post_date;
				echo "Thank you,your post was added";
				$addPost->close();	
	}
		else{
		$check='F';
			}
						
		}

	?>
				

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta http-equiv = "X-UA-Compatible" content="IE=9" />
<script src="http://code.jquery.com/jquery-1.5.min.js"></script>
<style type="text/css">
#container{
	width:800px;
	padding:5px;
	margin:auto;
}
label{
	display:block;
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
		<form action='' method='post'>

		
	<p><label>Title</label><br />
		<input type='text' name='title' value='<?php if(isset($error)){ echo $_POST['title'];}?>'></p>

		<p><label>Post</label><br />
		<textarea name='post' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['post'];}?></textarea></p>
		
		<p><label>Tag</label><br />
		<input type='text' name='tag' value='<?php if(isset($error)){ echo $_POST['tag'];}?>'></p>

		<p><input type='submit' name='submit' value='Submit'></p>
		</form>
	</div>
</body>
</html>
