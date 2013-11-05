<!-- HEADER -->
<?php $this->load->view('templates/header');?>

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
<style>
html { height:100% }
body { height:100%;margin:0;padding:0 }

#googleMap { width:55%; height:90%; margin: 10px; float:left;}
</style>

<script>
$(function() {
	var hv = $('#selected').val();
	hv =  parseInt(hv);

$( "#accordion" ).accordion({active : hv});
$( "#accordion2" ).accordion();
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
				zoom: 14,
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
			var cimage = document.getElementById("nodeCase_icon").value;

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
					else if(document.getElementById("nd_bounce" + ctr).value==1)
					{
						image = document.getElementById("nodeRisk2_icon").value;
					}
					else
						image = document.getElementById("nodeRisk_icon").value;
					point = new google.maps.LatLng(
							document.getElementById("nd_lat" + ctr).value,
							document.getElementById("nd_lng" + ctr).value);
					var node_marker = new google.maps.Marker({
										position: point,
										map: map,
										icon: image
							});
							
					var info=
						"<b>"+document.getElementById("nd_name" + ctr).value+"</b>"+"<br/>"+
						document.getElementById("nd_barangay" + ctr).value+"<br/>"+
						nd_type+"<br/>"+"<br/>"+"Location Notes:<br/>"+
						document.getElementById("nd_notes" + ctr).value+"<br/>"+"<br/>";
					setInfo(node_marker,info,map);
					oms.addMarker(node_marker);
					markers.push(node_marker);
					//*
					if(document.getElementById("nd_bounce" + ctr).value==1)
					{
						new google.maps.Circle({
							center:point,
							radius:200,
							strokeColor:"#0000FF",
							strokeOpacity:0.7,
							strokeWeight:1,
							fillColor:"#0000FF",
							fillOpacity:0.05,
							clickable:false
						}).setMap(map); 
						//circle;
						if(document.getElementById("nd_type" + ctr).value==0)
							node_marker.setAnimation(google.maps.Animation.BOUNCE);
					}//*/
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
					caseMarker=new google.maps.Marker({
						  position:point ,
						  map: map,
						  icon: cimage
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
					setInfo(caseMarker,info,map);/*
					if(document.getElementById("ic_bounce" + pt_ctr).value==1)
					{
						caseMarker.setAnimation(google.maps.Animation.BOUNCE);
						circle.setMap(map);
					}//*/
					oms.addMarker(caseMarker);
				}
			}

			/** end Investigated Cases **/
			
			
			/** Immediate Cases **/
			
			if (document.getElementById("mc_length").value != 0)
			{//alert("0");
				for (var pt_ctr = 0; pt_ctr < document.getElementById("mc_length").value; pt_ctr++) 
				{	
					var symptoms=0;
					if (document.getElementById("mc_hasmusclepain"+pt_ctr).value == "Y")
						symptoms++;
					if (document.getElementById("mc_hasjointpain"+pt_ctr).value == "Y")
						symptoms++;
					if (document.getElementById("mc_hasheadache"+pt_ctr).value == "Y")
						symptoms++;
					if (document.getElementById("mc_hasbleeding"+pt_ctr).value == "Y")
						symptoms++;
					if (document.getElementById("mc_hasrashes"+pt_ctr).value == "Y")
						symptoms++;
					
					var img=null;

					if(parseInt(document.getElementById("mc_daysfever"+pt_ctr).value) < 3 && parseInt(document.getElementById("mc_daysfever"+pt_ctr).value) > 0 && symptoms == 0)
					{
						img=document.getElementById("notice1_icon").value; 
					} 
					
					else if(parseInt(document.getElementById("mc_daysfever"+pt_ctr).value) < 3 && parseInt(document.getElementById("mc_daysfever"+pt_ctr).value) > 0 && symptoms == 1)
					{
						img=document.getElementById("notice2_icon").value; 
					}
					else //if(document.getElementById("mc_daysfever"+pt_ctr).value > 2 && symptoms > 2 )
					{
						img=document.getElementById("notice3_icon").value; 
					}
					
					point=new google.maps.LatLng(
							document.getElementById("mc_lat" + pt_ctr).value,
							document.getElementById("mc_lng" + pt_ctr).value
							);
					caseMarker=new google.maps.Marker({
						  position:point ,
						  map: map,
						  icon: img
						});
					
					var info="<b><i>"+document.getElementById("mc_status" + pt_ctr).value+"</i></b><br/>"
					+"<b>"+document.getElementById("mc_householdname" + pt_ctr).value+", "+document.getElementById("mc_houseno" + pt_ctr).value+"</b><br/>"
					+"<b>"+document.getElementById("mc_bgy" + pt_ctr).value+"</b><br/>"
					+"Fever: "+document.getElementById("mc_daysfever" + pt_ctr).value+" days<br/>"
					+"Joint Pain: "+document.getElementById("mc_hasjointpain" + pt_ctr).value+"<br/>"
					+"Headache: "+document.getElementById("mc_hasheadache" + pt_ctr).value+"<br/>"
					+"Bleeding: "+document.getElementById("mc_hasbleeding" + pt_ctr).value+"<br/>"
					+"Rashes: "+document.getElementById("mc_hasrashes" + pt_ctr).value+"<br/><br/>"
					+"BHW in-charge: "+document.getElementById("mc_bhwid" + pt_ctr).value+"<br/>"
					+"Detected on: "+document.getElementById("mc_createdon" + pt_ctr).value+"<br/>"
					+"Last Visit: "+document.getElementById("mc_lastvisited" + pt_ctr).value+"<br/><br/>"
					+"Suspected Source: "+document.getElementById("mc_suspectedsource" + pt_ctr).value+"<br/>"
					+"Remarks: "+document.getElementById("mc_remarks" + pt_ctr).value+"<br/>";
					setInfo(caseMarker,info,map);
					oms.addMarker(caseMarker);
					
				}
			}
			
			/** end Immediate Cases **/
			
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


 

 <body>
 <div id="tabs">
				<ul>
					<li><a href="#tabs-5">Dengue Map</a></li>
					<li><a href="#tabs-6">Alerts(<?php echo count($notif);?>)</a></li>
					<li><a href="#tabs-1">Master List </a></li>
					<li><a href="#tabs-2">Immediate Cases</a></li>
					<li><a href="#tabs-8">Hospitalized Residents</a></li>
					<li><a href="#tabs-4">Uninvestigated Cases</a></li>
					<li><a href="#tabs-3">Barangay Health Worker</a></li>
					<li><a href="#tabs-7">Barangay Cleanup</a></li>
						
				</ul>
<div  id="tabs-5">
	<div id="googleMap" style="width:20%; height:80%; margin: 10px; float:left;" >
	</div>
	<input type="hidden" id="centroid_icon" value="<?php echo base_url('/images/information.png')?>" />
	
	<?php if ($larvalPositives != NULL){?>
<input type="hidden" id="result_length" value="<?php echo count($larvalPositives); ?>" />
	<?php for ($ctr = 0; $ctr < count($larvalPositives); $ctr++) {?>
		<input type="hidden" id="pt_barangay<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_barangay']; ?>"	/>
			<input type="hidden" id="pt_lat<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_lat']; ?>"			/>
		<input type="hidden" id="pt_lng<?= $ctr ?>" 			value="<?php echo $larvalPositives[$ctr]['ls_lng']; ?>"			/>
		<input type="hidden" id="pt_household<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_household']; ?>"	/>
		<input type="hidden" id="pt_created_on<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['created_on']; ?>"		/>
		<input type="hidden" id="pt_container<?= $ctr ?>" 		value="<?php echo $larvalPositives[$ctr]['ls_container']; ?>"	/>
		<input type="hidden" id="pt_tracking_no<?= $ctr ?>" 	value="<?php echo $larvalPositives[$ctr]['tracking_number']; ?>"	/>
		<input type="hidden" id="pt_ref_no<?= $ctr ?>" 	value="<?php echo $larvalPositives[$ctr]['ls_no']; ?>"	/>
	<?php }?> 
	<input type="hidden" id="case_icon" value="<?php echo base_url('/images/arrow.png')?>" />
		<input type="hidden" id="notice1_icon" value="<?php echo base_url('/images/notice.png')?>" />
		<input type="hidden" id="notice2_icon" value="<?php echo base_url('/images/notice2.png')?>" />
		<input type="hidden" id="notice3_icon" value="<?php echo base_url('/images/notice3.png')?>" />
	<!-- Polygon Nodes -->
	<?php } else { ?> <input type="hidden" id="result_length" value="0" /> <?php } ?>
		
<!-- Investigated Cases -->	
	<?php
	$casectr = 0;
	 if ($data_exists === true){$ctr=0;?>
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
	<?php $ctr++;
		$casectr++;}?> 
	<?php } else { ?> <input type="hidden" id="ic_length" value="0" /> <?php } ?>
	
	
			
<!-- Immediate Cases -->	
	<?php if ($data_exists2 === true){$ctr=0;?>
<input type="hidden" id="mc_length" value="<?php echo count($dataImmediateCases); ?>" />
	<?php foreach ($dataImmediateCases as $value) {?>
		<input type="hidden" id="mc_hasmusclepain<?= $ctr ?>" 		value="<?php echo $value['has_muscle_pain']; ?>"	/>
		<input type="hidden" id="mc_hasjointpain<?= $ctr ?>" 		value="<?php echo $value['has_joint_pain']; ?>"	/>
		<input type="hidden" id="mc_hasheadache<?= $ctr ?>" 		value="<?php echo $value['has_headache']; ?>"	/>
		<input type="hidden" id="mc_hasbleeding<?= $ctr ?>" 		value="<?php echo $value['has_bleeding']; ?>"	/>
		<input type="hidden" id="mc_hasrashes<?= $ctr ?>" 		value="<?php echo $value['has_rashes']; ?>"	/>
		<input type="hidden" id="mc_daysfever<?= $ctr ?>" 		value="<?php echo $value['days_fever']; ?>"	/>
		<input type="hidden" id="mc_createdon<?= $ctr ?>" 		value="<?php echo $value['created_on']; ?>"	/>
		<input type="hidden" id="mc_lastupdatedon<?= $ctr ?>" 		value="<?php echo $value['last_updated_on']; ?>"	/>
		<input type="hidden" id="mc_suspectedsource<?= $ctr ?>" 		value="<?php echo $value['suspected_source']; ?>"	/>
		<input type="hidden" id="mc_remarks<?= $ctr ?>" 		value="<?php echo $value['remarks']; ?>"	/>
		<input type="hidden" id="mc_lat<?= $ctr ?>" 		value="<?php echo $value['node_lat']; ?>"	/>
		<input type="hidden" id="mc_lng<?= $ctr ?>" 		value="<?php echo $value['node_lng']; ?>"	/>
		<input type="hidden" id="mc_status<?= $ctr ?>" 		value="<?php echo $value['status']; ?>"	/>
		<input type="hidden" id="mc_householdid<?= $ctr ?>" 		value="<?php echo $value['household_id']; ?>"	/>
		<input type="hidden" id="mc_personid<?= $ctr ?>" 		value="<?php echo $value['person_id']; ?>"	/>
		<input type="hidden" id="mc_bhwid<?= $ctr ?>" 		value="<?php echo $value['bhw_id']; ?>"	/>
		<input type="hidden" id="mc_householdname<?= $ctr ?>" 		value="<?php echo $value['household_name']; ?>"	/>
		<input type="hidden" id="mc_houseno<?= $ctr ?>" 		value="<?php echo $value['house_no']; ?>"	/>
		<input type="hidden" id="mc_bgy<?= $ctr ?>" 		value="<?php echo $value['barangay']; ?>"	/>
		<input type="hidden" id="mc_lastvisited<?= $ctr ?>" 		value="<?php echo $value['last_visited']; ?>"	/>
	<?php $ctr++;
		$casectr++;}?> 
	<?php } else { ?> <input type="hidden" id="mc_length" value="0" /> <?php } ?>
	
	
	
<!-- Dengue Risk Areas -->
	<?php
	$bouncectr= 0;
	$nonbouncectr= 0;
	$riskareactr= 0;
	$redriskareactr= 0;
	 if ($pointsOfInterest != NULL){?>
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
		<input type="hidden" id="nd_bounce<?= $ctr ?>" 	value="<?php echo $pointsOfInterest[$ctr]['bounce']; ?>"	/>
	<?php 
		if($pointsOfInterest[$ctr]['bounce'] != 0 && $pointsOfInterest[$ctr]['node_type'] ==0)
		$bouncectr++;
		else if($pointsOfInterest[$ctr]['bounce'] != 0 && $pointsOfInterest[$ctr]['node_type'] ==1)
		$redriskareactr++;
		else if($pointsOfInterest[$ctr]['bounce'] == 0 && $pointsOfInterest[$ctr]['node_type'] ==0)
		$nonbouncectr++;
		else if($pointsOfInterest[$ctr]['bounce'] == 0 && $pointsOfInterest[$ctr]['node_type'] ==1)
		$riskareactr++;
		} ?>
		<input type="hidden" id="nodeSource_icon" value="<?php echo base_url('/images/eggs.png')?>" />
		<input type="hidden" id="nodeRisk_icon" value="<?php echo base_url('/images/group.png')?>" />
		<input type="hidden" id="nodeRisk2_icon" value="<?php echo base_url('/images/group-2.png')?>" />
	<?php } else { ?> <input type="hidden" id="map_nodes_result_length" value="0" /> <?php } ?>
