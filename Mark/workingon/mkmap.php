<?php
//mysqli_fetch_fields
require("config/config.php");
require("lib/db.php");
$conn=db_init($config["host"],$config["duser"],$config["dpw"],$config["dname"]);
?>
<?php
  mysqli_set_charset($conn,"utf8");
  $sql1 = "SELECT * FROM GN_SS";
  $result1 = mysqli_query($conn,$sql1);
  $row1=mysqli_fetch_all($result1);
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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
   	<script src = "js/jquery-3.1.1.min.js"></script>
    <title>지도 생성하기</title>
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
<script>var infotab = document.getElementById('menu_wrap');</script>
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
				$sql = "SELECT * FROM GN_SS where 대지_위치 = ".$addr;
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

<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=15f14e8ea6ccdce536900236805f090e&libraries=services"></script>

<script>

var numOfRows = <?php echo json_encode(mysqli_num_rows($result1), JSON_UNESCAPED_UNICODE); ?>;
var addrName = [numOfRows+1];
alert(numOfRows);
addrName=<?php echo json_encode($row1, JSON_UNESCAPED_UNICODE); ?>;
//addrName=JSON.stringify(addrName);

var mapContainer = document.getElementById('map'), // 지도를 표시할 div
    mapOption = {
        center: new daum.maps.LatLng(37.5172363, 127.04732480000007), // 지도의 중심좌표
        level: 4 // 지도의 확대 레벨
    };

// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
var map = new daum.maps.Map(mapContainer, mapOption);
// 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
var zoomControl = new daum.maps.ZoomControl();
map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);
// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();
//var current_zoom_level = map.getLevel();

var marker = [numOfRows];
var index = 0;
// 주소로 좌표를 검색합니다
for(var i = 0; i < numOfRows; ++i){
	var target = JSON.stringify(addrName[i][5]);
	//alert(target);
	geocoder.addr2coord(target, function(status, result) {
	    // 정상적으로 검색이 완료됐으면 
	     if (status === daum.maps.services.Status.OK) {
	        var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);
			//alert(JSON.stringify(result.addr[0]));
			//alert(result.addr[0].title);
			//alert(coords);
	        // 결과값으로 받은 위치를 마커로 표시합니다
	        marker[index] = new daum.maps.Marker({
	            map: map,
	            title: result.addr[0].title,
	            position: coords
	        });
			marker[index].setMap(null);
	        daum.maps.event.addListener(marker[index], 'click', clickListener(map));
			index++;
	        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
	        //map.setCenter(coords);
	    } 
	});    
}


function clickListener(map){
	return function(){
			//alert(this.getTitle());
			$.ajax({
			url:'data.php',
			type:'post',
			data:{Addr:this.getTitle()},
			//dataType:'json',
			success:function(data){
				alert('suck');
				//var str = '';
				//for(var j=0;j<data.length;j++){
				//}
			}
		})
		/*for(var j = 0; j < numOfRows; ++j)
		{
			if(JSON.stringify(addrName[i][7])==this.getTitle())
			{
				for(var h=0;h<64;h++)
				{
				//document.write(JSON.stringify(addrName[i][j]);
				}
				//return;
			}
		}*/
		
		//infotab.style.visibility:'visible';
	//document.getElementById('target').className='white';
	
	};
}
// 지도가 확대 또는 축소되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
daum.maps.event.addListener(map, 'zoom_changed', function() {        
    // 지도의 현재 레벨을 얻어옵니다
    var level = map.getLevel();
    if(level == 1 || level == 2){
    	for(var i in marker){
    		marker[i].setMap(map);
    	}
    }
    //else{
    	//for(var i in marker){
    		//marker[i].setMap(null);
    	//}
    //}
});
</script>



</body>
</html>
