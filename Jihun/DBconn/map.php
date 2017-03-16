<?php
//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
?>
<?php
  mysqli_set_charset($conn,"utf8");
  $sql = "SELECT * FROM total_Gangnam";
  $result = mysqli_query($conn,$sql);
  $row=mysqli_fetch_all($result);
  //while($row=mysqli_fetch_all($result))
  //{
    //echo '<li>'.$row[1][7].'</li>'."\n";
  //}

?>-->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>건축물 대장 주소로 장소 표시하기</title>
    <style media="screen">
    .map_wrap, .map_wrap * {margin:0;padding:0;font-family:'Malgun Gothic',dotum,'돋움',sans-serif;font-size:12px;}
    .map_wrap a, .map_wrap a:hover, .map_wrap a:active{color:#000;text-decoration: none;}
    .map_wrap {position:relative;width:100%;height:500px;}
    #menu_wrap {position:absolute;top:0;left:0;bottom:0;width:250px;margin:10px 0 30px 10px;padding:5px;overflow-y:auto;background:rgba(255, 255, 255, 0.7);z-index: 1;font-size:12px;border-radius: 10px;}
    .bg_white {background:#fff;}
    #menu_wrap hr {display: block; height: 1px;border: 0; border-top: 2px solid #5F5F5F;margin:3px 0;}
    #menu_wrap .option{text-align: center;}
    #menu_wrap .option p {margin:10px 0;}
    #menu_wrap .option button {margin-left:5px;}
    #pagination{margin-left:30px;margin-top:10px;padding:0;font-family:'Malgun Gothic',dotum,'돋움',sans-serif;font-size:12px;}
    </style>

</head>
<body>
  <div class="map_wrap">
      <div id="map" style="width:100%;height:100%;position:relative;overflow:hidden;"></div>

      <div id="menu_wrap" class="bg_white">
        <p></p>
          <div class="option">
              <div>
                <p>건물 주소</p>
              </div>
          </div>
          <hr>
          <ul id="placesList"></ul>
          <div id="pagination">
			<ul>
			<?php
				mysqli_set_charset($conn,"utf8");
				$addr="'서울특별시 강남구 개포동 173번지'";
				$sql = "SELECT * FROM total_Gangnam where 대지_위치 = ".$addr;
				$result = mysqli_query($conn,$sql);
				$row=mysqli_fetch_array($result);
				while($field=mysqli_fetch_field($result))//$row=mysqli_fetch_array($result))
				{
					echo '<li>'.$field->name."<br />".$row[$field->name].'</li>'."\n";
					//echo $row[$field->name]."\n";
				}
				
			?>
			</ul>
          </div>
      </div>
  </div>


<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=2de7aa60b9771369bceaebe69c906dd2"></script>
<script>
  var mapContainer = document.getElementById('map'), // 지도를 표시할 div
      mapOption = {
          center: new daum.maps.LatLng(37.5173319259, 127.0473774084), // 지도의 중심좌표
          level: 3 // 지도의 확대 레벨
      };

  // 지도를 생성합니다
  var map = new daum.maps.Map(mapContainer, mapOption);
  // 주소-좌표 변환 객체를 생성합니다
  var geocoder = new daum.maps.services.Geocoder();
  // 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
  var zoomControl = new daum.maps.ZoomControl();
  map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);
  // 결과값으로 받은 위치를 마커로 표시합니다
  var marker  = new daum.maps.Marker({
      //map: map,
      //position: coords
  });;

  // 지도가 확대 또는 축소되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
  daum.maps.event.addListener(map, 'zoom_changed', function() {
      // 지도의 현재 레벨을 얻어옵니다
      var level = map.getLevel();

      if(level == 1) {
        //marker.setMap(map);
        alert("i'm in 1");
        showOnMap();
      }
      else{
        marker.setMap(null);
      }
  });

  function showOnMap(){
    // 주소로 좌표를 검색합니다
    geocoder.addr2coord('ㅇㄹㅇㄹ', function(status, result) {      // 정상적으로 검색이 완료됐으면
         if (status === daum.maps.services.Status.OK) {
            var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);
            marker.setMap(map);
            marker.setPosition(coords);
            alert(coords);
            // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
            map.setCenter(coords);
        }
        else{
          alert("검색 대상을 찾을 수 없습니다");
        }
    });
  }
</script>
</body>
</html>