<!-- //end Dengue Risk Areas -->
		<input type="hidden" id="nodeCase_icon" value="<?php echo base_url('/images/mosquito.png')?>" />
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
			<input type="hidden" id="beginDate" name="beginDate" value="<?php echo $begin_date;?>" />	
		<input type="hidden" id="endDate" name="endDate" value="<?php echo $end_date;?>" />	
		<input type="hidden" id="risk_area_c" name="risk_area_c" value="0" />	
		<input type="hidden" id="pidsr_c" name="pidsr_c" value="0" />	
		<input type="hidden" id="plotted_c" name="plotted_c" value="0" />
		
					
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
	<?php $tmpl = array (
						'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" float:right; >',
					    'heading_row_start'   => '<tr>',
					    'heading_row_end'     => '</tr>',
					    'heading_cell_start'  => '<th id="result" scope="col">',
					    'heading_cell_end'    => '</th>',
					    'row_start'           => '<tr>',
					    'row_end'             => '</tr>',
					    'cell_start'          => '<td align="center">',
					    'cell_end'            => '</td>',
					    'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
					    'row_alt_end'         => '</tr>',
					    'cell_alt_start'      => '<td align="center">',
					    'cell_alt_end'        => '</td>',
					    'table_close'         => '</table>'
					   );
		//echo "<br/><center><b>Possible Source Areas</b><br/>";
		//echo $this->table->generate($sourceTable);
		//echo "<br/><center><b>Possible Risk Areas</b><br/>";
		//echo $this->table->generate($riskTable);?>
 <fieldset style="width: 50%;">
  <legend>Legend</legend>
  <table>
  <tr>
 <td> <?php echo $nonbouncectr;?></td> <td> <img src="<?php echo base_url('/images/eggs.png')?>" alt="Smiley face" height="42" width="42"></td> <td>  Breeding Area For Mosquitos</td> <br />
 </tr>
 <tr>
 <td>  <?php echo $bouncectr;?></td> <td> <img src="<?php echo base_url('/images/eggs.png')?>" alt="Smiley face" height="42" width="42"></td> <td> (Bouncing)Positive For Larva<?php if ($bouncectr > 0){?><img src="<?php echo base_url('/images/notice.png')?>" alt="Smiley face" height="22" width="22"><br /><?php }?></td> <br />
  </tr>
 <tr>
 <td> <?php echo $riskareactr;?></td> <td>  <img src="<?php echo base_url('/images/group.png')?>" alt="Smiley face" height="42" width="42"></td> <td> Area At Risk For Dengue</td> <br />
   </tr>
 <tr>
 <td>  <?php echo $redriskareactr;?></td> <td> <img src="<?php echo base_url('/images/group-2.png')?>" alt="Smiley face" height="42" width="42"></td> <td> Nearby Active Breeding Ground<?php if ($redriskareactr > 0){?><img src="<?php echo base_url('/images/notice.png')?>" alt="Smiley face" height="22" width="22"><br /><?php }?><br />
  </tr>
 <tr>
 <td> <?php echo $casectr;?></td> <td>  <img src="<?php echo base_url('/images/Mosquito.png')?>" alt="Smiley face" height="42" width="42">
  <img src="<?php echo base_url('/images/notice.png')?>" alt="Smiley face" height="42" width="42"> 
  <img src="<?php echo base_url('/images/notice2.png')?>" alt="Smiley face" height="42" width="42"> 
  <img src="<?php echo base_url('/images/notice3.png')?>" alt="Smiley face" height="42" width="42"></td> <td> Dengue and Immediate Case</td> 
   </tr>
 
  </table>
  </fieldset>		
		<?php 		
