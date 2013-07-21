<!-- HEADER -->
<?= $this->load->view('/mobile/templates/mob_header') ?>

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
				document.getElementById("test").innerHTML = results[0].formatted_address;
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

<!-- CONTENT -->
</head> 
<body onload="initialize()"> 

<div data-role="page">

	<div data-role="header">
		<h1> Case Details </h1>
        <a href="<?php echo site_url('mobile/page/uninvestigated_cases');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
	</div><!-- /header -->
	<div data-role="content">
	
		<div id="test"></div>
		<form id="" action="add" method="post" data-ajax="false">
		
		<!-- patient_no -->
		<input type="hidden" name="patient_no" id="patient_no" value="<?php echo $slug; ?>" />
		<!-- /patient_no -->
		
		<!-- lat & lng -->
		<input type="hidden" name="lat" id="lat" />
		<input type="hidden" name="lng" id="lng" />
		<!-- /lat & lng -->
		
		<ul data-role="listview" data-inset="true">
			<li>
				<?php 
					$outcome = $case_details['cr_outcome'];
					if ($outcome == 'A')
						echo '<label style="color:green;font-size:17px;"><strong> Alive </strong></label>';
					else if ($outcome == 'D')
						echo '<label style="color:red;font-size:17px;"><strong> Died </strong></label>';
					else if ($outcome == 'U')
						echo 'Unknown';
				?>
			</li>
			<li>
				<?php echo $case_details['cr_first_name'] . ' ' . $case_details['cr_last_name']; ?>
			</li>
			<li>
				<?php echo $case_details['cr_age']; ?>, <?php $sex = ($case_details['cr_sex'] = 'F') ? 'Female' : 'Male'; echo $sex; ?>
			</li>
			<li>
				Classification: 
				<?php 
					$class = $case_details['cr_classification'];
					if ($class == 'S')
						echo 'Suspected Case';
					else if ($class == 'P')
						echo 'Probable Case';
					else if ($class == 'C')
						echo 'Confirmed Case';
				?>
			</li>
			<li>
				Type of Strain: 
				<?php 
					$type = $case_details['cr_type'];
					if ($type == 'DF')
						echo 'Dengue Fever';
					else if ($type == 'DHF')
						echo 'Dengue Hemorrhagic Fever';
					else if ($type == 'DSS')
						echo 'Dengue Shock Syndrome';
    				else
						echo $type;
				?>
			</li>
			<li>
				Date of Entry: <?php echo $case_details['date_of_entry']; ?>
			</li>
		
			<li>
			<!-- remarks -->
				Remarks
				<label style="color:red"><?php echo form_error('TPremarks-txt_r'); ?></label>
				<textarea  name="TPremarks-txt_r" id="TPremarks-txt" placeholder="<?php echo set_value('TPremarks-txt_r'); ?>" data-mini="true"> </textarea>
			<!-- /remarks -->
			</li>
			
			<li>
				<input type="submit" value="Submit" />
			</li>
		</ul>
		</form>
		
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>