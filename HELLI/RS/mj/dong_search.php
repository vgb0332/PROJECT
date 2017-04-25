<?php
//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);

mysqli_set_charset($conn,"utf8");

$selected_sigun = $_POST['Selected'];

//echo $selected_sigun;
$sql = "SELECT  DISTINCT SUBSTRING_INDEX(name, ' ', 3)
    		FROM ac
    		WHERE name like '$selected_sigun%'";

$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_all($result);

echo json_encode($row);

?>