if($cases != null){
?>

<table border="1" cellpadding="0" cellspacing="0" id="results" style="width: 20%; "  >
<tr>
<td><b>Severity</b></td>
<td><b>Name</b></td>
<td><b>Address</b></td>
<td><b>Contact Nos.</b></td>
<td><b>Age</b></td>
<td><b>Days Of Fever</b></td>
<td><b>Muscle Pain</b></td>
<td><b>Joint Pain</b></td>
<td><b>Head Ache</b></td>
<td><b>Bleeding</b></td>
<td><b>Rashes</b></td>
<td><b>Date Onset</b></td>
<td><b>Remarks</b></td>
</tr>

<?php 
foreach($cases as $value)
{
	
	
	echo '<tr>';
	if($value['Bleeding'] == 'Y' || $value['Rashes'] == 'Y' || $value['Status'] == 'serious')
		echo "<td bgcolor='#FF0000'><b>Serious<b></b></td>";
	else if($value['Status'] == "threatening")
		echo "<td bgcolor='#FF8000'><b>".$value['Status']."<b></td>";
	else if($value['Status'] == "supected")
		echo "<td bgcolor='#FFFF00'><b>".$value['Status']."<b></td>";
	else //if($value['Status'] == "finished")
		echo "<td bgcolor='#00FF00'><b>".$value['Status']."<b></td>";
	echo '
		<td>'.$value['Name'].'</td>
		<td>'.$value['Address'].'</td>
		<td>'.$value['Contact Nos'].'</td>
		<td>'.$value['Age'].'</td>
		<td>'.$value['Days Of Fever'].'</td>
		<td>'.$value['Muscle Pain'].'</td>
		<td>'.$value['Joint Pain'].'</td>
		<td>'.$value['Head Ache'].'</td>
		<td>'.$value['Bleeding'].'</td>
		<td>'.$value['Rashes'].'</td>
		<td>'.$value['Date Onset'].'</td>
		<td>'.$value['Remarks'].'</td>
		';

	
	echo '</tr>';
}
}
else 
	echo '<b>No new cases has been reported.</b>';
	
	?>
