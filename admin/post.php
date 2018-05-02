<?php
session_start();
if(!isset($_GET['id'])){
	header('Location: index.php');
	exit();
}
else{
	$id = $_GET['id'];
}
include('../includes/db_connection.php');
//checks id is number of not
if(!is_numeric($id)){
	header('Location: index.php');
}

$sql = "SELECT title, post FROM posts WHERE post_id = '$id'";
$query = $db->query($sql);

if($query->num_rows !=1){
	header('Location: index.php');
	exit();
}

//checking  validation to inputs

$checks='F';

	if(isset($_POST['submit'])){
	$email = $_POST['email'];
	$name = $_POST['name'];
	$comment = $_POST['comment'];
			
	if($email && $name && $comment){
		$email = $db->real_escape_string($email);
		$name = $db->real_escape_string($name);
		$id = $db->real_escape_string($id);
		$comment = $db->real_escape_string($comment);
		$checks ='T';
		}																								
		else{
			echo "ERROR";
			$checks='F'; 
			}
				//insert into database
			if($checks==='T' && $addComment = $db->prepare("INSERT INTO comments(post_id, email_addr, name, comment) VALUES (?,?,?,?)")){
			$addComment->bind_param('ssss',  $id, $email, $name, $comment);
			$addComment->execute();
			echo "Thank you comment was added";
			$addComment->close();
		
		}
	
		else{
		$checks='F';
			}		
}

    if(isset($_POST['delete'])){  
       $query = "DELETE FROM posts WHERE post_id=$id"; 
       $query = $db->query($sql);
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
		
		
	<div id="post">
	<?php
	$row = $query->fetch_object();
	echo "<h2>".$row->title."</h1>";
	echo "<p>".$row->post."</p>";
	?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<input type="submit" name="delete" value="Delete!"/>
	</form>
	</div>
	<hr />
	<div id="add-comments">
	
	
		<form action="<?php echo $_SERVER['PHP_SELF']."?id=$id"?>" method="post">
			
	<div id="Comments">
	<?php
	$query = $db->query("SELECT * FROM comments WHERE post_id='$id'ORDER BY comment_id DESC");
	?>
	<div>
	<h4><?php echo "All Comments:";?></h4>
	</div>
	
	<?php
	while($row = $query->fetch_object()):
	?>
	<div>
		<h5><?php echo $row->name?></h5>
		<blockquote><?php echo $row->comment?></blockquote>
	</div>
	<?php endwhile?>
</div>
<hr />

			<div>
				<h4><?php echo "Add comment";?></h4>
			</div>
			<div>
				<label>Email Adress</label><input type="text" name="email" />
			</div>
			<div>
				<label>Name</label><input type="text" name="name" />
			</div>
			<div>
				<label>Comment</label><textarea name="comment"></textarea>
			</div>
			<input type="submit" name="submit" value="Submit" />
		</form>
	</div>

				


