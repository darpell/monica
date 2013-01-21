<html>
<head>
<title>TEST</title>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/scripts/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/scripts/polygon.min.js"></script>
		<script type="text/javascript">
		function load() {
			  //create map
			 var singapoerCenter=new google.maps.LatLng(1.37584, 103.829);
			 var myOptions = {
			  	zoom: 10,
			  	center: singapoerCenter,
			  	mapTypeId: google.maps.MapTypeId.ROADMAP
			  };
			 map = new google.maps.Map(document.getElementById('map'), myOptions);
			 
			 var creator = new PolygonCreator(map);

			 //reset
			 $('#reset').click(function(){ 
			 		creator.destroy();
			 		creator=null;
			 		
			 		creator=new PolygonCreator(map);
		 			$('#dataPanel').append('<b>Polygon cleared</b><br/>');
		 			$("#dataPanel").scrollTop($("#dataPanel")[0].scrollHeight);
			 });
			 //reset
			 $('#save').click(function(){ 
				 if(null==creator.showData()){
			 			$('#dataPanel').append('<b>Please first create a polygon</b><br/>');
			 			$("#dataPanel").scrollTop($("#dataPanel")[0].scrollHeight);
			 		}else{
			 			$('#dataPanel').append('<b>Polygon saved</b>: '+creator.showData()+'<br/>');
			 			$("#dataPanel").scrollTop($("#dataPanel")[0].scrollHeight);
			 			alert("HOORAY!");
			 			document.getElementById("hide").value = creator.showData();
			 			document.forms["myform"].submit();
			 		}
			 });
		};	

		</script>
</head>
<body onload="load()">
	<table border="1" width=100%>
<tr>
	<td style="width:49%" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td style="width:49%; height:400px">
		<input id="reset" value="Reset" type="button" class="navi"/>
		
		<!-- <form action="" method='post' onsubmit='return confirm("Sure?")'> -->
		
		<?php 
		$fdata = array(
              'name'   => 'myform'
            );
		echo form_open('addmap/addPolygon',$fdata); ?>
		<?php 
		echo form_dropdown('NDtypeddl', $options, $options[0]);
		?>
		<input type="hidden" id='hide' name="hide">
		<input id="save" value="Submit" type="button" class="navi"/>
		<!--<input id="save" value="Submit" type="submit" class="navi"/>-->
		</form> 
	</td>
</tr>
<tr>
	<td style="width:49%">
		<div id='dataPanel' class="dataPanel"></div>
	</td>
</tr>
</table> 
 
</body>
</html>