</table>

</div>

<div id="tabs-6">
<?php 
$this->table->set_heading(
		array(	' ',
				'Alert',
				'Date',
				' '
		));
echo $this->table->generate($notif);?>

</div>
<div  id="tabs-1">
 <center>
 <h2>Masterlist</h2>
 </center>
 <br>
 <br>
<div id="accordion">
<?php 
$ctr =0 ;
foreach($households as $row)
{
echo '<h3>'.$row['house_no'].' '.$row['street'].' - '. $row['household_name'] .'</h3>';
if($selected ==$row['household_id'] )
echo '<div data-options="selected:true" >';
else
echo '<div data-options="selected:true" >';

$this->table->set_heading(
		array(	'Name',
				'Birthday',
				'Contact Nos.',
				'Gender',
				'Marital Status',
				'Nationality',
				'Blood Type',
				'options',
		));
echo $this->table->generate($masterlist[$row['household_id']]);
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/add_masterlist_midwife',$attributes); 

?>

<input type="hidden" name="house_id" id="house_id" value="<?php echo $row['household_id']; ?>" />
<input type="hidden" name="ctr<?php echo $row['household_id']; ?>" id="ctr" value="<?php echo $ctr ?>" />

 <table    align="center" cellpadding="5" style="width: 100%;">
  <tr>
  <td colspan = "7">
  <center><b>Add member</b></center>

  </td>
  </tr>
  
   <tr>
        <td >First Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPname-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPname-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>
        <td >last Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPlname-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPlname-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >birthday:</td>
    <td>
<label style="color:red"><?php echo form_error('TPbirthdate-txt'.$row['household_id']); ?></label>
<input type="text" name="TPbirthdate-txt<?php echo $row['household_id']; ?>" readonly = "true" id = "date1<?php echo $row['household_id']; ?>" value=""  onClick = "javascript:NewCal('date1<?php echo $row['household_id']; ?>','mmddyyyy')" />
    
     </td>
     
  </tr>
  
    
     
        <td >Gender:</td>
    <td>
		 <label style="color:red"><?php echo form_error('TPsex-dd'.$row['household_id']); ?></label>
		<?php 
		$options = array(
		          'M'  => 'Male',
					'F'    => 'Female'
		                );
		$js = 'id="TPsex-dd"';
		echo form_dropdown('TPsex-dd'. $row['household_id'], $options, 'male',$js);
		?>
     </td>
     
        <td >Marital Status:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstatus-txt'.$row['household_id']); ?></label>
     <input type="text" name="TPstatus-txt<?php echo $row['household_id']; ?>" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >Nationality:</td>
    <td>
<label style="color:red"><?php echo form_error('TPnation-txt'.$row['household_id']); ?></label>
<input type="text" name="TPnation-txt<?php echo $row['household_id']; ?>" />
    
     </td>
      </tr>
       <tr>
         <td >blood type:</td>
    <td>
		<?php 
		$options = array(

       					'null'  => '',
		                'O'    => 'O',
						'AB'  => 'AB',
						'A'    => 'A',
						'B'  => 'B',
		                );
		$js = 'id="TPblood-dd"';
		echo form_dropdown('TPblood-dd'.$row['household_id'], $options, 'male',$js);
		?>
     </td>
     
           <td >Contact Nos:</td>
               <td colspan = 2>
		<label style="color:red"><?php echo form_error('TPcontact-txt'.$row['household_id']); ?></label>
		<input type="text" name="TPcontact-txt<?php echo $row['household_id']; ?>" size="40" />
		    
     </td>
    <td>
     </td>
     
     
  </tr>
	</table>
	<center>
  <input type="submit" class="submitButton" value="Add"/><?php echo form_close(); ?>
 </center>
<?php
echo '</div>';
$ctr++;
}
?>
</div>

