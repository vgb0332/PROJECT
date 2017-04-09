<?php
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);



  mysqli_set_charset($conn,"utf8");
  $sql1 = "SELECT * FROM samsung";
  $result1 = mysqli_query($conn,$sql1);
  $row1=mysqli_fetch_all($result1);
  //echo $row1[1][5];
  for($i = 0; $i < mysqli_num_rows($result1); $i++){
  echo $row1[$i][5];
  }
  
  /*
  while($row=mysqli_fetch_all($result1))
  {
    echo $row[1][5];
  }
   */ 
  /*
  for($i =0; $i < mysqli_num_rows($result1); $i++){
  	echo $row[$i][7]."<br/>";
  } 
*/
?>