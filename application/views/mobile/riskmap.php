<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
    
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
	
	<input type="hidden" value="<?php echo ''; ?>">
	
		<div id="googleMap"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>