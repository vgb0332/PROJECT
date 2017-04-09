var center_location = {
  //Seoul centered Location
    'lat': 37.5668260055,
    'lng': 126.9786567859
};
var markers = []; //marker array
var geocoder = new daum.maps.services.Geocoder();
var map_container_id = 'map-canvas-fs';
var mapContainer = document.getElementById(map_container_id), // 지도를 표시할 div
      mapOption = {
          center: new daum.maps.LatLng(center_location.lat, center_location.lng), // 지도의 중심좌표
          level: 5 // 지도의 확대 레벨
      };
var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
// 마커 클러스터러를 생성합니다
var clusterer = new daum.maps.MarkerClusterer({
    map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체
    averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정
    minLevel: 6 // 클러스터 할 최소 지도 레벨
  });
//////////////////////////////////////
var len;
$.ajax({
url:'assets/php/data2.php',
//type:'post',
//data:{Addr:target},
//dataType:'json',
success:function(data){
  var res = JSON.parse(data);
   console.log(res);
   //make_markers(res);
  }
});
function make_markers(res){
  for(var i = 0; i < res.length/2; i++){
    var marker = new daum.maps.Marker({
          map: map, // 마커를 표시할 지도
          position: new daum.maps.LatLng(res[i][1], res[i][2]), // 마커를 표시할 위치
          title : res[i][0], // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
          //image : markerImage // 마커 이미지
        });
  }
}
/*
//call back function
var callback = function(status, result) {
    if (status === daum.maps.services.Status.OK) {
      var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);
      var t_title = result.addr[0].title;
      var marker = new daum.maps.Marker({
         map: map,
         position: coords,
         title: t_title,
      });
      markers.push(marker);
      daum.maps.event.addListener(marker, 'click', function() {
         alert(result.addr[0].title);
      });
      //map.setCenter(coords);
      clusterer.addMarker(marker);
    }
};
*/

function setMapType(maptype) {
    var roadmapControl = document.getElementById('btnRoadmap');
    var skyviewControl = document.getElementById('btnSkyview');
    if (maptype === 'roadmap') {
        map.setMapTypeId(daum.maps.MapTypeId.ROADMAP);
        roadmapControl.className = 'selected_btn';
        skyviewControl.className = 'selected_btn2';
    } else {
        map.setMapTypeId(daum.maps.MapTypeId.HYBRID);
        skyviewControl.className = 'selected_btn';
        roadmapControl.className = 'selected_btn2';
    }
  }

// 지도 확대, 축소 컨트롤에서 확대 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
function zoomIn() {
    map.setLevel(map.getLevel() - 1);
}
// 지도 확대, 축소 컨트롤에서 축소 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
function zoomOut() {
    map.setLevel(map.getLevel() + 1);
}

// 지도가 확대 또는 축소되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
daum.maps.event.addListener(map, 'zoom_changed', function() {
    // 지도의 현재 레벨을 얻어옵니다
    var level = map.getLevel();
    //console.log(level);
});

function searchPlaces(){
    var target = document.getElementById("formSearchUpLocation2").value;
    if(target === ''){
    	alert("검색어를 입력하세요");
    	return;
    }
    ajax_search(target);
}

function ajax_search(target){
  $.ajax({
  url:'assets/php/data.php',
  type:'post',
  data:{Addr:target},
  //dataType:'json',
  success:function(data){
    var res = JSON.parse(data);
    //console.log(res);
     make_marker(res);
    }
  });
}

function delete_old_markers(){
	for(var i = 0; i < markers.length; ++i){
		markers[i].setMap(null);
		clusterer.removeMarker(markers[i]);
	}
}

function make_marker(res){
	delete_old_markers();
  var len = res.length;

  for(var i = 0; i < len; ++i){
      var marker = new daum.maps.Marker({
      			map: map, // 마커를 표시할 지도
      			position: new daum.maps.LatLng(res[i][3], res[i][4]), // 마커를 표시할 위치
      			title : res[i][0], // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
      			//image : markerImage // 마커 이미지
  				});
  	markers.push(marker);
    daum.maps.event.addListener(marker, 'click', function(){
    	console.log(this.getTitle());
	    $.ajax({
	  		url:'assets/php/detail.php',
	  		type:'post',
	  		data:{Addr:this.getTitle()},
	  		//dataType:'json',
	  		success:function(data){
	    	//alert(data);
	    	var res = JSON.parse(data);
	    	//console.log(res);
	    	alert(res);
	    	}
	  	});
      });
	}
}
