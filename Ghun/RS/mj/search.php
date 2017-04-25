<!DOCTYPE html>
<html>
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
  	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
<body>
  <p>결과</p>
	<div class="container">
	  <ul class="pagination">
		<li class="active" name="page_num" value= "1"><a href="search.php">1</a></li>
		<li><a href="#">2</a></li> 
		<li><a href="#">3</a></li>
		<li><a href="#">4</a></li>
		<li><a href="#">5</a></li>
	  </ul>
	</div>

  <?php

 	require("config/config.php");
    require("lib/db.php");
	
 
 	$sigun_name = $_POST['sigun'];
	$gu_name = $_POST['gu'];
	$dong_name = $_POST['dong'];
	$page_num = $_POST['page_num'];
  
    echo $sigun_name." ".$gu_name." ".$dong_name."  ".$page_num;
	echo " 의 검색 결과...";
	echo '<br>';
	$search_name = $sigun_name." ".$gu_name." ".$dong_name;
    //mysqli_fetch_fields
   	
    $conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);

    mysqli_set_charset($conn,"utf8");

    $sql = "SELECT *
    		FROM ac
    		WHERE name = '$search_name'";

    $result = mysqli_query($conn,$sql);
    $row=mysqli_fetch_all($result);

	$code = str_split($row[0][0], 5);
	//echo $code[0];
	//echo '<br>';
	//echo $code[1];
	
	$sigun = $code[0];
	$dong = $code[1];

	

    //exit;
 	

    //decode_sigunguCD($sigun, $gu);

    /* PHP 샘플 코드 */
    $ch = curl_init();
    $url = 'http://apis.data.go.kr/1611000/BldRgstService/getBrTitleInfo'; /*URL*/
    $queryParams = '?' . urlencode('ServiceKey') . '=oGtUrVlMjVSHd81jyy%2BVZ1WhUbIlI4ZIJQromneMKUaymmZjRFePLqq0vD7D4gJd43cC%2BFTEoeWTYf9BXTkFtw%3D%3D'; /*Service Key*/
    $queryParams .= '&' . urlencode('sigunguCd') . '=' . urlencode($sigun); /*행정표준코드*/
    $queryParams .= '&' . urlencode('bjdongCd') . '=' . urlencode($dong); /*행정표준코드*/
    $queryParams .= '&' . urlencode('platGbCd') . '=' . urlencode('0'); /*0:대지 1:산 2:블록*/
    $queryParams .= '&' . urlencode('bun') . '=' . urlencode(''); /*번*/
    $queryParams .= '&' . urlencode('ji') . '=' . urlencode(''); /*지*/
    $queryParams .= '&' . urlencode('startDate') . '=' . urlencode(''); /*YYYYMMDD*/
    $queryParams .= '&' . urlencode('endDate') . '=' . urlencode(''); /*YYYYMMDD*/
    $queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('10'); /*페이지당 목록 수*/
    $queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /*페이지번호*/


    curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    $response = curl_exec($ch);

    curl_close($ch);

    /* RESULT */
    $result = json_encode(new SimpleXMLElement($response), JSON_UNESCAPED_UNICODE);
    $decode_result = json_decode($result, true);
    //echo($decode_result["body"]["totalCount"]);
    //echo("</br>");
  //  echo($decode_result["header"]["resultMsg"]);





    ?>

  <script type="text/javascript">
    var result = <?php echo $result; ?>;
    console.log(result);
    document.write("총 결과 수: " + result['body']['totalCount'] + '<br>');
    for(var i = 0; i < 20; i++){
    	document.write("--------------------------------- "+(i+1)+" ----------------------------------<br>");
    	document.write("건물 명: " + result['body']['items']['item'][i]['bldNm'] + '<br>' );
    	document.write("PK: " + result['body']['items']['item'][i]['mgmBldrgstPk'] + '<br>' );
    	document.write("도로명 대지 위치: " + result['body']['items']['item'][i]['newPlatPlc'] + '<br>' );
    	document.write("세대수(세대): " + result['body']['items']['item'][i]['hhldCnt'] + '<br>' );
    	document.write("가구수(가구): " + result['body']['items']['item'][i]['fmlyCnt'] + '<br>' );
    	document.write("높이	: " + result['body']['items']['item'][i]['heit'] + '<br>' );
    	document.write("지붕코드명: " + result['body']['items']['item'][i]['roofCdNm'] + '<br>' );
    	document.write("기타지붕: " + result['body']['items']['item'][i]['etcRoof'] + '<br>' );
    	document.write("지상층수: " + result['body']['items']['item'][i]['grndFlrCnt'] + '<br>' );
    	document.write("지하층수: " + result['body']['items']['item'][i]['ugrndFlrCnt'] + '<br>' );
    	document.write("승용승강기수: " + result['body']['items']['item'][i]['rideUseElvtCnt'] + '<br>' );
    	document.write("부속건축물수: " + result['body']['items']['item'][i]['atchBldCnt'] + '<br>' );
    	document.write("부속건축물면적: " + result['body']['items']['item'][i]['atchBldArea'] + '<br>' );
    	document.write("<br>");
    }
  </script>
</body>
</html>