<br>
 <table    align="center" cellpadding="5" style="width: 100%;">

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/view_household_midwife',$attributes); ?>
  
       <tr>
  <td colspan = "7">
  <center><b>Assign healthworker:</b>
  
  <?php 
		echo form_dropdown('TPbhw-dd', $bhwdd);
		?>
  </center>

  </td>
  </tr>
  
  
   <tr>
  <td colspan = "7">
  <center><b>Household Details</b></center>

  </td>
  </tr>
  
    <tr>
        <td >Household:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPhousehold-txt'); ?></label>
     <input type="text" name="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>"  size="20"/>
     </td>

    
    <td >House no:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPhouseno-txt'); ?></label>
     <input type="text" name="TPhouseno-txt" value="<?php echo set_value('patientno'); ?>"  />
     </td>
     
         <td >Street:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstreet-txt');?></label>
     <input type="text" name="TPstreet-txt" value="<?php echo set_value('patientno'); ?>" size="20" />
     </td>
  </tr>
  <tr>
  <td colspan = "7">
  <center><b> Head of Household</b></center>

  </td>
  </tr>
  
   <tr>
        <td >First Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPname-txt'); ?></label>
     <input type="text" name="TPname-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>
        <td >last Name:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPlname-txt'); ?></label>
     <input type="text" name="TPlname-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >birthday:</td>
    <td>
