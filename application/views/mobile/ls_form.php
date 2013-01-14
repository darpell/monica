<!DOCTYPE html> 
<html> 
<head> 
    <title>Page Title</title> 
    
    <meta name="viewport" content="width=device-width, initial-scale=1"> 

    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js"> 
</script> 
<script src="http://j.maxmind.com/app/geoip.js"></script>


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
<?php echo form_open('form'); ?>

<h5>Name of Volunteer Inspector</h5>
<label style="color:red"><?php echo form_error('TPinspector-txt'); ?></label>
<input type="text" name="TPinspector-txt" value="<?php echo set_value('TPinspector-txt'); ?>" size="50" />

<h5>Date</h5>
<label style="color:red"><?php echo form_error('TPdate-txt'); ?></label>
<input type="text" name="TPdate-txt" value="<?php echo date("Y-m-d H:i:s");  ; ?>" size="50" />

<h5>Barangay</h5>
<label style="color:red"><?php echo form_error('TPbarangay-txt'); ?></label>
<input type="text" name="TPbarangay-txt" id="TPbarangay-txt" size="50" />

<h5>Street</h5>
<label style="color:red"><?php echo form_error('TPstreet-txt'); ?></label>
<input type="text" name="TPstreet-txt" id="TPstreet-txt" size="50" />

<h5>Municipality</h5>
<label style="color:red"><?php echo form_error('TPmunicipality-txt'); ?></label>
<input type="text" name="TPmunicipality-txt" id="TPmunicipality-txt" size="50" />

<h5>Name of Household</h5>
<label style="color:red"><?php echo form_error('TPhousehold-txt'); ?></label>
<input type="text" name="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Result of Survey Positive or Negative</h5>
<label style="color:red"><?php echo form_error('TPresult-rd'); ?></label>
<input type="radio" name="TPresult-rd" value="Positive" <?php echo set_radio('myradio', 'Positive', TRUE); ?> /> Positive <br/>
<input type="radio" name="TPresult-rd" value="Negative" <?php echo set_radio('myradio', 'Negative'); ?> /> Negative <br/>

<h5>Type of Container</h5>
<label style="color:red"><?php echo form_error('TPcontainer-txt'); ?></label>
<input type="text" name="TPcontainer-txt" value="<?php echo set_value('TPcontainer-txt'); ?>" size="50" />

<h5>Created by:</h5>
<label style="color:red"><?php echo form_error('TPcreatedby-txt'); ?></label>
<input type="text" name="TPcreatedby-txt" value="<?php echo 'Mr. Bong'; ?>" size="50" />

<h5>Created on:</h5>
<label style="color:red"><?php echo form_error('TPcreatedon-txt'); ?></label>
<input type="text" name="TPcreatedon-txt" value="<?php echo date("Y-m-d H:i:s"); ?>" size="50" />

<h5>Last Updated by: </h5>
<label style="color:red"><?php echo form_error('TPlastupdatedby-txt'); ?></label>
<input type="text" name="TPlastupdatedby-txt" value="<?php echo 'Mr. Bong'; ?>" size="50" />

<h5>Last Updated on:</h5>
<label style="color:red"><?php echo form_error('TPlastupdatedon-txt'); ?></label>
<input type="text" name="TPlastupdatedon-txt" value="<?php echo date("Y-m-d H:i:s"); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

<?php echo form_close();?>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>