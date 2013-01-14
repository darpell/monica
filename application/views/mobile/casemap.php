<!DOCTYPE html>
<html>
<head>
	<title> Case Map </title>
	<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-9o53l2-ccgNGON3JbUefG9aEmV09ikA&sensor=true">
    </script>
	<script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>
	
	<link rel="stylesheet" href="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.css" />
    <script src="js\jquery-1.8.2.js"></script>
    <script src="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
	<script src="js\jquery-ui-map-3.0\ui\min\jquery.ui.map.full.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js\jquery-ui-map-3.0\ui\jquery.ui.map.js"></script>

<script type="text/java">
	// Wait for Cordova to load
    // 
    document.addEventListener("deviceready", onDeviceReady, false);

    // Cordova is loaded and it is now safe to make calls Cordova methods
    //
    function onDeviceReady() {
        checkConnection();
    }

function checkConnection() {
        var networkState = navigator.connection.type;

        var states = {};
        states[Connection.UNKNOWN]  = 'Unknown connection';
        states[Connection.ETHERNET] = 'Ethernet connection';
        states[Connection.WIFI]     = 'WiFi connection';
        states[Connection.CELL_2G]  = 'Cell 2G connection';
        states[Connection.CELL_3G]  = 'Cell 3G connection';
        states[Connection.CELL_4G]  = 'Cell 4G connection';
        states[Connection.NONE]     = 'No network connection';

		if (networkState == Connection.NONE) { showConnectionError(states[networkState]); }
		
        alert('Connection type: ' + states[networkState]);
    }

function alertDismissed() {
        // do something
    }
	
function showConnectionError(networkState) {
        navigator.notification.alert(
            networkState,  // message
            alertDismissed,         // callback
            'Connection Error',            // title
            'Okay'                  // buttonName
        );
    }
</script>


<script type="text/javascript">
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
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%}
</style>
</head>

<body>
<div id="googleMap"></div>

</body>
</html>