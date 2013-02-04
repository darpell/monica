<!-- HEADER -->
<?php echo $this->load->view('/mobile/templates/mob_header.php'); ?>

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"> 
</script> 
	<script src="http://j.maxmind.com/app/geoip.js"></script>-->


	<script type="text/javascript"
          src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-9o53l2-ccgNGON3JbUefG9aEmV09ikA&sensor=true">
    </script>
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

<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header">
        <h3>Larval Survey Report</h3>
    </div><!-- /header -->
    <div data-role="content">    

<form action="addls" method="post" data-ajax="false">

	<!-- name of inspector -->
	<label for="TPinspector-txt">Name of Inspector:</label>
	<label style="color:red"><?php echo form_error('TPinspector-txt'); ?></label>
	<input type="text" name="TPinspector-txt" id="TPinspector-txt" value="" data-mini="true" />
	<!-- /name of inspector -->

	<!-- date -->
	<label for="TPdate-txt"> Date: </label>
	<label style="color:red"><?php echo form_error('TPdate-txt'); ?></label>
	<input type="date" name="TPdate-txt" id="TPdate-txt" value="<?php echo date("Y-m-d H:i:s");?>" data-mini="true" />
	<!-- /date -->

	<!-- barangay -->
	<label for="TPbarangay-txt"> Barangay: </label>
	<label style="color:red"><?php echo form_error('TPbarangay-txt'); ?></label>
	<input type="text" name="TPbarangay-txt" id="TPbarangay-txt" data-mini="true" />
	<!-- /barangay -->

	<!-- street -->
	<label for="TPstreet-txt"> Street: </label>
	<label style="color:red"><?php echo form_error('TPstreet-txt'); ?></label>
	<input type="text" name="TPstreet-txt" id="TPstreet-txt" data-mini="true" />
	<!-- /street -->

	<!-- municipality -->
	<label for="TPmunicipality-txt"> Municipality: </label>
	<label style="color:red"><?php echo form_error('TPmunicipality-txt'); ?></label>
	<input type="text" name="TPmunicipality-txt" id="TPmunicipality-txt" data-mini="true" />
	<!-- /municipality -->

	<!-- household -->
	<label for="TPhousehold-txt"> Name of Household: </label>
	<label style="color:red"><?php echo form_error('TPhousehold-txt'); ?></label>
	<input type="text" name="TPhousehold-txt" id="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>" data-mini="true" />
	<!-- /household -->

	<!-- result -->
	<div data-role="fieldcontain">
		<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
			<legend> Survey Result </legend>
			
			<input type="radio" name="TPresult-rd" id="TPresult-rd1" value="negative" checked="checked" />
			<label for="TPresult-rd1"> Negative </label>
			
			<input type="radio" name="TPresult-rd" id="TPresult-rd2" value="positive" />
			<label for="TPresult-rd2"> Positive </label>
			
		</fieldset>
	</div><!-- /result -->

	<!-- container -->
	<label for="TPcontainer-txt">Type of Container</label>
	<label style="color:red"><?php echo form_error('TPcontainer-txt'); ?></label>
	<input type="text" name="TPcontainer-txt" id="TPcontainer-txt" value="<?php echo set_value('TPcontainer-txt'); ?>" data-mini="true" />
	<!-- /container -->

	<!-- createdby -->
	<label id="TPcreatedby-txt">Created by:</label>
	<label style="color:red"><?php echo form_error('TPcreatedby-txt'); ?></label>
	<input type="text" name="TPcreatedby-txt" id="TPcreatedby-txt" value="<?php echo 'Mr. Bong'; ?>" data-mini="true" />
	<!-- /createdby -->

	<!-- created -->
	<label for="TPcreatedon-txt"> Created on: </label>
	<label style="color:red"><?php echo form_error('TPcreatedon-txt'); ?></label>
	<input type="date" name="TPcreatedon-txt" id="TPcreatedon-txt" value="<?php echo date("Y-m-d H:i:s"); ?>" data-mini="true" />
	<!-- /created -->

	<!-- updatedby -->
	<label for="TPlastupdatedby-txt"> Last Updated by: </label>
	<label style="color:red"><?php echo form_error('TPlastupdatedby-txt'); ?></label>
	<input type="text" name="TPlastupdatedby-txt" id="TPlastupdatedby-txt" value="<?php echo 'Mr. Bong'; ?>" data-mini="true" />
	<!-- /updatedby -->

	<!-- updated -->
	<label for="TPlastupdatedon-txt"> Last Updated on: </label>
	<label style="color:red"><?php echo form_error('TPlastupdatedon-txt'); ?></label>
	<input type="date" name="TPlastupdatedon-txt" id="TPlastupdatedon-txt" value="<?php echo date("Y-m-d H:i:s"); ?>" data-mini="true" />
	<!-- /updated -->

	<div>
		<input type="submit" value="Submit" />
	</div>

</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>