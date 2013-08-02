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
				//document.getElementById("test").innerHTML = results[0].formatted_address;
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
		<h1> Person's Details </h1>
		<a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="delete"> Cancel </a>
	</div><!-- /header -->
	<div data-role="content">

		
		<ul data-role="listview" data-inset="true">
			
			<!-- <li> <?php //echo $test; ?></li> -->
				<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
				
				<li> Name: 
					<?php echo $household_persons[$ctr]['person_first_name']; ?> <!-- First Name -->
					<?php echo $household_persons[$ctr]['person_last_name']; ?> <!-- Last Name --> 
				</li>
				
				<li> Civil Status: 
					<?php echo $household_persons[$ctr]['person_marital'];?> <!-- Civil Status -->
				</li>
				
				<li> Nationality: 
					<?php echo $household_persons[$ctr]['person_nationality']; ?> <!-- Nationality-->
				</li>
				
				<li> Age: 
					<?php echo $household_persons[$ctr]['person_dob']; ?> <!-- Age -->
				</li>
				
				<li> Gender: 
					<?php 
						if ($household_persons[$ctr]['person_sex'] == 'M')
							echo 'Male';
						else if ($household_persons[$ctr]['person_sex'] == 'F')
							echo 'Female';
					?> <!-- Sex -->
				</li>
					
				<li> Blood Type: 
					<?php 
						if ($household_persons[$ctr]['person_blood_type'] == NULL || $household_persons[$ctr]['person_blood_type'] == 'null')
							echo 'N.A.';
						else
							echo $household_persons[$ctr]['person_blood_type'];
					?>
				</li> <!-- Blood Type -->
				
				<li>Guardian: 
					<?php echo $household_persons[$ctr]['person_guardian'];?>
				</li>
			<?php } ?>
		</ul>
		
		<form name="symptom_form" action="<?php echo $household_persons[0]['person_id']; ?>/add_im" method="post" data-ajax="false">
		
		<!-- lat & lng -->
		<input type="hidden" name="lat" id="lat" />
		<input type="hidden" name="lng" id="lng" />
		<!-- /lat & lng -->
		
		<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
				<div data-role="collapsible">
					<h2> Has Fever?</h2>
					
					<?php for ($ctr = 0; $ctr < count($household_persons); $ctr++) {?>
						<input type="hidden" name="household_id" id="household_id" value="<?php echo $household_persons[$ctr]['household_id']; ?>"	/>
						<input type="hidden" name="person_id" id="person_id" value="<?php echo $household_persons[$ctr]['person_id']; ?>"	/>
					<?php } ?>	
					<ul data-role="listview">
					
						<li  data-role="fieldcontain">
							 	<fieldset data-role="controlgroup">
									Other dengue related symptoms:
									<input type="checkbox" name="has_muscle_pain" id="checkbox-1a" value="Y" />
									<label for="checkbox-1a"> Muscle Pain </label>
				
									<input type="checkbox" name="has_joint_pain" id="checkbox-2a" value="Y" />
									<label for="checkbox-2a"> Joint Pain </label>
									
									<input type="checkbox" name="has_headache" id="checkbox-3a" value="Y" />
									<label for="checkbox-3a"> Headache </label>
				
									<input type="checkbox" name="has_rashes" id="checkbox-4a" value="Y" />
									<label for="checkbox-4a"> Rashes </label>
									
									<input type="checkbox" name="has_bleeding" id="checkbox-5a" value="Y" />
									<label for="checkbox-5a"> Bleeding </label>
							    </fieldset>
							</li>
						
						
						<!-- TODO limit the minimum to 0 -->
						<li data-role="fieldcontain">
						    <label for="name"> Duration of Fever: </label>
							<label style="color:red"><?php echo form_error('duration'); ?></label>
						    <input type="number" name="duration" id="duration" value="" min="1" max="20" />
						</li>
							
						<li data-role="fieldcontain">
						    <label for="name"> Suspected Source: (recent journey, etc.) </label>
						    <input type="text" name="source" id="source" value="<?php echo set_value('source'); ?>" />
						</li>
						
						<li data-role="fieldcontain">
						<label for="textarea"> Remarks: (medicine intake, etc.) </label>
							<textarea name="remarks" id="remarks"> <?php echo set_value('remarks'); ?> </textarea>
						</li>
						
						<li>
							<input type="submit" value="Submit" />
						</li>
					
					</ul>
					
				</div>
		</div>
		</form>
	</div><!-- /content -->
</div><!-- /page -->

</body>
</html>