<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

<!-- CONTENT -->
    
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%}
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>

<script>
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		function initialize()
		{
			var mapProp = {
				center: dasma,
				zoom: 10,//15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
			var mcOptions = {gridSize: 50, maxZoom: 15};
			var markers = [];
			for (var pt_ctr = 0; pt_ctr < document.getElementById("result_length").value  ; pt_ctr++) 
			{
			      var marker = 
					    new google.maps.Marker({
							position:new google.maps.LatLng(
									document.getElementById("pt_lat" + pt_ctr).value,
									document.getElementById("pt_lng" + pt_ctr).value
							)
					});
				markers.push(marker);
			}
			var mc = new MarkerClusterer(map, markers, mcOptions);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>

<body>
<div data-role="page" style="position:absolute;top:0;left:0; right:0; bottom:0;width:100%; height:100%">
	<div data-role="header" data-position="fixed"> 
    	<h2> Current Location </h2> 
    	<a href="<?php echo site_url('mobile/larval_dialog');?>" data-rel="panel" data-icon="gear" class="ui-btn-right"> Options </a>
    </div> <!-- /header-->
	<div data-role="content" style="width:100%; height:100%">
	<input type="hidden" id="result_length" value="<?php echo count($points); ?>" />
	<?php for ($ctr = 0; $ctr < count($points); $ctr++) {?>
		<input type="hidden" id="pt_barangay<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_barangay']; ?>"	/>
		<input type="hidden" id="pt_street<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_street']; ?>"	/>
		<input type="hidden" id="pt_municipality<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_municipality']; ?>"	/>
		<input type="hidden" id="pt_lat<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_lat']; ?>"			/>
		<input type="hidden" id="pt_lng<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_lng']; ?>"			/>
		<input type="hidden" id="pt_household<?= $ctr ?>" 	value="<?php echo $points[$ctr]['ls_household']; ?>"	/>
		<input type="hidden" id="pt_result<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_result']; ?>"		/>
		<input type="hidden" id="pt_created_on<?= $ctr ?>" 	value="<?php echo $points[$ctr]['created_on']; ?>"		/>
		<input type="hidden" id="pt_container<?= $ctr ?>" 	value="<?php echo $points[$ctr]['ls_container']; ?>"	/>
	<?php } ?>
	
		<div id="googleMap"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>