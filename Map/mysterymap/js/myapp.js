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
	
	 
      function addMarkers1(){
	$("#map").addMarker({
    	address: "Kauppakatu 58, Tornio", 
		title: 'Lapland UAS',
    	url: 'http://www.lapinamk.fi' 
    });
}

	addMarkers1();
          
          function addMarkers2(){
	$("#map").addMarker({
    	address: "Hallituskatu 15, Tornio", 
		title: 'Umpitunneli',
    	url: 'http://www.lapinamk.fi' 
    });
}

	addMarkers2();
          
          function addMarkers3(){
	$("#map").addMarker({
    	address: "Kirkkokatu 1, Tornio", 
		title: 'Kirkkokatu',
    	url: 'http://www.lapinamk.fi' 
    });
}

	addMarkers3();
      
	
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
		var image ='http://maps.google.com/mapfiles/ms/icons/green-dot.png'; 
		$("#map").addMarker({
			coords: [lat, lng], 
			title: 'Your position', 
			text:  '<p>Your Position</p>',
            icon: image
		});
         
	  }
	  function error(err){
		console.log(err)
	  }  
	} else {
	  console.log("browser not supported");
	}
}