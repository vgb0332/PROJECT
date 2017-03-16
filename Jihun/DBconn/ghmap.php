<?php
//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
?>
<?php
  mysqli_set_charset($conn,"utf8");
  $sql = "SELECT 대지_위치 FROM total_Gangnam";
  $result = mysqli_query($conn,$sql);
  $row=mysqli_fetch_all($result);
  //while($row=mysqli_fetch_all($result))
  //{
    //echo '<li>'.$row[1][7].'</li>'."\n";
  //}
  /*
  for($i =0; $i < mysqli_num_rows($result); $i++){
  	echo $row[$i][7]."<br/>";
  } 
*/
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>주소로 장소 표시하기</title>
    
</head>
<body>
<p style="margin-top:-12px">
    <em class="link">
        <a href="javascript:void(0);" onclick="window.open('http://fiy.daum.net/fiy/map/CsGeneral.daum', '_blank', 'width=981, height=650')">
            혹시 주소 결과가 잘못 나오는 경우에는 여기에 제보해주세요.
        </a>
    </em>
</p>
<div id="map" style="width:100%;height:350px;"></div>

<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=2de7aa60b9771369bceaebe69c906dd2&libraries=services"></script>
<script>

//////////////////////////여기가 너가 바꿔야될부분!)/////////////////////////////////////////
  var numOfRows = <?php echo json_encode(mysqli_num_rows($result), JSON_UNESCAPED_UNICODE); ?>;

  var addrName = [numOfRows+1];
  addrName=<?php echo json_encode($row, JSON_UNESCAPED_UNICODE); ?>;
  
  addrName=JSON.stringify(addrName);

var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = {
        center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };  

// 지도를 생성합니다    
var map = new daum.maps.Map(mapContainer, mapOption); 

// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();

// 주소로 좌표를 검색합니다
geocoder.addr2coord('제주특별자치도 제주시 첨단로 242', function(status, result) {

    // 정상적으로 검색이 완료됐으면 
     if (status === daum.maps.services.Status.OK) {

        var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);

        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new daum.maps.Marker({
            map: map,
            position: coords
        });

        // 인포윈도우로 장소에 대한 설명을 표시합니다
        var infowindow = new daum.maps.InfoWindow({
            content: '<div style="width:150px;text-align:center;padding:6px 0;">우리회사</div>'
        });
        infowindow.open(map, marker);

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
    } 
});    
</script>
</body>
</html>