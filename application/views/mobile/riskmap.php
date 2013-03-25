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
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>

<script>
	
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		function initialize()
		{
			var mapProp = {
				center: dasma,
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.HYBRID
			};
			var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

			var oms = new OverlappingMarkerSpiderfier(map);
			
			var mcOptions = {gridSize: 50, maxZoom: 15};
			var markers = [];

				// Arrays for distance formula
			var tracking_no = [];
			var refNumber = [];
			var household = [];
			var container = [];

			/*
			var amount_200 = [];
			var percent_200 = [];
			var amount_50 = [];
			var percent_50 = [];
			*/
				
			for (var ctr = 0; ctr < document.getElementById("result_length").value; ctr++)
			{
				// distance formula necessities
				tracking_no[ctr] = document.getElementById("pt_tracking_no" + ctr).value;
		  		refNumber[ctr] = document.getElementById("pt_ref_no" + ctr).value;
		  		household[ctr] = document.getElementById("pt_household" + ctr).value;
		  		container[ctr] = document.getElementById("pt_container" + ctr).value;
		  		/*amount_200[ctr] = document.getElementById("amount_200_" + ctr).value;
				percent_200[ctr] = document.getElementById("percentage_200_" + ctr).value;
		  		amount_50[ctr] = document.getElementById("amount_50_" + ctr).value;
				percent_50[ctr] = document.getElementById("percentage_50_" + ctr).value;*/
		  			
				// end distance formula necessities
			}
			
			for (var pt_ctr = 0; pt_ctr < document.getElementById("result_length").value; pt_ctr++) 
			{
				var marker = new google.maps.Marker({
									position:new google.maps.LatLng(
									document.getElementById("pt_lat" + pt_ctr).value,
									document.getElementById("pt_lng" + pt_ctr).value
							)
					});


				var householdcount = 0;
				var containercount = 0;
				for (var __i = 0; __i < household.length; __i++)
		        {
			       	if (household[pt_ctr] === household[__i])
			       		householdcount++;
			       	if (container[pt_ctr] === container[__i])
			       		containercount++;
				}
				var householdpercent = householdcount / household.length * 100;
				var containerpercent = containercount / container.length * 100;
					
				// infowindow content
				var html = "<b>Larval Survey Report #: </b>" + refNumber[pt_ctr]
			    	+ " <br/>" + "<b>Tracking #: </b>" + tracking_no[pt_ctr]
			    /*	+ " <br/>" + "<b>Larval positives (LP) within: </b>"
			    	+ " <br/>" + "<b>200m:</b>" + amount_200[pt_ctr] +" ("+ percent_200[pt_ctr] +"% of displayed LP)"
			    	+ " <br/>" + "<b>50m:</b>" + amount_50[pt_ctr] +" ("+ percent_50[pt_ctr] +"% of displayed LP)" */
			    	+ "<br/><br/>" + "<b>Household: </b>" + household[pt_ctr] +" ("+ householdcount +" of "+ household.length +" total occurrences, "+ householdpercent.toFixed(2) + "%)"
			    	+ " <br/>" + "<b>Container: </b>" + container[pt_ctr] +" ("+ containercount +" of "+ container.length +" total occurances, "+ containerpercent.toFixed(2) + "%)";
				// end infowindow content
				
				marker.info = new google.maps.InfoWindow({
							content: html
						});
					oms.addListener('click', function(marker) {
						 marker.info.open(map, marker);
					});
					
				oms.addMarker(marker);
				markers.push(marker);
			}
					
			var mc = new MarkerClusterer(map, markers, mcOptions);
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
</head>
<!-- 
	<input type="hidden" id="computation_length" value="<?php //count($distance_formula_200) ?>" />
	<!-- 200m 
	<?php //for ($i = 0; $i < count($distance_formula_200); $i++) :?>
	<input type="hidden" id="tracking_no_200_<?php //$i ?>"	value="<?php //echo $distance_formula_200[$i]['tracking_no'];?>" /> <br/>
	<input type="hidden" id="amount_200_<?php //$i ?>" 		value="<?php //echo $distance_formula_200[$i]['amount'];?>" /> <br/>
	<input type="hidden" id="percentage_200_<?php //$i ?>"	value="<?php //echo $distance_formula_200[$i]['percentage'];?>" /> <br/>
	<?php //endfor;?>
	<!-- /200m 
	
	<!-- 50m 
	<?php //for ($i = 0; $i < count($distance_formula_50); $i++) :?>
	<input type="hidden" id="tracking_no_50_<?php //$i ?>"	value="<?php //echo $distance_formula_50[$i]['tracking_no'];?>" /> <br/>
	<input type="hidden" id="amount_50_<?php //$i ?>" 		value="<?php //echo $distance_formula_50[$i]['amount'];?>" /> <br/>
	<input type="hidden" id="percentage_50_<?php //$i ?>"	value="<?php //echo $distance_formula_50[$i]['percentage'];?>" /> <br/>
	<?php //endfor;?>
	<!-- /50m -->
	
<input type="hidden" id="result_length" value="<?php echo count($points); ?>" />
	<?php for ($ctr = 0; $ctr < count($points); $ctr++) {?>
		<input type="hidden" id="pt_barangay<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_barangay']; ?>"	/>
		<input type="hidden" id="pt_street<?= $ctr ?>" 			value="<?php echo $points[$ctr]['ls_street']; ?>"	/>
		<input type="hidden" id="pt_municipality<?= $ctr ?>"	value="<?php echo $points[$ctr]['ls_municipality']; ?>"	/>
		<input type="hidden" id="pt_lat<?= $ctr ?>" 			value="<?php echo $points[$ctr]['ls_lat']; ?>"			/>
		<input type="hidden" id="pt_lng<?= $ctr ?>" 			value="<?php echo $points[$ctr]['ls_lng']; ?>"			/>
		<input type="hidden" id="pt_household<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_household']; ?>"	/>
		<input type="hidden" id="pt_result<?= $ctr ?>" 			value="<?php echo $points[$ctr]['ls_result']; ?>"		/>
		<input type="hidden" id="pt_created_on<?= $ctr ?>" 		value="<?php echo $points[$ctr]['created_on']; ?>"		/>
		<input type="hidden" id="pt_container<?= $ctr ?>" 		value="<?php echo $points[$ctr]['ls_container']; ?>"	/>
		<input type="hidden" id="pt_tracking_no<?= $ctr ?>" 	value="<?php echo $points[$ctr]['tracking_number']; ?>"	/>
		<input type="hidden" id="pt_ref_no<?= $ctr ?>" 	value="<?php echo $points[$ctr]['ls_no']; ?>"	/>
	<?php } ?>

<body>
<div data-role="page" style="top:0;left:0; right:0; bottom:0;">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<h2> Larval Location </h2>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
    	<a href="<?php echo site_url('mobile/riskmap_options');?>" data-icon="gear" class="ui-btn-right" data-ajax="false" data-role="button" data-inline="true" data-rel="dialog" data-transition="pop"> Options </a>
    </div> <!-- /header-->
	<div data-role="content" style="width:100%; height:100%;">
		<div id="googleMap" style="margin:-15px 0 0 -15px;"></div>
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>