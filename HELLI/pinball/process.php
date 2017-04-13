<?php
	require("config/config.php");
	require("lib/db.php");
	$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
	$sql = "INSERT INTO blog_topic (title,author,descr,category,img,create_time) VALUES('".$_POST['title']."', '".$_POST['author']."', '".$_POST['description']."', '".$_POST['category']."', '".$_POST['img']."', now())";
	$result = mysqli_query($conn, $sql);

	//header('Location: http://localhost/GRAIZ/HELLI/pinball/index.html');
?>
