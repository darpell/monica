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

.table_div { border:1px solid gray; }
.brgy_summary { clear:both; }
.brgy_stats { float:left; }
.age_values { float:left; }

.holder { padding: 3px; }
td.bottom { vertical-align:bottom; }

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
	
	var infoWindow = new google.maps.InfoWindow();
	infoWindow.setOptions({maxWidth:400});
	
	function setInfo(fMarker,fInfo,fMap) {
		google.maps.event.addListener(fMarker, 'click', function() {
			infoWindow.setOptions({content:fInfo});
			infoWindow.open(fMap, this);
		});
	}
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
				var image;
				for (var ctr = 0; ctr < document.getElementById("map_nodes_result_length").value; ctr++)
				{
					var nd_type="Risk Area";
					if(document.getElementById("nd_type" + ctr).value==0)
					{
						image = document.getElementById("nodeSource_icon").value;
						nd_type="Source Area";
					}
					else
					{
						image = document.getElementById("nodeRisk_icon").value;
					}
					var node_marker = new google.maps.Marker({
											position: new google.maps.LatLng(
											document.getElementById("nd_lat" + ctr).value,
											document.getElementById("nd_lng" + ctr).value		
										),
										map: map,
										icon: image
							});

					/*
					var node_marker_info = new google.maps.InfoWindow({
								content: 'test'
							});//*/

					/*
					google.maps.event.addListener(node_marker, 'click', function() {
						node_marker_info.open(map,node_marker);
						});//*/
					
					/*
					oms.addListener('click', function(node_marker) {
							node_marker_info.open(map, node_marker);
						});//*/
							
					var info=
						"<b>"+document.getElementById("nd_name" + ctr).value+"</b>"+"<br/>"+
						document.getElementById("nd_barangay" + ctr).value+"<br/>"+
						nd_type+"<br/>"+"<br/>"+"Location Notes:<br/>"+
						document.getElementById("nd_notes" + ctr).value+"<br/>"+"<br/>";
					setInfo(node_marker,info,map);
					oms.addMarker(node_marker);
					markers.push(node_marker);
				}
			}

			/** end Map Nodes **/
			
			/** Investigated Cases **/
			
			if (document.getElementById("ic_length").value != 0)
			{//alert("0");
				for (var pt_ctr = 0; pt_ctr < document.getElementById("ic_length").value; pt_ctr++) 
				{	
					point=new google.maps.LatLng(
							document.getElementById("ic_lat" + pt_ctr).value,
							document.getElementById("ic_lng" + pt_ctr).value
							);
					circle = new google.maps.Circle({
						center:point,
						radius:200,
						strokeColor:"#0000FF",
						strokeOpacity:0.7,
						strokeWeight:1,
						fillColor:"#0000FF",
						fillOpacity:0.05,
						clickable:false
					}); 
					caseMarker=new google.maps.Marker({
						  position:point ,
						  map: map
						});
					
					var s="Female";
					var o="Unconfirmed";
					if((""+document.getElementById("ic_sex" + pt_ctr).value)=="M")
					{
						s="Male";
					}
					if((""+document.getElementById("ic_sex" + pt_ctr).value)=="A")
					{
						o="Alive";
					}
					else if ((""+document.getElementById("ic_sex" + pt_ctr).value)=="D")
					{
						o="Deceased";
					}
					info="<b>"+document.getElementById("ic_lname" + pt_ctr).value+", "+document.getElementById("ic_fname" + pt_ctr).value+"</b>"+"<br/>"
					+document.getElementById("ic_barangay" + pt_ctr).value+", "+document.getElementById("ic_street" + pt_ctr).value+"<br/>"+"<br/>"
					+"Onset: "+document.getElementById("ic_dateOnset" + pt_ctr).value+"<br/>"
					+"Age: "+document.getElementById("ic_age" + pt_ctr).value+"<br/>"
					+"Gender: "+s+"<br/>"
					+"Outcome: "+o+"<br/>"+"<br/>"
					+"Feedback: "+document.getElementById("ic_outcome" + pt_ctr).value+"<br/>";
					setInfo(caseMarker,info,map);
					if(document.getElementById("ic_bounce" + pt_ctr).value==1)
					{
						caseMarker.setAnimation(google.maps.Animation.BOUNCE);
						circle.setMap(map);
					}
					oms.addMarker(caseMarker);
				}
			}

			/** end Investigated Cases **/
			
			/** Polygon **/
			
			if (document.getElementById("polygon_nodes_result_length").value != 0)
			{
				var polygons = new Array();
				var polygon_coords = new Array();
				var pol_id_ctr = 0;
				var image = document.getElementById("centroid_icon").value;	
				var info = "";
				var currPoly="";
				var ip_ctr;
				
				for (var p_ctr = 0; p_ctr < document.getElementById("polygon_nodes_result_length").value; p_ctr++)
				{//alert(document.getElementById("pol_id" + p_ctr).value);
					if (pol_id_ctr == document.getElementById("pol_id" + p_ctr).value)
					{
						currPoly=document.getElementById("pol_name" + p_ctr).value;
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
						centroid=new google.maps.Marker({
							position: new google.maps.LatLng(
								y1 + ((y2 - y1) * 0.5),
								x1 + ((x2 - x1) * 0.5)),
						map: map,
						icon: image
						});oms.addMarker(centroid);
						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						/** end centroid marker creation **/
						//*
						for(var i_ctr=0; i_ctr < document.getElementById("larval_array_length").value;i_ctr++)
						{
							if(document.getElementById("l_barangay"+i_ctr).value==currPoly)
							{
								info=
									"<b>"+document.getElementById("l_barangay"+i_ctr).value+"</b>"+"<br/>"+
									"<i>"+document.getElementById("amount"+i_ctr).value+" Dengue Cases</i>"+"<br/>"+
									"<i>"+document.getElementById("l_count"+i_ctr).value+" Larval Positives</i>"+"<br/>";
							}
						}
						//alert(pol_id_ctr);
						//info=""+document.getElementById("barangay" + pol_id_ctr).value;
						setInfo(centroid,info,map);//*/
						
						pol_id_ctr++;
						polygons.push(polygon_coords);
						polygon_coords = [];
					}
					ip_ctr=p_ctr;
				}
				/** Centroid Marker Creation **/	
				currPoly=document.getElementById("pol_name" + ip_ctr).value;				
				centroid=new google.maps.Marker({
					position: new google.maps.LatLng(
						y1 + ((y2 - y1) * 0.5),
						x1 + ((x2 - x1) * 0.5)),
				map: map,
				icon: image
				});oms.addMarker(centroid);
				/** end centroid marker creation **/
				//*
				for(var i_ctr=0; i_ctr < document.getElementById("larval_array_length").value;i_ctr++)
				{
					if(document.getElementById("l_barangay"+i_ctr).value==currPoly)
					{
						info=
							"<b>"+document.getElementById("l_barangay"+i_ctr).value+"</b>"+"<br/>"+
							"<i>"+document.getElementById("amount"+i_ctr).value+" Dengue Cases</i>"+"<br/>"+
							"<i>"+document.getElementById("l_count"+i_ctr).value+" Larval Positives</i>"+"<br/>";
					}
				}
				//alert(pol_id_ctr);
				//info=""+document.getElementById("barangay" + pol_id_ctr).value;
				setInfo(centroid,info,map);//*/
						
				pol_id_ctr++;
				polygons.push(polygon_coords);
				polygon_coords = [];
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
	
	<input type="hidden" id="centroid_icon" value="<?php echo base_url('/images/information.png')?>" />
	
	<?php if ($larvalPositives != NULL){?>
<input type="hidden" id="result_length" value="<?php echo count($larvalPositives); ?>" />
	<?php for ($ctr = 0; $ctr < count($larvalPositives); $ctr++) {?>
		<input type="hidden" id="pt_barangay<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_barangay']; ?>"	/>
		<input type="hidden" id="pt_street<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_street']; ?>"	/>
		<input type="hidden" id="pt_municipality<?= $ctr ?>"	value="<?php echo $larvalPositives[$ctr]['ls_municipality']; ?>"	/>
		<input type="hidden" id="pt_lat<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_lat']; ?>"			/>
		<input type="hidden" id="pt_lng<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_lng']; ?>"			/>
		<input type="hidden" id="pt_household<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_household']; ?>"	/>
		<input type="hidden" id="pt_result<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_result']; ?>"		/>
		<input type="hidden" id="pt_created_on<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['created_on']; ?>"		/>
		<input type="hidden" id="pt_container<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_container']; ?>"	/>
		<input type="hidden" id="pt_tracking_no<?= $ctr ?>" 	value="<?php echo $larvalPositives[$ctr]['tracking_number']; ?>"	/>
		<input type="hidden" id="pt_ref_no<?= $ctr ?>" 	value="<?php echo $larvalPositives[$ctr]['ls_no']; ?>"	/>
	<?php }?> 
	<input type="hidden" id="case_icon" value="<?php echo base_url('/images/arrow.png')?>" />
	<?php } else { ?> <input type="hidden" id="result_length" value="0" /> <?php } ?>
		
<!-- Investigated Cases -->	
	<?php if ($data_exists === true){$ctr=0;?>
<input type="hidden" id="ic_length" value="<?php echo count($dataCases); ?>" />
	<?php foreach ($dataCases as $value) {?>
		<input type="hidden" id="ic_lat<?= $ctr ?>" 		value="<?php echo $value['ic_lat']; ?>"	/>
		<input type="hidden" id="ic_lng<?= $ctr ?>" 		value="<?php echo $value['ic_lng']; ?>"	/>
		<input type="hidden" id="ic_feedback<?= $ctr ?>" 		value="<?php echo $value['ic_feedback']; ?>"	/>
		<input type="hidden" id="ic_fname<?= $ctr ?>" 		value="<?php echo $value['ic_fname']; ?>"	/>
		<input type="hidden" id="ic_lname<?= $ctr ?>" 		value="<?php echo $value['ic_lname']; ?>"	/>
		<input type="hidden" id="ic_dateOnset<?= $ctr ?>" 		value="<?php echo $value['ic_dateOnset']; ?>"	/>
		<input type="hidden" id="ic_age<?= $ctr ?>" 		value="<?php echo $value['ic_age']; ?>"	/>
		<input type="hidden" id="ic_sex<?= $ctr ?>" 		value="<?php echo $value['ic_sex']; ?>"	/>
		<input type="hidden" id="ic_barangay<?= $ctr ?>" 		value="<?php echo $value['ic_barangay']; ?>"	/>
		<input type="hidden" id="ic_street<?= $ctr ?>" 		value="<?php echo $value['ic_street']; ?>"	/>
		<input type="hidden" id="ic_outcome<?= $ctr ?>" 		value="<?php echo $value['ic_outcome']; ?>"	/>
		<input type="hidden" id="ic_bounce<?= $ctr ?>" 		value="<?php echo $value['0']; ?>"	/>
	<?php $ctr++;}?> 
	<?php } else { ?> <input type="hidden" id="ic_length" value="0" /> <?php } ?>
	
<!-- Dengue Risk Areas -->
	<?php if ($pointsOfInterest != NULL){?>
<input type="hidden" id="map_nodes_result_length" value="<?php echo count($pointsOfInterest); ?>" />
	<?php for ($ctr = 0; $ctr < count($pointsOfInterest); $ctr++) {?>
		<input type="hidden" id="nd_no<?= $ctr ?>" 		value="<?php echo $pointsOfInterest[$ctr]['node_no']; ?>"	/>
		<input type="hidden" id="nd_name<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['node_name']; ?>"	/>
		<input type="hidden" id="nd_city<?= $ctr ?>"	value="<?php echo $pointsOfInterest[$ctr]['node_city']; ?>"	/>
		<input type="hidden" id="nd_lat<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['node_lat']; ?>"			/>
		<input type="hidden" id="nd_lng<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['node_lng']; ?>"			/>
		<input type="hidden" id="nd_type<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['node_type']; ?>"	/>
		<input type="hidden" id="nd_barangay<?= $ctr ?>" value="<?php echo $pointsOfInterest[$ctr]['node_barangay']; ?>"		/>
		<input type="hidden" id="nd_addedOn<?= $ctr ?>"	value="<?php echo $pointsOfInterest[$ctr]['node_addedOn']; ?>"		/>
		<input type="hidden" id="nd_notes<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['node_notes']; ?>"	/>
	<?php } ?>
		<input type="hidden" id="nodeSource_icon" value="<?php echo base_url('/images/eggs.png')?>" />
		<input type="hidden" id="nodeRisk_icon" value="<?php echo base_url('/images/group.png')?>" />
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
	
	<!-- PoI Distance Results
<input type="hidden" id="PoI_nodes_result_length" value="<?php //echo count($PoI_distance_array); ?>" />
	<?php //for ($ctr = 0; $ctr < count($PoI_distance_array); $ctr++) {?>
		<input type="hidden" id="PoI_name<?php //$ctr ?>" 	value="<?php //echo $PoI_distance_array[$ctr]['name']; ?>"		/>
		<input type="hidden" id="PoI_type<?php //$ctr ?>" 	value="<?php //echo $PoI_distance_array[$ctr]['type']; ?>"		/>
		<input type="hidden" id="PoI_amount<?php //$ctr ?>" 	value="<?php //echo $PoI_distance_array[$ctr]['amount']; ?>"		/>
		<input type="hidden" id="PoI_percent<?php //$ctr ?>" 	value="<?php //echo $PoI_distance_array[$ctr]['percent']; ?>"		/>
	<?php //} ?>
<!-- //end PoI Distance Results -->
	
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
						<?php echo form_checkbox('overlays[]', 'interest_points',TRUE); ?> Points of Interest<!-- Dengue Risk Areas --><br/> 
						<?php echo form_checkbox('overlays[]', 'larvalPositive_points',TRUE); ?> Larval Positives<!-- Dengue Cases (from PIDSR) --><br/> 
						<?php echo form_checkbox('overlays[]', 'investigatedCases_points',TRUE); ?> Investigated Dengue Cases<!-- Dengue Cases (as visited by BHWs) --><br/> 
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
			<!-- Summary Tab -->
				<div id="tab_summary">
					<table>
					<tr>
						<td>
							<h3>Legend</h3>
						</td>
					</tr>
					<tr>
						<td><img border="0" src="<?php echo base_url('/images/notice.png'); ?>"></td>
						<td>Point of interest. Possible source of Mosquitoes.</td>
					</tr>	
					<tr>
						<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=4|ff776b"></td>
						<td>Barangay marker, number is the amount of dengue cases for the period. Commonly located at the center of the barangay boundary. For irregularly shaped barangays, the location may vary.</td>
					</tr>
					</table>
				</div>
			<!--  end Summary Tab -->
				
		<!-- Dengue Tab -->
			<!-- Age Info -->
			<input type="hidden" id="age_result_length" value="<?php echo count($ages_array); ?>" />
			<!-- //end Age Info  -->
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
	<!-- Larval Info -->
		<input type="hidden" id="larval_array_length" value="<?php echo count($larval_array); ?>" />
	<?php for ($ctr = 0; $ctr < count($larval_array); $ctr++) {?>
		<input type="hidden" id="l_barangay<?= $ctr ?>" 	value="<?php echo $larval_array[$ctr]['ls_barangay']; ?>"		/>
		<input type="hidden" id="l_count<?= $ctr ?>" 	value="<?php echo $larval_array[$ctr]['count']; ?>"		/>
	<?php } ?>
<!-- //end Larval Info  -->
			
				<div id="tab_dengue">
					
					<div class="table_div">
						<table class="holder">
							<tr>
								<td>
									<?php //for($brgy_ctr = 0; $brgy_ctr < count($brgys); $brgy_ctr++) { 
										for ($brgy_ctr = 0; $brgy_ctr < count($dengue_array); $brgy_ctr++) {
									?>
										<div class="brgy_summary">
											<?php echo $dengue_array[$brgy_ctr]['barangay']; ?>
											<table style="margin:5px">
												<tr>
													<td> <?php echo $dengue_array[$brgy_ctr]['amount']; ?> Cases </td>
												</tr>
												<tr>
													<td> Y% Total, Z% decrease </td>
												</tr>
												<tr>
													<td> (Previously UU Cases, V% )</td>
												</tr>
											</table>
										</div>
								</td>
								<td class="bottom" rowspan="2">
										<div class="age_values"> 
											<table border="1" style="margin:5px">
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
										</div>
								</td>
							<tr>
								<td>
										<div class="brgy_stats">
											<table style="margin:5px">
												<tr>
													<td> Min Age </td>
													<td> <?php echo $dengue_array[$brgy_ctr]['ageMin']; ?> </td>
												</tr>
												<tr>
													<td> Max Age </td>
													<td> <?php echo $dengue_array[$brgy_ctr]['ageMax']; ?> </td>
												</tr>
												<tr>
													<td> Male:Female Ratio </td>
													<td> <?php echo $dengue_array[$brgy_ctr]['gendM']; ?>:<?php echo $dengue_array[$brgy_ctr]['gendF']; ?> </td>
												</tr>
												<tr>
													<td> Average </td>
													<td> <?php echo $dengue_array[$brgy_ctr]['ageAve']; ?> </td>
												</tr>
												<tr>
													<td> Median </td>
													<td> &nbsp; </td>
												</tr>
												<tr>
													<td> Lowest </td>
													<td> &nbsp; </td>
												</tr>
												<tr>
													<td> Highest </td>
													<td> &nbsp; </td>
												</tr>
											</table>
										</div>
								</td>
							</tr>
						</table>
										
										<?php } ?>
				
									</div>
					
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