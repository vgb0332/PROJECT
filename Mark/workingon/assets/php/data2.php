<?php

//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);

mysqli_set_charset($conn,"utf8");

$swLat = $_POST['swLat'];
$swLng = $_POST['swLng'];
$neLat = $_POST['neLat'];
$neLng = $_POST['neLng'];

//echo $swLat.' '.$swLng;

$sql = "SELECT Building_PK,lat,lng 
		FROM B_building 
		WHERE lat > '$swLat' and lat < '$neLat' and lng > '$swLng' and lng < '$neLng'";

$result = mysqli_query($conn,$sql);

$row=mysqli_fetch_all($result);
echo json_encode($row);
exit;

?>
