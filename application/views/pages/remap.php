<!DOCTYPE html> 
<html> 
<head>
<meta charset="utf-8"/>
    
<style>
html { height:100% }
body { height:100%;margin:0;padding:0 }
#container { height:100%; width:100% }
#header { border:1px solid red; margin:10px;padding: 10px; }
#sidebar { float:right; width:40%; height:85%; border:1px solid blue; margin: 0px 10px 10px 10px;padding: 10px; }
#sidebar-higher { height:0%; }
#sidebar-lower { height:100% }
#googleMap { width:55%; height:90%; margin: 10px; }
</style>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather,visualization&sensor=true"></script>
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
	$(function() {
		var tabs = $( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
				axis: "x",
				stop: function() {
				tabs.tabs( "refresh" );
			}
		});
	});
</script>

<script>
	
		var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
		var heatmap, map, pointArray;
		function initialize()
		{
			var mapProp = {
				center: dasma,
				zoom: 12,
				mapTypeId: google.maps.MapTypeId.TERRAIN
			};
			map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

			/** Weather and Clouds Layer **/
			var weatherLayer = new google.maps.weather.WeatherLayer({
				  temperatureUnits: google.maps.weather.TemperatureUnit.FAHRENHEIT
				});
				weatherLayer.setMap(map);

				var cloudLayer = new google.maps.weather.CloudLayer();
				cloudLayer.setMap(map);
			/** end of Weather and Clouds Layer **/
			
			var cases = new Array();
			var markers = [];

			var oms = new OverlappingMarkerSpiderfier(map);
			
			//centroid variables
			var x1=999;
			var x2=-999;
			var y1=999;
			var y2=-999;

			/** Sample Larval Data used as case data **/
			if (document.getElementById("result_length").value != 0)
			{
				//var case_img = document.getElementById("case_icon").value;
				for (var pt_ctr = 0; pt_ctr < document.getElementById("result_length").value; pt_ctr++) 
				{					
					cases.push(new google.maps.LatLng(
							document.getElementById("pt_lat" + pt_ctr).value,
							document.getElementById("pt_lng" + pt_ctr).value
							));
				}
				pointArray = new google.maps.MVCArray();
				heatmap = new google.maps.visualization.HeatmapLayer({
					  data: cases
					});
					heatmap.setMap(map);
			}
			/** end of sample data**/

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

			/** end Map Nodes **/
			
			/** Polygon **/
			
			if (document.getElementById("polygon_nodes_result_length").value != 0)
			{
				var polygons = new Array();
				var polygon_coords = new Array();
				var pol_id_ctr = 0;
				
				for (var p_ctr = 0; p_ctr < document.getElementById("polygon_nodes_result_length").value; p_ctr++)
				{//alert(document.getElementById("pol_id" + p_ctr).value);
					if (pol_id_ctr == document.getElementById("pol_id" + p_ctr).value)
					{

						if(parseFloat(document.getElementById("pol_lng" + p_ctr).value) < x1)
						{x1=parseFloat(document.getElementById("pol_lng" + p_ctr).value);}
						if(parseFloat(document.getElementById("pol_lat" + p_ctr).value) < y1)
						{y1=parseFloat(document.getElementById("pol_lat" + p_ctr).value);}
						if(parseFloat(document.getElementById("pol_lng" + p_ctr).value) > x2)
						{x2=parseFloat(document.getElementById("pol_lng" + p_ctr).value);}
						if(parseFloat(document.getElementById("pol_lat" + p_ctr).value) > y2)
						{y2=parseFloat(document.getElementById("pol_lat" + p_ctr).value);}
						
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
						/** Centroid Marker Creation **/						
						new google.maps.Marker({
							position: new google.maps.LatLng(
								y1 + ((y2 - y1) * 0.5),
								x1 + ((x2 - x1) * 0.5)),
						map: map,
						icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+pol_id_ctr+'|FF0000|000000'  
						});
						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						/** end centroid marker creation **/
						
						pol_id_ctr++;
						polygons.push(polygon_coords);
						polygon_coords = [];
					}
				}
				/** Centroid Marker Creation **/						
				new google.maps.Marker({
					position: new google.maps.LatLng(
						y1 + ((y2 - y1) * 0.5),
						x1 + ((x2 - x1) * 0.5)),
				map: map,
				icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+pol_id_ctr+'|FF0000|000000'  
				});
				/** end centroid marker creation **/
				pol_id_ctr++;
				polygons.push(polygon_coords);
				polygon_coords = [];
				//alert(polygons[0]);
				//alert(pol_id_ctr);
				for (var ctr = 1; ctr < pol_id_ctr; ctr++)
				{//alert(polygons[ctr]);
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
	<?php }?> <input type="hidden" id="case_icon" value="<?php echo base_url('/images/arrow.png')?>" />
	<?php } else { ?> <input type="hidden" id="result_length" value="0" /> <?php } ?>
	
<!-- Dengue Risk Areas -->
	<?php if ($map_nodes != NULL){?>
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
	<?php } else { ?> <input type="hidden" id="map_nodes_result_length" value="0" /> <?php } ?>
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
	
<!-- Dengue Info -->
<input type="hidden" id="dengue_array_length" value="<?php echo count($dengue_array); ?>" />
	<?php for ($ctr = 0; $ctr < count($dengue_array); $ctr++) {?>
		<input type="hidden" id="polygon_ID<?= $ctr ?>"	value="<?php echo $dengue_array[$ctr]['polygon_ID']; ?>"		/>
		<input type="hidden" id="barangay<?= $ctr ?>" 	value="<?php echo $dengue_array[$ctr]['barangay']; ?>"		/>
		<input type="hidden" id="amount<?= $ctr ?>" 	value="<?php echo $dengue_array[$ctr]['amount']; ?>"		/>
		<input type="hidden" id="gendF<?= $ctr ?>" 		value="<?php echo $dengue_array[$ctr]['gendF']; ?>"		/>
		<input type="hidden" id="gendM<?= $ctr ?>" 		value="<?php echo $dengue_array[$ctr]['gendM']; ?>"		/>
		<input type="hidden" id="ageMin<?= $ctr ?>" 	value="<?php echo $dengue_array[$ctr]['ageMin']; ?>"		/>
		<input type="hidden" id="ageMax<?= $ctr ?>" 	value="<?php echo $dengue_array[$ctr]['ageMax']; ?>"		/>
		<input type="hidden" id="ageAve<?= $ctr ?>" 	value="<?php echo $dengue_array[$ctr]['ageAve']; ?>"		/>
		<input type="hidden" id="outA<?= $ctr ?>" 		value="<?php echo $dengue_array[$ctr]['outA']; ?>"		/>
		<input type="hidden" id="outD<?= $ctr ?>" 		value="<?php echo $dengue_array[$ctr]['outD']; ?>"		/>
		<input type="hidden" id="outU<?= $ctr ?>" 		value="<?php echo $dengue_array[$ctr]['outU']; ?>"		/>
	<?php } ?>
<!-- //end Dengue Info  -->
<body>
	<div id="container">
	<div id="header">
		<?php echo form_open(); ?>
		<?php echo form_fieldset();?>
		<table>
			<tr style="width:100%">
				<td style="width:33%;border: 1px solid red"> &nbsp; </td>
				<td style="width:33%;border: 1px solid red">
					Overlays <br/>
						<label style="color:red"><?php echo form_error('TPsex-dd'); ?></label>
						<?php echo form_checkbox('overlays[]', 'risk_areas',TRUE); ?> Dengue Risk Areas <br/>
						<?php echo form_checkbox('overlays[]', 'pidsr_cases',TRUE); ?> Dengue Cases (from PIDSR) <br/>
						<?php echo form_checkbox('overlays[]', 'plot_cases',TRUE); ?> Dengue Cases (as visited by BHWs) <br/>
						<?php echo form_submit('submit','Submit'); ?>
				</td>
				<td style="width:33%;border: 1px solid red;">
					<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/jDateQRangeSlider-min.js')?>"></script>
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
						$("#slider").bind("valuesChanged", function(e, data){
							var dateValues = $("#slider").dateRangeSlider("values");
							//alert("Values changed to "+dateValues.min.toString()+" and "+dateValues.max.toString()+"!");
							$('input[name=beginDate]').val(dateValues.min.getFullYear() + "-" + (dateValues.min.getMonth() + 1) + "-" + dateValues.min.getDate());
							$('input[name=endDate]').val(dateValues.max.getFullYear() + "-" + (dateValues.max.getMonth() + 1) + "-" + dateValues.max.getDate());
							$('input[name=risk_area_c]').val(document.getElementById("risk_areas").value);
							$('input[name=pidsr_c]').val(document.getElementById("pidsr_cases").value);
							$('input[name=plotted_c]').val(document.getElementById("plot_cases").value);
						});					
					</script>
					
				</td>
			</tr>
		</table>		
		<input type="hidden" id="beginDate" name="beginDate" value="<?php echo $begin_date;?>" />	
		<input type="hidden" id="endDate" name="endDate" value="<?php echo $end_date;?>" />	
		<input type="hidden" id="risk_area_c" name="risk_area_c" value="0" />	
		<input type="hidden" id="pidsr_c" name="pidsr_c" value="0" />	
		<input type="hidden" id="plotted_c" name="plotted_c" value="0" />
		<?php echo form_fieldset_close();?>
		<?php echo form_close(); ?>
	</div>
	
	<!-- Sidebar -->
	<div id="sidebar">
		<div id="sidebar-higher"></div>
		<div id="sidebar-lower">
			<div id="tabs">
				<ul>
					<li><a href="#tab_summary"> Summary </a></li>
					<li><a href="#tab_dengue"> Dengue</a></li>
					<li><a href="#tab_larva"> Larva</a></li>
				</ul>
				<div id="tab_summary">
					test1
				</div>
		<!-- Dengue Tab -->
			<!-- Age Info -->
			<input type="hidden" id="age_result_length" value="<?php echo count($ages_array); ?>" />
			<!-- //end Age Info  -->
			
			
				<div id="tab_dengue">
				<?php for($brgy_ctr = 0; $brgy_ctr < count($brgys); $brgy_ctr++) { ?>
				<?php echo $brgys[$brgy_ctr]['cr_barangay']; ?>
					<table border="1">
						<tr>
							<th> Age Range </th>
							<th> # </th>
							<th> % </th>
						</tr>
						<?php for ($ctr = 0; $ctr < count($ages_array); $ctr++) { ?>
							<?php if ($brgys[$brgy_ctr]['cr_barangay'] == $ages_array[$ctr]['cr_barangay']) {?>
						<tr>
							<td> <?php echo $ages_array[$ctr]['agerange']; ?> </td>
							<td> <?php echo $ages_array[$ctr]['patientcount']; ?> </td>
							<td> <?php echo $ages_array[$ctr]['cr_barangay']; ?> </td>
						</tr>
						<?php }} ?>
					</table>
				<?php } ?>
				</div>
		<!-- end Dengue Tab -->
				<div id="tab_larva">
					test4
				</div>
			</div>
		</div>
	</div>
	<!-- end Sidebar -->
	
	<!-- Map div -->
	<div id="googleMap"></div>
	<!-- //Map div -->
</div>
</body>
</html>