<label style="color:red"><?php echo form_error('TPbirthdate-txt'); ?></label>
<input type="text" name="TPbirthdate-txt" readonly = "true" id = "date1" value=""  onClick = "javascript:NewCal('date1','mmddyyyy')" />
    
     </td>
     
  </tr>
  
    
     
        <td >Gender:</td>
    <td>
		 <label style="color:red"><?php echo form_error('TPsex-dd'); ?></label>
		<?php 
		$options = array(
		          'M'  => 'Male',
					'F'    => 'Female'
		                );
		$js = 'id="TPsex-dd"';
		echo form_dropdown('TPsex-dd', $options, 'male',$js);
		?>
     </td>
     
        <td >Marital Status:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPstatus-txt'); ?></label>
     <input type="text" name="TPstatus-txt" value="<?php echo set_value('patientno'); ?>"  size="30"/>
     </td>

    
    <td >Nationality:</td>
    <td>
<label style="color:red"><?php echo form_error('TPnation-txt'); ?></label>
<input type="text" name="TPnation-txt" />
    
     </td>
      </tr>
       <tr>
         <td >blood type:</td>
    <td>
		<?php 
		$options = array(

       					'null'  => '',
		                'O'    => 'O',
						'AB'  => 'AB',
						'A'    => 'A',
						'B'  => 'B',
		                );
		$js = 'id="TPblood-dd"';
		echo form_dropdown('TPblood-dd', $options, 'male',$js);
		?>
     </td>
     
        <td >Contact Nos:</td>
               <td colspan = 2>
		<label style="color:red"><?php echo form_error('TPcontact-txt'.$row['household_id']); ?></label>
		<input type="text" name="TPcontact-txt<?php echo $row['household_id']; ?>" size="40" />
		    
     </td>
  </tr>
  
  <input type="hidden" name="selected" id="selected" value="<?php echo $selected; ?>" />
	</table>
	<center>
 <input type="submit" class="submitButton" value="Add Catchment Area"/><?php echo form_close(); ?>
	</center>
 <br>

 </div>
