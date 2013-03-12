
<!DOCTYPE html>
<html>
  <head>
    <title>Current Position</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <!--
    Include the maps javascript with sensor=true because this code is using a
    sensor (a GPS locator) to determine the user's location.
    See: https://developers.google.com/apis/maps/documentation/javascript/basics#SpecifyingSensor
    -->
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
	<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>
    <style type="text/css">
		html {height:100%}
		body {height:100%;margin:0;padding:0}
		#currentLocation {height:100%}
	</style>
    
  </head>
  <body>
<div data-role="page" id="checklocation" style="position:absolute;top:0;left:0; right:0; bottom:0;width:100%; height:100%">
    <div data-role="header" data-position="fixed"> 
    	<h2> Current Location </h2> 
    	<a href="#" data-rel="panel" data-icon="gear" class="ui-btn-right"> Options </a>
    </div> <!-- /header-->
    <div data-role="content" style="width:100%; height:100%;padding:0;">
        <div id="currentLocation" style="position:absolute; width:100%; height:100%;"></div>
    </div><!-- /content -->
    <!-- <script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-9o53l2-ccgNGON3JbUefG9aEmV09ikA&sensor=true">
        </script> -->
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
		 <script>
		if (navigator.geolocation) {
			var timeoutVal = 10 * 1000 * 1000;
			navigator.geolocation.getCurrentPosition(
				displayPosition, 
				displayError,
				{ enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
			);
		}
		else {
			alert("Geolocation is not supported by this browser");
		}
		
		function displayPosition(position) {
			var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			var options = {
				zoom: 15,
				center: pos,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("currentLocation"), options);
			var marker = new google.maps.Marker({
				position: pos,
				map: map,
				title: "User location"
			});
			
			var contentString = "<b>Timestamp:</b> " + parseTimestamp(position.timestamp) + "<br/><b>User location:</b> lat " + position.coords.latitude + ", long " + position.coords.longitude + ", accuracy " + position.coords.accuracy;
			var btn = '<div id="info_content"> <button onclick="window.open(&quot;<?= site_url('mobile/larval_survey') ?>&quot;);"> Add Larval Incidence </button></div>';
			var infowindow = new google.maps.InfoWindow({
				content: contentString + btn
			});
			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
		}
		
		function displayError(error) {
			var errors = { 
				1: 'Permission denied',
				2: 'Position unavailable',
				3: 'Request timeout'
			};
			alert("Error: " + errors[error.code]);
			navigator.notification.alert(""+errors[error.code], alertCallback, 'Error', 'Done');
		}
		
		function alertCallback() {
			
		}
		
		function parseTimestamp(timestamp) {
			var d = new Date(timestamp);
			var day = d.getDate();
			var month = d.getMonth() + 1;
			var year = d.getFullYear();
			var hour = d.getHours();
			var mins = d.getMinutes();
			var secs = d.getSeconds();
			var msec = d.getMilliseconds();
			return day + "." + month + "." + year + " " + hour + ":" + mins + ":" + secs + "," + msec;
		}
	</script>
</div><!-- /page -->
  </body>
</html>
