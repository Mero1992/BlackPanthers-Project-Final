/*
	file: 	js/myapp.js
	desc:	Code for app.
*/
$(document).ready(function(){
	$(function() {
		getUserLocation();
    $("#map").googleMap({
      zoom: 10, // Initial zoom level (optional)
      coords: [65.848663, 24.151954], // Map center (optional)
	  type: "ROADMAP",  // Map type (optional)
	  zoomControl: true,
	  scaleControl: true
	})

	addMarkers();
	$("#search").submit(function(event){
		addSearch();
		return false;  //no page refresh after submit
	});
  })
});

function addMarkers(){
	$("#map").addMarker({
    	address: "Kauppakatu 58, Tornio", 
		title: 'Lapland UAS',
    	url: 'http://www.lapinamk.fi' 
    });
	var url="getCompanyAddress.php";
	Markers(url);
}
function addSearch(){
	//clear the map from previous state by initializing it
	$("#map").googleMap({
      zoom: 10, // Initial zoom level (optional)
      coords: [65.848663, 24.151954], // Map center (optional)
	  type: "ROADMAP" // Map type (optional)
    });
	//take city name from select choise (area)
	var area=$("#area").val();
	var type=$("#type").val();
	var url="getCompanyAddress.php?area="+area+"&type="+type;
	Markers(url);
}

function Markers(url){
	$.getJSON(url,function(result){
		$.each(result.companies,function(key,company){
			address=company.Street + ', '+company.City;
			$("#map").addMarker({
				address: address, 
				title: company.Companyname,
				url: company.Web 
			});
		});
	});
}

function getUserLocation(){
	if('geolocation' in navigator){
	var options = {
		enableHighAccuracy: false,
		timeout: 5000,
		maximumAge: 0
	  };
	  navigator.geolocation.getCurrentPosition(success, error, options); 
	  function success(pos){
		var lng = pos.coords.longitude;
		var lat = pos.coords.latitude;
		var image ='images/koshka.ico';
		$("#map").addMarker({
			coords: [lat, lng], 
			title: 'Your position', 
			text:  '<p>Your Position</p>',
		});
	  }
	  function error(err){
		console.log(err)
	  }  
	} else {
	  console.log("browser not supported");
	}
}