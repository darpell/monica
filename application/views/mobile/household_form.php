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
            	$('.lat').val(lat);
				$('.lng').val(lng);
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
	      x.innerHTML="User denied the request for Geolocation.";
	      break;
	    case error.POSITION_UNAVAILABLE:
	      x.innerHTML="Location information is unavailable.";
	      break;
	    case error.TIMEOUT:
	      x.innerHTML="The request to get user location timed out.";
	      break;
	    case error.UNKNOWN_ERROR:
	      x.innerHTML="An unknown error occurred.";
	      break;
	    }
	  }
</script>
</head> 
<body onload="initialize()">

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" id="ls_header" data-nobackbtn="true">
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
        <h1>New Household</h1>
    </div><!-- /header -->
    <div data-role="content">
    
	<form id="hh_form" action="addhh" method="post" data-ajax="false">
			
					<!-- lat & lng -->
					<input type="hidden" name="lat" class="lat" />
					<input type="hidden" name="lng" class="lng" />
					<!-- /lat & lng -->
				
					<!-- household -->
					<label for="TPhousehold-txt"> Name of Household: </label>
					<label style="color:red"><?php echo form_error('hh_name'); ?></label>
					<input type="text" name="hh_name" id="hh_name" value="<?php echo set_value('hh_name'); ?>" data-mini="true" />
					<!-- /household -->
					
					<!-- household_no -->
					<label for="TPhousehold-txt"> House Address No.: </label>
					<label style="color:red"><?php echo form_error('hh_no'); ?></label>
					<input type="text" name="hh_no" id="hh_no" value="<?php echo set_value('hh_no'); ?>" data-mini="true" />
					<!-- /household_no -->
					
					<!-- street -->
					<label for="TPstreet-txt"> Street: </label>
					<label style="color:red"><?php echo form_error('hh_street'); ?></label>
					<input type="text" name="hh_street" class="hh_street" data-mini="true" />
					<!-- /street -->
				
					<div>
						<input type="submit" value="Submit" />
					</div>
			
				</form>

    </div><!-- /content -->
</div><!-- /page -->

</body>
</html>