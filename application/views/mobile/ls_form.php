<!-- HEADER -->
<?php echo $this->load->view('mobile/templates/mob_header'); ?>

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
    <script type="text/javascript">
	        $(document).ready(function(){
	        	inputMapVar = $('input[name*="_r"]');

	        	$('#contentDialog').hide();
	            $('#contentTransition').hide();

	            $('#buttonOK').click(function() {
			    	$('#contentDialog').hide();
			        showMain();
			        return false;      
			      });

	            $('#ls_form').submit(function(){
					var err = false;
			        // Hide the Main content
			        hideMain();
			        
			        // Perform form validation
			        inputMapVar.each(function(index){  
			        if($(this).val() == null || $(this).val() == EMPTY){  
			            $(this).prev().addClass(MISSING);            
			            err = true;
			          }          
			        });
			        
			        // If validation fails, show Dialog content
			        if(err == true){            
			        	$('#contentDialog').show();
			          return false;
			        }        
			        
			        // If validation passes, show Transition content
			        $('#contentTransition').show();
				});
			});
			
		    function hideMain(){  
			        $('#ls_header').hide();  
			        $('#ls_content').hide();
			    }  
			    
			    function showMain(){  
			        $('#ls_header').show();  
			        $('#ls_content').show();
			    }
        </script>
</head> 
<body onload="initialize()">

<div data-role="page" id="page2" style="width:100%; height:100%;">
    <div data-role="header" id="ls_header" name="ls_header" data-nobackbtn="true">
        <h3>Larval Survey Report</h3>
    </div><!-- /header -->
    <div data-role="content" id="ls_content">
    
<form id="ls_form" action="addls" method="post" data-ajax="false">

<!-- TODO 
	fix unneeded form inputs
-->

	<!-- name of inspector -->
	<label for="TPinspector-txt">Name of Inspector:</label>
	<label style="color:red"><?php echo form_error('TPinspector-txt_r'); ?></label>
	<input type="text" name="TPinspector-txt_r" id="TPinspector-txt" value="" data-mini="true" />
	<!-- /name of inspector -->

	<!-- date -->
	<label for="TPdate-txt"> Date: </label>
	<label style="color:red"><?php echo form_error('TPdate-txt_r'); ?></label>
	<input type="date" name="TPdate-txt_r" id="TPdate-txt" value="<?php echo date("Y-m-d");?>" data-mini="true" readonly />
	<!-- /date -->

	<!-- barangay -->
	<label for="TPbarangay-txt"> Barangay: </label>
	<label style="color:red"><?php echo form_error('TPbarangay-txt_r'); ?></label>
	<input type="text" name="TPbarangay-txt_r" id="TPbarangay-txt" data-mini="true" />
	<!-- /barangay -->
	
	<!-- lat & lng -->
	<input type="hidden" name="lat" id="lat" />
	<input type="hidden" name="lng" id="lng" />
	<!-- /lat & lng -->
	
	<!-- street -->
	<label for="TPstreet-txt"> Street: </label>
	<label style="color:red"><?php echo form_error('TPstreet-txt_r'); ?></label>
	<input type="text" name="TPstreet-txt_r" id="TPstreet-txt" data-mini="true" />
	<!-- /street -->

	<!-- municipality -->
	<label for="TPmunicipality-txt"> Municipality: </label>
	<label style="color:red"><?php echo form_error('TPmunicipality-txt_r'); ?></label>
	<input type="text" name="TPmunicipality-txt_r" id="TPmunicipality-txt" data-mini="true" />
	<!-- /municipality -->

	<!-- household -->
	<label for="TPhousehold-txt"> Name of Household: </label>
	<label style="color:red"><?php echo form_error('TPhousehold-txt_r'); ?></label>
	<input type="text" name="TPhousehold-txt_r" id="TPhousehold-txt" value="<?php echo set_value('patientno'); ?>" data-mini="true" />
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
	<input type="text" name="TPcontainer-txt_r" id="TPcontainer-txt" value="<?php echo set_value('TPcontainer-txt'); ?>" data-mini="true" />
	<!-- /container -->

	<div>
		<input type="submit" value="Submit" />
	</div>

</form>

    </div><!-- /content -->
    <!-- Dialogs -->
          <div align="CENTER" data-role="content" id="contentDialog" name="contentDialog">	
	 <div>Please fill in all required fields before submitting the form.</div>
	 <a id="buttonOK" name="buttonOK" href="#page2" data-role="button" data-inline="true">OK</a>
	</div>	<!-- contentDialog -->
	
  	<!-- contentTransition is displayed after the form is submitted until a response is received back. -->
	<div data-role="content" id="contentTransition" name="contentTransition">	
	 <div align="CENTER"><h4>Please wait while your data is being entered.</h4></div>
	 <div align="CENTER"><img id="spin" name="spin" src="images/wait.gif"/></div>
	</div>	<!-- contentTransition -->

	<!-- /dialogs -->
</div><!-- /page -->

</body>
</html>