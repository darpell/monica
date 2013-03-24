<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"> 
</script> 
	<script src="http://j.maxmind.com/app/geoip.js"></script>-->


	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
    <script type="text/javascript">
		$( document ).bind( "mobileinit", function() {
			// Make your jQuery Mobile framework configuration changes here!
			$.support.cors = true;
			$.mobile.allowCrossDomainPages = true;
		});
    </script>
    <script>
var geocoder = new google.maps.Geocoder();
function initialize(){
	
        if (navigator.geolocation)
    {
    navigator.geolocation.getCurrentPosition(showPosition);
    }
}
      function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
              	//alert(results[0].formatted_address);
				//document.getElementById("test").innerHTML = results[0].formatted_address;
				document.getElementById("TPstreet-txt").value = results[0].address_components[0].long_name;
				document.getElementById("TPmunicipality-txt").value = results[0].address_components[2].long_name;
				document.getElementById("TPbarangay-txt").value = results[0].address_components[1].long_name;
				document.getElementById("lat").value = lat;
				document.getElementById("lng").value = lng;
            } else {
              alert('No results found');
            }
          } else {
            alert('Geocoder failed due to: ' + status);
          }
        });
      }

       function showError(error)
	  {
	  switch(error.code) 
	    {
	    case error.PERMISSION_DENIED:
	      x.innerHTML="User denied the request for Geolocation."
	      break;
	    case error.POSITION_UNAVAILABLE:
	      x.innerHTML="Location information is unavailable."
	      break;
	    case error.TIMEOUT:
	      x.innerHTML="The request to get user location timed out."
	      break;
	    case error.UNKNOWN_ERROR:
	      x.innerHTML="An unknown error occurred."
	      break;
	    }
	  }
</script>
</head> 
<body onload="initialize()">

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" id="ls_header" data-nobackbtn="true">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1> Point of Interest Form </h1>
    </div><!-- /header -->
    <div data-role="content" id="ls_content">
    
<form action="new_poi" method="post" data-ajax="false">

	<!-- date -->
	<label for="TPdate-txt"> Date: </label>
	<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
	<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
	<!-- /date -->

	<!-- barangay -->
	<label for="TPbarangay-txt"> Barangay: </label>
	<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
	<input type="text" name="TPbarangay-txt_r" id="TPbarangay-txt" data-mini="true" readonly />
	<!-- /barangay -->
	
	<!-- lat & lng -->
	<input type="hidden" name="lat" id="lat" />
	<input type="hidden" name="lng" id="lng" />
	<!-- /lat & lng -->
	
	<!-- street -->
	<label for="TPstreet-txt"> Street: </label>
	<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
	<input type="text" name="TPstreet-txt_r" id="TPstreet-txt" data-mini="true" readonly/>
	<!-- /street -->

	<!-- municipality -->
	<label for="TPmunicipality-txt"> Municipality: </label>
	<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
	<input type="text" name="TPmunicipality-txt_r" id="TPmunicipality-txt" data-mini="true" readonly/>
	<!-- /municipality -->

	<!-- name -->
	<label for="TPname-txt"> Name: </label>
	<label style="color:red"><?php echo form_error('TPname-txt_r'); ?></label>
	<input type="text" name="TPname-txt_r" id="TPhousehold-txt" value="<?php echo set_value('TPname-txt_r'); ?>" data-mini="true" />
	<!-- /name -->

	<!-- type -->
	<label> Type: </label>
	<fieldset data-role="controlgroup" data-mini="true" data-type="horizontal">
			<label style="color:red"><?php echo form_error('TPtype-txt_r'); ?></label>
	    	<input type="radio" name="TPtype-txt_r" id="TPtype-txt-1" value="0" checked="checked" />
	    	<label for="TPtype-txt-1"> Source Area </label>
	
			<input type="radio" name="TPtype-txt_r" id="TPtype-txt-2" value="1"  />
	    	<label for="TPtype-txt-2"> Risk Area </label>
		</fieldset>
		<!-- /type -->
		
	<!-- remarks -->
	<label for="TPremarks-txt"> Remarks: </label>
		<label style="color:red"><?php echo form_error('TPremarks-txt_r'); ?></label>
		<textarea  name="TPremarks-txt_r" id="TPremarks-txt" placeholder="<?php echo set_value('TPremarks-txt_r'); ?>" data-mini="true"> </textarea>
	<!-- /remarks -->

	<div>
		<input type="submit" value="Submit" />
	</div>

</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>