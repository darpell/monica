<!DOCTYPE html>
<html dir="ltr" lang="en-gb">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<title>Geolocation API getCurrentPosition example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>
	<script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-9o53l2-ccgNGON3JbUefG9aEmV09ikA&sensor=true">
        </script>
	<style type="text/css">
	html {height:100%}
	body {height:100%;margin:0;padding:0}
	#mapholder {height:100%}
	</style>
</head>
<body>
<div data-role="page" id="checklocation" data-add-back-btn="true" style="position:absolute;top:0;left:0; right:0; bottom:0;width:100%; height:100%">
    <div data-role="header" data-position="fixed"> <h2> Current Location </h2> </div> <!-- /header-->
    <div data-role="content" style="width:100%; height:100%;padding:0;">
		<p>Click on the marker for position information.</p>
        <div id="mapholder" style="position:absolute; width:100%; height:100%;"></div>
    </div><!-- /content -->
	<script>
	  if (navigator.geolocation)
	    {
	    navigator.geolocation.getCurrentPosition(showPosition,showError);
	    }
	  else{}

	  function detectBrowser() {
		  var useragent = navigator.userAgent;
		  var mapdiv = document.getElementById("mapholder");

		  if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
		    mapdiv.style.width = '100%';
		    mapdiv.style.height = '100%';
		  } else {
		    mapdiv.style.width = '600px';
		    mapdiv.style.height = '800px';
		  }
		}

	function showPosition(position)
	  {
	  lat=position.coords.latitude;
	  lon=position.coords.longitude;
	  latlon=new google.maps.LatLng(lat, lon);
	  mapholder=document.getElementById('mapholder');

	  var myOptions={
	  center:latlon,zoom:14,
	  mapTypeId:google.maps.MapTypeId.ROADMAP,
	  mapTypeControl:false,
	  navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
	  };
	  var map=new google.maps.Map(document.getElementById("mapholder"),myOptions);
	  var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
	  }

	function showError(error)
	  {
	  switch(error.code) 
	    {
	    case error.PERMISSION_DENIED:
	      x.innerHTML="User denied the request for Geolocation."
	      break;
	    case error.POSITION_UNAVAILABLE:
	      x.innerHTML="Location information is unavailable."
	      break;
	    case error.TIMEOUT:
	      x.innerHTML="The request to get user location timed out."
	      break;
	    case error.UNKNOWN_ERROR:
	      x.innerHTML="An unknown error occurred."
	      break;
	    }
	  }
	</script>
</div><!-- /page -->
</body>
</html>