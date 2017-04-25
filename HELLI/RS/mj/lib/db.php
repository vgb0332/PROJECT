<?php


/*
function db_init($host,$duser,$dpw,$dname){
	$conn = mysqli_connect($host,$duser,$dpw);
	if(mysqli_connect_errno($conn)){
	echo "연결 실패 : ".mysqli_connect_error();	
	} else {
	echo "database test 이쁜아름이";	
	}
	
/*	
	//mysqli_select_db($conn,$dname);
	return $conn;
 */

function db_init($host,$duser,$dpw,$dname){
	$conn = mysqli_connect($host,$duser,$dpw);
	mysqli_select_db($conn,$dname);
	return $conn;
}
?>