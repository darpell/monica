<!-- CONTENT -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather,visualization&sensor=true"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script>
var infoWindow = new google.maps.InfoWindow();
infoWindow.setOptions({maxWidth:400});

function load() {
	//alert("Present: "+document.getElementById("presRemvd").value+" remvd "+document.getElementById("present_length").value+" remain");
	//alert("Old: "+document.getElementById("oldRemvd").value+" remvd "+document.getElementById("old_length").value+" remain");
	var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
	var heatmap, map, pointArray;
	var mapProp = {
		center: dasma,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
		var cases = new Array();
	
	/** Sample Larval Data used as case data **/
	if (document.getElementById("present_length").value != 0)
	{
		//var case_img = document.getElementById("case_icon").value;
		for (var pt_ctr = 0; pt_ctr < document.getElementById("present_length").value; pt_ctr++) 
		{					
			cases.push(new google.maps.LatLng(
					document.getElementById("lsPres_lat" + pt_ctr).value,
					document.getElementById("lsPres_lng" + pt_ctr).value
					));
		}
		for (var pt_ctr = 0; pt_ctr < document.getElementById("old_length").value; pt_ctr++) 
		{					
			cases.push(new google.maps.LatLng(
					document.getElementById("lsOld_lat" + pt_ctr).value,
					document.getElementById("lsOld_lng" + pt_ctr).value
					));
		}
		pointArray = new google.maps.MVCArray();
		heatmap = new google.maps.visualization.HeatmapLayer({
			  data: cases
			});
			heatmap.setMap(map);
	}
	/** end of sample data**/
}
  function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	  
	});
</script>
</head>
<form>
<input type = 'hidden' id ='presRemvd' name='presRemvd' value='<?php echo $presRemvd?>'>
<input type = 'hidden' id ='oldRemvd' name='oldRemvd' value='<?php echo $oldRemvd?>'>
<input type = 'hidden' id ='presentDataExists' name='presRemvd' value='<?php echo $presentDataExists?>'>
<input type = 'hidden' id ='oldDataExists' name='oldRemvd' value='<?php echo $oldDataExists?>'>
<input type = 'hidden' id ='olderDataExists' name='oldRemvd' value='<?php echo $olderDataExists?>'>
</form>

<?php if ($presentDataExists === true){$ctr=0;?>
<input type="hidden" id="present_length" value="<?php echo count($presentData); ?>" />
	<?php foreach ($presentData as $value) {?>
		<input type="hidden" id="lsPres_lat<?= $ctr ?>" 		value="<?php echo $value['ls_lat']; ?>"	/>
		<input type="hidden" id="lsPres_lng<?= $ctr ?>" 		value="<?php echo $value['ls_lng']; ?>"	/>
		<input type="hidden" id="lsPres_household<?= $ctr ?>" 		value="<?php echo $value['ls_household']; ?>"	/>
		<input type="hidden" id="lsPres_street<?= $ctr ?>" 		value="<?php echo $value['ls_street']; ?>"	/>
		<input type="hidden" id="lsPres_container<?= $ctr ?>" 		value="<?php echo $value['ls_container']; ?>"	/>
		<input type="hidden" id="lsPres_date<?= $ctr ?>" 		value="<?php echo $value['ls_date']; ?>"	/>
		<input type="hidden" id="lsPres_createdby<?= $ctr ?>" 		value="<?php echo $value['created_by']; ?>"	/>
	<?php $ctr++;}?> 
	<?php } else { ?> <input type="hidden" id="present_length" value="0" /> <?php } ?>

<?php if ($oldDataExists === true){$ctr=0;?>
<input type="hidden" id="old_length" value="<?php echo count($oldData); ?>" />
	<?php foreach ($oldData as $value) {?>
		<input type="hidden" id="lsOld_lat<?= $ctr ?>" 		value="<?php echo $value['ls_lat']; ?>"	/>
		<input type="hidden" id="lsOld_lng<?= $ctr ?>" 		value="<?php echo $value['ls_lng']; ?>"	/>
		<input type="hidden" id="lsOld_household<?= $ctr ?>" 		value="<?php echo $value['ls_household']; ?>"	/>
		<input type="hidden" id="lsOld_street<?= $ctr ?>" 		value="<?php echo $value['ls_street']; ?>"	/>
		<input type="hidden" id="lsOld_container<?= $ctr ?>" 		value="<?php echo $value['ls_container']; ?>"	/>
		<input type="hidden" id="lsOld_date<?= $ctr ?>" 		value="<?php echo $value['ls_date']; ?>"	/>
		<input type="hidden" id="lsOld_createdby<?= $ctr ?>" 		value="<?php echo $value['created_by']; ?>"	/>
	<?php $ctr++;}?>
	<?php } else { ?> <input type="hidden" id="old_length" value="0" /> <?php } ?>
	
<body onload="load()">
<div id="googleMap" style="width: 900px; height: 600px"></div>

