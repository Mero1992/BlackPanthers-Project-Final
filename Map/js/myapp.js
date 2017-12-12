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
	
	$("#map").addWay({
    	start: "Eliaksenkatu 8, 95400 Tornio",
		end:  "Stakkevollveien 41, 9010 Tromsø, Norway",
		route : 'way',
		language : 'english'
	});

	addMarkers();
	$("#search").submit(function(event){
		addSearch();
		return false;  //no page refresh after submit
	});
  })
});



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