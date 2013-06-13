<!DOCTYPE html> 
<html> 
<head>
<meta charset="utf-8"/>
    
<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}

#header-holder	{ height:25%; width: 100% }
#header-padder	{ padding:15px; }
#upper-header	{ height:160px; width:parent; overflow:scroll; overflow-x:hidden; }

#sidebar-holder	{ border:1px solid red; align:right; }
#sidebar		{ border:1px solid blue; }

#googleMap		{ height:75%; width:65% }
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('scripts/jQRangeSLider-5.1.1/css/iThing.css')?>"/>
<link rel="stylesheet" href="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/lib/jquery-ui/css/smoothness/jquery-ui-1.8.10.custom.css')?>"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/lib/jquery-ui/js/jquery-ui-1.8.16.custom.min.js')?>"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/lib/jquery.mousewheel.min.js')?>"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/jQDateRangeSlider-min.js')?>"></script>

<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/dateSliderDemo.js')?>"></script>

<script>
	
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		function initialize()
		{
			var mapProp = {
				center: dasma,
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.TERRAIN
			};
			var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

			/** Weather and Clouds Layer **/
			var weatherLayer = new google.maps.weather.WeatherLayer({
				  temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
				});
				weatherLayer.setMap(map);

				var cloudLayer = new google.maps.weather.CloudLayer();
				cloudLayer.setMap(map);
			/** end of Weather and Clouds Layer **/
				
			var markers = [];

			var oms = new OverlappingMarkerSpiderfier(map);

			/** Map Nodes **/
			//var node_markers*= [];

			if (document.getElementById("map_nodes_result_length").value != 0)
			{
				var image = document.getElementById("node_icon").value;
				for (var ctr = 0; ctr < document.getElementById("map_nodes_result_length").value; ctr++)
				{
					var node_marker = new google.maps.Marker({
											position: new google.maps.LatLng(
											document.getElementById("nd_lat" + ctr).value,
											document.getElementById("nd_lng" + ctr).value		
										),
										map: map,
										icon: image
							});
	
					var node_marker_info = new google.maps.InfoWindow({
								content: 'test'
							});

					/*google.maps.event.addListener(node_marker, 'click', function() {
						node_marker_info.open(map,node_marker);
						});*/
					
					oms.addListener('click', function(node_marker) {
							node_marker_info.open(map, node_marker);
						});
						
					oms.addMarker(node_marker);
					markers.push(node_marker);
				}
			}
			//alert('test');

			/** end Map Nodes **/
			
			/** Polygon **/
			
			if (document.getElementById("polygon_nodes_result_length").value != 0)
			{
				var polygons = new Array();
				var polygon_coords = new Array();
				var pol_id_ctr = 0;
				
				for (var p_ctr = 0; p_ctr < document.getElementById("polygon_nodes_result_length").value; p_ctr++)
				{
					if (pol_id_ctr == document.getElementById("pol_id" + p_ctr).value)
					{
						polygon_coords.push( 
					 			new google.maps.LatLng(
					 					document.getElementById("pol_lat" + p_ctr).value,
										document.getElementById("pol_lng" + p_ctr).value
							 		)
								);
						//alert(document.getElementById("pol_id" + p_ctr).value);
					}
					else
					{
						pol_id_ctr++;
						polygons.push(polygon_coords);
						polygon_coords = [];
					}
				}
				//alert(polygons[0]);
				//alert(pol_id_ctr);
				for (var ctr = 0; ctr <= pol_id_ctr; ctr++)
				{
					var polygon_marker = new google.maps.Polygon({
											paths: polygons[ctr],
											strokeColor: "#FF0000",
										    strokeOpacity: 0.8,
										    strokeWeight: 2,
										    fillColor: "#FF0000",
										    fillOpacity: 0.35		
							});
	
					polygon_marker.setMap(map);
				}
			}
			
			/** end Polygon **/
					
			//var mc = new MarkerClusterer(map, markers, mcOptions);
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
	
	<?php if ($points != NULL){?>
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
	<?php }} else { ?> <input type="hidden" id="result_length" value="0" /> <?php } ?>
	
