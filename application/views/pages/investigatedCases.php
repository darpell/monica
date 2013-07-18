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
	var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
	var map;
	var mapProp = {
		center: dasma,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
	/** Sample Larval Data used as case data **/
	if (document.getElementById("ic_length").value != 0)
	{//alert("0");
		for (var pt_ctr = 0; pt_ctr < document.getElementById("ic_length").value; pt_ctr++) 
		{	
			new google.maps.Marker({
				  position: new google.maps.LatLng(
							document.getElementById("ic_lat" + pt_ctr).value,
							document.getElementById("ic_lng" + pt_ctr).value
							),
				  map: map
				});
		}
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
		<input type="hidden" id="ic_barangay<?= $ctr ?>" 		value="<?php echo $value['ic_barangay']; ?>"	/>
	<?php $ctr++;}?> 
	<?php } else { ?> <input type="hidden" id="ic_length" value="0" /> <?php } ?>
	
<body onload="load()">
<div id="googleMap" style="width: 900px; height: 600px"></div>

