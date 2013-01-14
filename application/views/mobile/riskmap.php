<!DOCTYPE html>
<html>
<head>
	<title> Risk Map </title>
	<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-9o53l2-ccgNGON3JbUefG9aEmV09ikA&sensor=true">
    </script>
	<script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>

	<link rel="stylesheet" href="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.css" />
    <script src="js\jquery-1.8.2.js"></script>
    <script src="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.js"></script>
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%}
</style>
</head>

<body>
<div data-role="page" style="position:absolute;top:0;left:0; right:0; bottom:0;width:100%; height:100%">
	<div data-role="content" style="width:100%; height:100%">
	<script>
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		function initialize()
		{
		var mapProp = {
		  center:dasma,
		  zoom:15,
		  mapTypeId:google.maps.MapTypeId.ROADMAP
		  };
		var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

		var myCity = new google.maps.Circle({
		  center:dasma,
		  radius:200,
		  strokeColor:"#0000FF",
		  strokeOpacity:0.8,
		  strokeWeight:2,
		  fillColor:"#0000FF",
		  fillOpacity:0.4
		  });

		myCity.setMap(map);
		}

		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
		<div id="googleMap"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>