<div  id="tabs-2">
<center>
<?php
$tmpl = array (
		'table_open'          => '<table border="1" cellpadding="2" cellspacing="0" id="results" style="width: 70%;" >',

		'heading_row_start'   => '<tr>',
		'heading_row_end'     => '</tr>',
		'heading_cell_start'  => '<th id="result" scope="col">',
		'heading_cell_end'    => '</th>',

		'row_start'           => '<tr>',
		'row_end'             => '</tr>',
		'cell_start'          => '<td align="center">',
		'cell_end'            => '</td>',

		'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
		'row_alt_end'         => '</tr>',
		'cell_alt_start'      => '<td align="center">',
		'cell_alt_end'        => '</td>',

		'table_close'         => '</table>'
);

$this->table->set_template($tmpl);
$this->table->set_heading(
		array(	'Name',
				'Age',
				'Days Of Fever',
				'Muscle Pain',
				'Joint Pain',
				'Head Ache',
				'Bleeding',
				'Rashes',
				'Date Onset',
				'Remarks'
		));
//echo $this->table->generate($cases);
?>
<?php 
if($cases != null){
?>
<table border="1" cellpadding="2" cellspacing="0" id="results" style="width: 50%;"  >
<tr>
<td><b>Severity</b></td>
<td><b>Name</b></td>
<td><b>Address</b></td>
<td><b>Contact Nos.</b></td>
<td><b>Age</b></td>
<td><b>Days Of Fever</b></td>
<td><b>Muscle Pain</b></td>
<td><b>Joint Pain</b></td>
<td><b>Head Ache</b></td>
<td><b>Bleeding</b></td>
<td><b>Rashes</b></td>
<td><b>Date Onset</b></td>
<td><b>Remarks</b></td>
</tr>

<?php 
foreach($cases as $value)
{

	
		echo '<tr>';
		echo '<tr>';
	if($value['Bleeding'] == 'Y' || $value['Rashes'] == 'Y' || $value['Status'] == 'serious')
		echo "<td bgcolor='#FF0000'><b>Serious<b></b></td>";
	else if($value['Status'] == "threatening")
		echo "<td bgcolor='#FF8000'><b>".$value['Status']."<b></td>";
	else if($value['Status'] == "supected")
		echo "<td bgcolor='#FFFF00'><b>".$value['Status']."<b></td>";
	else //if($value['Status'] == "finished")
		echo "<td bgcolor='#00FF00'><b>".$value['Status']."<b></td>";
	
	echo '
		<td>'.$value['Name'].'</td>
		<td>'.$value['Address'].'</td>
		<td>'.$value['Contact Nos'].'</td>
		<td>'.$value['Age'].'</td>
		<td>'.$value['Days Of Fever'].'</td>
		<td>'.$value['Muscle Pain'].'</td>
		<td>'.$value['Joint Pain'].'</td>
		<td>'.$value['Head Ache'].'</td>
		<td>'.$value['Bleeding'].'</td>
		<td>'.$value['Rashes'].'</td>
		<td>'.$value['Date Onset'].'</td>
		<td>'.$value['Remarks'].'</td>
		';

	
	echo '</tr>';
}
}
else 
	echo '<b>No new cases has been reported.</b>';
	
	?>
