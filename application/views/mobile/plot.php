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
				//document.getElementById("TPstreet-txt").value = results[0].address_components[0].long_name;
				//document.getElementById("TPmunicipality-txt").value = results[0].address_components[2].long_name;
				//document.getElementById("TPbarangay-txt").value = results[0].address_components[1].long_name;
				//document.getElementById("lat").value = lat;
				//document.getElementById("lng").value = lng;
				
					  $('.lat').val(lat);
					  $('.lng').val(lng);
					  $('.TPstreet-txt').val(results[0].address_components[0].long_name);
					  $('.TPmunicipality-txt').val(results[0].address_components[2].long_name);
					  $('.TPbarangay-txt').val(results[0].address_components[1].long_name);
				
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
<div data-role="page" id="home" style="width:100%; height:100%;">
    <div data-role="header" data-id="myfooter" id="home_header" data-position="fixed" data-nobackbtn="true">
        <!-- <p style="font-size:medium;padding:5px;text-align:center;">Dengue Mapping</p> -->
        <a href="<?php echo site_url('mobile');?>" data-ajax="false" data-icon="arrow-l"> Back </a>
        <h1> Plot Occurrence </h1>
    </div><!-- /header -->

    <div data-role="content">
    	<!-- Data Collapsible -->
    	<div data-role="collapsible-set" data-theme="b" data-content-theme="d">
	    	<!-- PoI -->
	    	<div data-role="collapsible">
	    		<h2> Point of Interest </h2>
	    		<form action="new_poi" method="post" data-ajax="false">
				
				<!-- date -->
				<label for="TPdate-txt"> Date: </label>
				<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
				<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
				<!-- /date -->
			
				<!-- barangay -->
				<label for="TPbarangay-txt"> Barangay: </label>
				<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
				<input type="text" name="TPbarangay-txt_r" class="TPbarangay-txt" data-mini="true" readonly />
				<!-- /barangay -->
				
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
				
				<!-- street -->
				<label for="TPstreet-txt"> Street: </label>
				<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
				<input type="text" name="TPstreet-txt_r" class="TPstreet-txt" data-mini="true" readonly/>
				<!-- /street -->
			
				<!-- municipality -->
				<label for="TPmunicipality-txt"> Municipality: </label>
				<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
				<input type="text" name="TPmunicipality-txt_r" class="TPmunicipality-txt" data-mini="true" readonly/>
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
	    	</div>
	    	<!-- /end PoI -->
	    	
	    	<!-- Larval Occurrence -->
	    	<div data-role="collapsible">
	    		<h2> Larval Occurrence </h2>
	    		<form id="ls_form" action="addls" method="post" data-ajax="false">
			
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
			
				<!-- date -->
				<label for="TPdate-txt"> Date: </label>
				<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
				<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
				<!-- /date -->
			
				<!-- barangay -->
				<label for="TPbarangay-txt"> Barangay: </label>
				<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
				<input type="text" name="TPbarangay-txt_r" class="TPbarangay-txt" data-mini="true" readonly />
				<!-- /barangay -->
				
				<!-- lat & lng -->
				<input type="hidden" name="lat" class="lat" />
				<input type="hidden" name="lng" class="lng" />
				<!-- /lat & lng -->
				
				<!-- street -->
				<label for="TPstreet-txt"> Street: </label>
				<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
				<input type="text" name="TPstreet-txt_r" class="TPstreet-txt" data-mini="true" readonly/>
				<!-- /street -->
			
				<!-- municipality -->
				<label for="TPmunicipality-txt"> Municipality: </label>
				<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
				<input type="text" name="TPmunicipality-txt_r" class="TPmunicipality-txt" data-mini="true" readonly/>
				<!-- /municipality -->
			
				<!-- household -->
				<label for="TPhousehold-txt"> Name of Household: </label>
				<label style="color:red"><?php echo form_error('TPhousehold-txt_r'); ?></label>
				<input type="text" name="TPhousehold-txt_r" id="TPhousehold-txt" value="<?php echo set_value('TPhousehold-txt_r'); ?>" data-mini="true" />
				<!-- /household -->
				
				<!-- container -->
				<label for="TPcontainer-txt">Type of Container</label>
				<label style="color:red"><?php echo form_error('TPcontainer-txt'); ?></label>
				<input type="text" name="TPcontainer-txt_r" id="TPcontainer-txt" value="<?php echo set_value('TPcontainer-txt'); ?>" data-mini="true" />
				<!-- /container -->
			
				<div>
					<input type="submit" value="Submit" />
				</div>
			
			</form>
	    	</div>
	    	<!-- /end Larval Occurrence -->
	    	
	    	<!-- Single Case Report/Investigation -->
	    	<div data-role="collapsible">
	    		<h2> Case Investigation </h2>
	    		
	    		<ul data-role="listview" data-inset="true" data-theme="d" data-divider-theme="d">
						<li data-role="list-divider"> Plot investigated case </li>
						<li><a href="uninvestigated_cases">
							<h3>Case List</h3>
							<p><strong>Please click this link to see a list of uninvestigated cases.</strong></p>
						</a></li>
	    		</ul>
	    		<!--
				<ul data-role="listview" data-inset="true" data-divider-theme="d">
						<li data-role="list-divider"> Case Entry </li>
	    			<li> Please use the PIDSR Form and re-enter it in a designated terminal at the center </li>
				</ul>
				-->
	    	</div>
	    	<!-- /end Single Case Report/Investigation -->
    	</div>
    	<!-- /end Data Collapsible -->
        
        <!-- 
        <ul data-role="listview" data-autodividers="true" data-inset="true">
        	<li> <a href="<?php //echo site_url('mobile/page/point_of_interest');?>" data-ajax="false" data-transition="slide"> Point of Interest </a> </li>
        	<li> <a href="<?php //echo site_url('mobile/page/larval_survey');?>" data-ajax="false" data-transition="slide"> Larval Occurrence </a> </li>
        	<li> <a href="<?php //echo site_url('mobile/immediate_case');?>" data-ajax="false" data-transition="slide"> Single Case Report </a> </li>
        </ul>
        <br/><br/>
        -->
    </div><!-- /content -->
	
</div><!-- /page -->
</body>
</html>