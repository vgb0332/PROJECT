<?php

//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);

mysqli_set_charset($conn,"utf8");
$addr = $_POST['Addr'];
//echo $addr;

//echo "123";

//$addr = "'".$addr."'";

//$sql = "SELECT * FROM GN_SS where 도로명_대지_위치 = $addr";
//$sql = "SELECT * FROM GN_SS";
$sql = "SELECT * FROM GN_SS WHERE 대지_위치  LIKE '%$addr%'";
  //echo $sql;
  //exit;
$result = mysqli_query($conn,$sql);
//echo $result;

$row=mysqli_fetch_all($result);
echo json_encode($row);
exit;

echo json_encode($row);
  //while($row=mysqli_fetch_all($result1))
  //{
    //echo '<li>'.$row[1][7].'</li>'."\n";
  //}
  /*
  for($i =0; $i < mysqli_num_rows($result1); $i++){
  	echo $row[$i][7]."<br/>";
  }
*/
?>
