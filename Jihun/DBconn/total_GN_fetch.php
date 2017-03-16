<?php
//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
?>



<html>
<body>
	<ol>
	<?php
		mysqli_set_charset($conn,"utf8");
		$addr="'서울특별시 강남구 개포동 173번지'";
		$sql = "SELECT * FROM total_Gangnam where 대지_위치 = ".$addr;
		$result = mysqli_query($conn,$sql);
		$row=mysqli_fetch_array($result);
		while($field=mysqli_fetch_field($result))//$row=mysqli_fetch_array($result))
		{
			echo '<li>'.$field->name.'</li>'."\n";
			echo $row[$field->name]."\n";
		}
		
	?>
	</ol>
	
</body>
</html>




