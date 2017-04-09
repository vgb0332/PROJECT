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
          level: 6 // 지도의 확대 레벨
      };
var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
// 마커 클러스터러를 생성합니다
var clusterer = new daum.maps.MarkerClusterer({
    map: map, // 마커들을 클러스터로 관리하고 표시할 지도 객체
    averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정
    //markers: markers,
    minLevel: 4// 클러스터 할 최소 지도 레벨
  });
  // 지도 타입 정보를 가지고 있을 객체입니다
// map.addOverlayMapTypeId 함수로 추가된 지도 타입은
// 가장 나중에 추가된 지도 타입이 가장 앞에 표시됩니다
// 이 예제에서는 지도 타입을 추가할 때 지적편집도, 지형정보, 교통정보, 자전거도로 정보 순으로 추가하므로
// 자전거 도로 정보가 가장 앞에 표시됩니다
var mapTypes = {
    terrain : daum.maps.MapTypeId.TERRAIN,    
    traffic :  daum.maps.MapTypeId.TRAFFIC,
    bicycle : daum.maps.MapTypeId.BICYCLE,
    useDistrict : daum.maps.MapTypeId.USE_DISTRICT
};

var imageSrc = 'assets/img/small_marker.png'; // 마커이미지의 주소입니다    
    imageSize = new daum.maps.Size(10, 10), // 마커이미지의 크기입니다
    imageOption = {offset: new daum.maps.Point(0, 0)};

// 마커의 이미지정보를 가지고 있는 마커이미지를 생성합니다
var markerImage = new daum.maps.MarkerImage(imageSrc, imageSize, imageOption);

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


function searchPlaces(){
    var target = document.getElementById("formSearchUpLocation").value;
    if(target === ''){
    	alert("검색어를 입력하세요");
    	return;
    }
    console.log(target);
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

// 체크 박스를 선택하면 호출되는 함수입니다
function setOverlayMapTypeId() {
    var chkTerrain = document.getElementById('chkTerrain'),  
        chkTraffic = document.getElementById('chkTraffic'),
        chkBicycle = document.getElementById('chkBicycle'),
        chkUseDistrict = document.getElementById('chkUseDistrict');
    
    // 지도 타입을 제거합니다
    for (var type in mapTypes) {
        map.removeOverlayMapTypeId(mapTypes[type]);    
    }

    // 지적편집도정보 체크박스가 체크되어있으면 지도에 지적편집도정보 지도타입을 추가합니다
    if (chkUseDistrict.checked) {
        map.addOverlayMapTypeId(mapTypes.useDistrict);    
    }
    
    // 지형정보 체크박스가 체크되어있으면 지도에 지형정보 지도타입을 추가합니다
    if (chkTerrain.checked) {
        map.addOverlayMapTypeId(mapTypes.terrain);    
    }
    
    // 교통정보 체크박스가 체크되어있으면 지도에 교통정보 지도타입을 추가합니다
    if (chkTraffic.checked) {
        map.addOverlayMapTypeId(mapTypes.traffic);    
    }
    
    // 자전거도로정보 체크박스가 체크되어있으면 지도에 자전거도로정보 지도타입을 추가합니다
    if (chkBicycle.checked) {
        map.addOverlayMapTypeId(mapTypes.bicycle);    
    }
}  

function show_markers(bounds){
	//console.log(bounds);
	// 영역의 남서쪽 좌표를 얻어옵니다 
    var swLatLng = bounds.getSouthWest(); 
    // 영역의 북동쪽 좌표를 얻어옵니다 
    var neLatLng = bounds.getNorthEast(); 
    //console.log(swLatLng + neLatLng);
    $.ajax({
		url:'assets/php/data2.php',
		type:'post',
		data:{swLat : swLatLng.getLat(), swLng : swLatLng.getLng(),
			  neLat : neLatLng.getLat(), neLng : neLatLng.getLng()},
		//dataType:'json',
		success:function(data){
		  //console.log(data);
		  var flag = 0;
		  var res = JSON.parse(data);
		  for(var i = 0; i < res.length; ++i){
		  	for(var j = 0; j < markers.length; ++j){
		  		if(res[i][0] == markers[j].getTitle()){
		  			flag = 1;
		  			break;
		  		}
		  	}
		  	if(!flag){
		      var marker = new daum.maps.Marker({
		      			map: map, // 마커를 표시할 지도
		      			position: new daum.maps.LatLng(res[i][1], res[i][2]), // 마커를 표시할 위치
		      			title : res[i][0], // 마커의 타이틀, 마커에 마우스를 올리면 타이틀이 표시됩니다
		      			image : markerImage // 마커 이미지
		  				});
		  		markers.push(marker);
		  		marker.setMap(map);
		  		flag = 0;
		      
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
		    else{
		    	for(var i = 0; i < markers.length; ++i){
		    		markers[i].setMap(map);
		    	}     	
		    }
		}
	}
 });
}

function hide_markers(){
	for(var i = 0; i < markers.length; ++i){
		markers[i].setMap(null);
	}
}
daum.maps.event.addListener(map, 'center_changed', function() {        
    // 지도의  레벨을 얻어옵니다
    var level = map.getLevel();
    
    // 지도의 중심좌표를 얻어옵니다 
    var latlng = map.getCenter(); 
    var bounds = map.getBounds();
    
    console.log("지도레밸: " + level);
    //console.log("좌표: " + latlng);
    //console.log("경계: " + bounds);
    
    if(level <= 2){
    	show_markers(bounds);
    }
    else{
    	console.log("hide!" + markers.length);
    	hide_markers();
    }
});

// 지도가 확대 또는 축소되면 마지막 파라미터로 넘어온 함수를 호출하도록 이벤트를 등록합니다
daum.maps.event.addListener(map, 'zoom_changed', function() {
    // 지도의 현재 레벨을 얻어옵니다
    var level = map.getLevel();
    //console.log(level);
});