<!-- Dengue Risk Areas -->
<input type="hidden" id="map_nodes_result_length" value="<?php echo count($map_nodes); ?>" />
	<?php for ($ctr = 0; $ctr < count($map_nodes); $ctr++) {?>
		<input type="hidden" id="nd_no<?= $ctr ?>" 		value="<?php echo $map_nodes[$ctr]['node_no']; ?>"	/>
		<input type="hidden" id="nd_name<?= $ctr ?>" 	value="<?php echo $map_nodes[$ctr]['node_name']; ?>"	/>
		<input type="hidden" id="nd_city<?= $ctr ?>"	value="<?php echo $map_nodes[$ctr]['node_city']; ?>"	/>
		<input type="hidden" id="nd_lat<?= $ctr ?>" 	value="<?php echo $map_nodes[$ctr]['node_lat']; ?>"			/>
		<input type="hidden" id="nd_lng<?= $ctr ?>" 	value="<?php echo $map_nodes[$ctr]['node_lng']; ?>"			/>
		<input type="hidden" id="nd_type<?= $ctr ?>" 	value="<?php echo $map_nodes[$ctr]['node_type']; ?>"	/>
		<input type="hidden" id="nd_barangay<?= $ctr ?>" value="<?php echo $map_nodes[$ctr]['node_barangay']; ?>"		/>
		<input type="hidden" id="nd_addedOn<?= $ctr ?>"	value="<?php echo $map_nodes[$ctr]['node_addedOn']; ?>"		/>
		<input type="hidden" id="nd_notes<?= $ctr ?>" 	value="<?php echo $map_nodes[$ctr]['node_notes']; ?>"	/>
	<?php } ?>
		<input type="hidden" id="node_icon" value="<?php echo base_url('/images/notice.png')?>" />
<!-- //end Dengue Risk Areas -->
	
	<!-- Polygon Nodes -->
<input type="hidden" id="polygon_nodes_result_length" value="<?php echo count($polygon_nodes); ?>" />
	<?php for ($ctr = 0; $ctr < count($polygon_nodes); $ctr++) {?>
		<input type="hidden" id="pol_no<?= $ctr ?>" 	value="<?php echo $polygon_nodes[$ctr]['point_no']; ?>"		/>
		<input type="hidden" id="pol_name<?= $ctr ?>" 	value="<?php echo $polygon_nodes[$ctr]['polygon_name']; ?>"	/>
		<input type="hidden" id="pol_id<?= $ctr ?>"		value="<?php echo $polygon_nodes[$ctr]['polygon_ID']; ?>"	/>
		<input type="hidden" id="pol_lat<?= $ctr ?>" 	value="<?php echo $polygon_nodes[$ctr]['point_lat']; ?>"	/>
		<input type="hidden" id="pol_lng<?= $ctr ?>" 	value="<?php echo $polygon_nodes[$ctr]['point_lng']; ?>"	/>
	<?php } ?>
<!-- //end Polygon Nodes -->

<body>
	<div id="header-holder">
	<div id="header-padder">
		<div id="upper-header">
		<?php echo form_open(); ?>
		<?php echo form_fieldset();?>
		<table>
			<tr style="width:100%">
				<td style="width:33%;border: 1px solid red"> &nbsp; </td>
				<td style="width:33%;border: 1px solid red;">
					<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/jDateQRangeSlider-min.js')?>"></script>
					<br/><br/>
					<div id="slider"></div>
					<script>
					//<!--
						var today = new Date();
						$("#slider").dateRangeSlider({
								bounds:
								{
									min: new Date(2008, 6, 1),
									max: today
								},
								defaultValues:
								{
									min: new Date((today.getFullYear()-1), today.getMonth(), today.getDate()),
									max: today
								}
							});
						var dateValues = $("#slider").dateRangeSlider("values");
						//console.log(dateValues.min.toString() + " " + dateValues.max.toString());
						//alert("min value is " + dateValues.min.toString() + "\n max value is " + dateValues.max.toString());
					//-->
					</script>
					<article style="padding:50px 20px">
					
					
					
					</article>
				</td>
				<td style="width:33%;border: 1px solid red">
					Overlays <br/>
						<label style="color:red"><?php echo form_error('TPsex-dd'); ?></label>
						<?php echo form_checkbox('risk_area', 'risk_areas',TRUE); ?> Dengue Risk Areas <br/>
						<?php echo form_checkbox('pidsr', 'pidsr_cases',TRUE); ?> Dengue Cases (from PIDSR) <br/>
						<?php echo form_checkbox('plotted', 'plot_cases',TRUE); ?> Dengue Cases (as visited by BHWs) <br/>
						<?php echo form_submit('submit','Submit'); ?>
				</td>
			</tr>
		</table>		
		<?php echo form_fieldset_close();?>
		<?php echo form_close(); ?>
		</div>
	</div>
	
	</div>
	
	<div id="googleMap"></div>
	
</body>
</html>