</table>
</center>
				
				
</div>
<div  id="tabs-8">
<center>
<?php
$tmpl = array (
		'table_open'          => '<table border="1" cellpadding="2" cellspacing="0" id="results" style="width: 70%;" >',

		'heading_row_start'   => '<tr>',
		'heading_row_end'     => '</tr>',
		'heading_cell_start'  => '<th id="result" scope="col">',
		'heading_cell_end'    => '</th>',

		'row_start'           => '<tr>',
		'row_end'             => '</tr>',
		'cell_start'          => '<td align="center">',
		'cell_end'            => '</td>',

		'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
		'row_alt_end'         => '</tr>',
		'cell_alt_start'      => '<td align="center">',
		'cell_alt_end'        => '</td>',

		'table_close'         => '</table>'
);

$this->table->set_template($tmpl);
$this->table->set_heading(
		array(	'Name',
				'Age',
				'Type',
				'Outcome',
				'Date Onset',
				'View Complete Details'
		));
echo $this->table->generate($confirmedcases);
?>
</center>
				
				
</div>

<div  id="tabs-3">
<div id="accordion2">
<?php 
foreach($catchment as $key=>$row)
{
	
echo '<h3>'.$bhw[$key].'</h3>';
echo '<div>';
echo 'Catchment Area';
$this->table->set_heading(
		array(	'Name',
				'House no',
				'street',
				'Last Visited',
		));
echo $this->table->generate($row);
echo '</div>';
}
?>
</div>

</div>

<div  id="tabs-4">
<center>
<?php 
$this->table->set_heading(
		array(	'First Name',
				'last Name',
				'Gender',
				'Age',
				'Street Address',
				'Barangay',
		));
echo $this->table->generate($uninvest);

?>
</center>
</div>
<div id="tabs-7">
					<h2> Barangay Cleanup Schedule </h2>
					<?php 
					$tmpl = array (
									'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" >',
								    'heading_row_start'   => '<tr>',
								    'heading_row_end'     => '</tr>',
								    'heading_cell_start'  => '<th id="result" scope="col">',
								    'heading_cell_end'    => '</th>',
								    'row_start'           => '<tr>',
								    'row_end'             => '</tr>',
								    'cell_start'          => '<td align="center">',
								    'cell_end'            => '</td>',
								    'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
								    'row_alt_end'         => '</tr>',
								    'cell_alt_start'      => '<td align="center">',
								    'cell_alt_end'        => '</td>',
								    'table_close'         => '</table>'
								   );
					$this->table->set_template($tmpl);
					echo $this->table->generate($cleanup);?>
<table    align="center" cellpadding="5" style="width: 100%;">
  <tr>
  <td colspan = "7">
 <?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('master_list/addcleanup',$attributes); ?>
<br>
<br>
  <center><b>Schedule Cleanup</b></center>

  </td>
  </tr>
  
   <tr>
   <td >Description:</td>
    <td>
    <label style="color:red"><?php echo form_error('description'); ?></label>
     <input type="text" name="description" value="<?php echo set_value('patientno'); ?>"  size="50"/>
     </td>

    
    <td >Date to be conducted:</td>
    <td>
<label style="color:red"><?php echo form_error('conduct'); ?></label>
<input type="text" name="conduct" readonly = "true" id = "conduct" value=""  onClick = "javascript:NewCal('conduct','mmddyyyy')" />
    
     </td>
     
  </tr>
	</table>
	<center>
  <input type="submit" class="submitButton" value="Add"/><?php echo form_close(); ?>

</div>

</div>
 </body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>