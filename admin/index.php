<?php 
session_start();
include('../includes/db_connection.php');
if(!isset($_SESSION['user_id'])){
	header('Location:login.php');
	exit();	
}
//getting record of db
$record_count = $db->query("SELECT * FROM posts");
//number of displayed posts per page
$per_page =2;
//number of pages
$pages = ceil($record_count->num_rows / $per_page);
//get page number
if(isset($_GET['p']) && is_numeric($_GET['p'])){
	$page = $_GET['p'];
}
else {
	$page = 1;
}
if($page<=0)
	$start=0;
else
$start = $page * $per_page - $per_page;
$previous = $page - 1;
$next = $page + 1;

//post count
$post_count = $db->query("SELECT * FROM posts");
//comment count
$comment_count = $db->query("SELECT * FROM comments");

//adding new tag from database
if(isset($_POST['submit'])){
	$newTag = $_POST['newTag'];
	if(!empty($newTag)){
	$sql= "INSERT INTO tag (tag) VALUES('$newTag')";
	$query = $db->query($sql);
	if($query){
	echo "New tag added";	
	}
	else{echo"Error";
	}
	
	}
	else{
	echo'Missing newTag';	
	}
}

//show posts by decreasing order

$query = $db->prepare("SELECT post_id, title, LEFT(post, 100) AS post, tag FROM posts  order by post_id desc limit $start, $per_page");
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
		<div id="mainContent">
			<table>
				<tr>
					<td>Total Blog Post</td>
					<td><?php echo $post_count->num_rows?></td>
				</tr>
				<tr>
					<td>Total Comments</td>
					<td><?php echo $comment_count->num_rows?></td>
				</tr>
			</table>
				<div id="category Form">
					<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
						<label for="tag">Add New Tag</label><input type="text" name="newTag"/>
						<input type="submit" name="submit" value="submit"/>
					</form>
				</div>
					<div id="add-posts">
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
						
						<?php
							if($previous > 0){
								echo "<a href='index.php?p=$previous'>Prev</a>";
							}
							if($page < $pages){
								echo "<a href='index.php?p=$next'>Next</a>";
							}
						?>
				</div>
		</div>
	</div>
</body>
</html>