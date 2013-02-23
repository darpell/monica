<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script>
var infoWindow = new google.maps.InfoWindow({});
var customIcons = {
		  larvalpositive: {
	        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
	        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
	      },
	      denguecase: {
	        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
	        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
	      }
	    };

function splitter(str){
	
	str = str.split("%%");
	
	var data = new Array();
	for (var i = 0; i < str.length; i++)
	{
		data[i] = str[i].split("&&");
	}
	return data;
	}

	var refNumber = new Array();
	var nodeType = new Array();
	var lat = new Array();
	var lng = new Array();

function createMarker(map,point,image,info)
{
	var centroidMarker;
	if(image==null)
	{
		centroidMarker = new google.maps.Marker({
		  position: point,
		  map: map,
		  shadow: icon.shadow
		});
	}
	else
	{
		var icon = customIcons[type] || {};
	    centroidMarker = new google.maps.Marker({
	      map: map,
	      position: point,
	      icon: image,
	      shadow: icon.shadow
	    });
	}

	 /*
	centroidMarker.info = new google.maps.InfoWindow({
		content: info
	});
	//*/
	  
	google.maps.event.addListener(centroidMarker, 'mouseover', function() {
		infoWindow.setContent(info);
		infoWindow.open(map, this);
	});
}
	
function load() {
	
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(14.291416, 120.930206),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
		
    	//---------------------------------------------------------
    	//
    	//LARVAL SURVEY
    	//
    	//---------------------------------------------------------
    	
      if(document.getElementById('type').value.toString()=="larvalpositive")
          {
		  	
		  		var nodes = document.getElementById("data").value;
		  		var data = splitter(nodes);
		  		alert(data);
		  		
		  		for (var i = 0; i < data.length; i++)
		  		{
		  			nodeType[i] = data[i][0];		
		  			refNumber[i] = data[i][1];
		  			lat[i] = data[i][2];
		  			lng[i] = data[i][3];
		  		}
		  		
			    for (var i = 0; i < data.length; i++) 
			    {
			    	var address = refNumber[i];
			            
			    	var type = nodeType[i];
			   		var point = new google.maps.LatLng(
			        	parseFloat(lat[i]),
			        	parseFloat(lng[i]));
			    	var html = "<b>" + name + "</b> <br/>" + address;
			   		//var icon = customIcons[type] || {};
			  		var image = 'http://mapicons.nicolasmollet.com/wp-content/uploads/mapicons/shape-default/color-128e4d/shapecolor-light/shadow-1/border-white/symbolstyle-dark/symbolshadowstyle-no/gradient-no/eggs.png';
			            
			 		createMarker(map,point,image,html);
			 		var circle = new google.maps.Circle({
						center:point,
						radius:200,
						strokeColor:"#0000FF",
						strokeOpacity:0.8,
						strokeWeight:2,
						fillColor:"#0000FF",
						fillOpacity:0.4
					});
					circle.setMap(map); 
				}
      		}
			//end of IF
			//VIEW BOUNDARY
			
	      	//---------------------------------------------------------
	      	//
	      	//DENGUE CASES
	      	//
	      	//---------------------------------------------------------
	      	
			else if(document.getElementById('type').value.toString()=="denguecase")
			{
				//*DECLARATION OF VALUES AND CONTAINERS
				var x1=999;
				var x2=-999;
				var y1=999;
				var y2=-999;
				var currPoly = 1;
				var latLng = [];
				var bcount=splitter(document.getElementById('dataCount').value.toString());
				//-------------------*/
				
				//*STRING SPLITTER
				var str = document.getElementById('data').value.toString();
				str = str.split("%%");
				var data2 = new Array();
				for (var i = 0; i < str.length; i++)
				{
					data2[i] = str[i].split("&&");
				}alert(data2);alert(bcount);
				//-------------------*/
				
				for (var _i=0; _i <= data2.length-1;)
				{//alert("Iterating through index "+_i);
					if(currPoly==data2[_i][0])
					{//alert("Current polygon index number "+currPoly+" == "+data2[_i][0]);
						//*CENTROID LOCATOR
						if(parseFloat(data2[_i][1]) < x1)
						{x1=parseFloat(data2[_i][1]);}
						if(parseFloat(data2[_i][2]) < y1)
						{y1=parseFloat(data2[_i][2]);}
						if(parseFloat(data2[_i][1]) > x2)
						{x2=parseFloat(data2[_i][1]);}
						if(parseFloat(data2[_i][2]) > y2)
						{y2=parseFloat(data2[_i][2]);}
						//-------------------*/

						latLng.push(new google.maps.LatLng(parseFloat(data2[_i][1]), parseFloat(data2[_i][2])));
						//alert("Added "+latLng[latLng.length-1]+" to list.");
						_i++;
					}
					else
					{//alert("Current polygon index number "+currPoly+" != "+data2[_i][0]+" latLng contains "+latLng);

						//*CREATION OF POLYGON
						var bermudaTriangle = new google.maps.Polygon(
								{
									paths: latLng,
									fillColor: "#FF0000",
									fillOpacity:0.3
								});
						//-------------------*/
						
						//*CREATION OF CENTROID POINT
						var centroidX = x1 + ((x2 - x1) * 0.5);
						var centroidY = y1 + ((y2 - y1) * 0.5);
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[currPoly-1][1]+'|ff776b';
						var point = new google.maps.LatLng(centroidX,centroidY);
						createMarker(map,point,image,bcount[currPoly-1][0]);
						//-------------------*/
			           
						bermudaTriangle.setMap(map);
						latLng = [];

						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						currPoly++;					
					}
				}
				//alert(bcount[currPoly-1][1]);
				var bermudaTriangle = new google.maps.Polygon(
						{
							paths: latLng,
							fillColor: "#FF0000",
							fillOpacity:0.3
						});
				//-------------------*/
				
				//*CREATION OF CENTROID POINT
				var centroidX = x1 + ((x2 - x1) * 0.5);
				var centroidY = y1 + ((y2 - y1) * 0.5);
				var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[currPoly-1][1]+'|ff776b';
				var point = new google.maps.LatLng(centroidX,centroidY);
				createMarker(map,point,image,bcount[currPoly-1][0]);
				//-------------------*/
	           
				bermudaTriangle.setMap(map);
        	}//end of IF
			//VIEW BOUNDARY
			
	      	//---------------------------------------------------------
	      	//
	      	//BOTH OVERLAYS
	      	//
	      	//---------------------------------------------------------
	      				
        	else
        	{
            	//*Data handler, SPLITTER
				var str = document.getElementById('data').value.toString();
				str = str.split("%&");
				var dataLarval = splitter(str[0]);
				var dataDengue = splitter(str[1]);
				//alert (dataLarval);
				//alert (dataDengue);
				//-------------------*/
				
        		//*DECLARATION OF VALUES AND CONTAINERS
				var x1=999;
				var x2=-999;
				var y1=999;
				var y2=-999;
				var currPoly = 1;
				var latLng = [];
				var bcount=splitter(document.getElementById('dataCount').value.toString());
				//-------------------*/
				
				for (var _i=0; _i <= dataDengue.length-1;)
				{//alert("Iterating through index "+_i);
					if(currPoly==dataDengue[_i][0])
					{//alert("Current polygon index number "+currPoly+" == "+data2[_i][0]);
						//*CENTROID LOCATOR
						if(parseFloat(dataDengue[_i][1]) < x1)
						{x1=parseFloat(dataDengue[_i][1]);}
						if(parseFloat(dataDengue[_i][2]) < y1)
						{y1=parseFloat(dataDengue[_i][2]);}
						if(parseFloat(dataDengue[_i][1]) > x2)
						{x2=parseFloat(dataDengue[_i][1]);}
						if(parseFloat(dataDengue[_i][2]) > y2)
						{y2=parseFloat(dataDengue[_i][2]);}
						//-------------------*/

						latLng.push(new google.maps.LatLng(parseFloat(dataDengue[_i][1]), parseFloat(dataDengue[_i][2])));
						//alert("Added "+latLng[latLng.length-1]+" to list.");
						_i++;
					}
					else
					{//alert("Current polygon index number "+currPoly+" != "+data2[_i][0]+" latLng contains "+latLng);

						//*CREATION OF POLYGON
						var bermudaTriangle = new google.maps.Polygon(
								{
									paths: latLng,
									fillColor: "#FF0000",
									fillOpacity:0.3
								});
						//-------------------*/
						
						//*CREATION OF CENTROID POINT
						var centroidX = x1 + ((x2 - x1) * 0.5);
						var centroidY = y1 + ((y2 - y1) * 0.5);
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[currPoly-1][1]+'|ff776b';
						var point = new google.maps.LatLng(centroidX,centroidY);
						createMarker(map,point,image,bcount[currPoly-1][0]);
						//-------------------*/
			           
						bermudaTriangle.setMap(map);
						latLng = [];

						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						currPoly++;					
					}
				}
				alert(bcount[currPoly-1][1]);
				var bermudaTriangle = new google.maps.Polygon(
						{
							paths: latLng,
							fillColor: "#FF0000",
							fillOpacity:0.3
						});
				//-------------------*/
				
				//*CREATION OF CENTROID POINT
				var centroidX = x1 + ((x2 - x1) * 0.5);
				var centroidY = y1 + ((y2 - y1) * 0.5);
				var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[currPoly-1][1]+'|ff776b';
				var point = new google.maps.LatLng(centroidX,centroidY);
				createMarker(map,point,image,bcount[currPoly-1][0]);
				//-------------------*/
	           
				bermudaTriangle.setMap(map);
				
            	
		  		for (var i = 0; i < dataLarval.length; i++)
		  		{
		  			nodeType[i] = dataLarval[i][0];		
		  			refNumber[i] = dataLarval[i][1];
		  			lat[i] = dataLarval[i][2];
		  			lng[i] = dataLarval[i][3];
		  		}
		  		
			    for (var i = 0; i < dataLarval.length; i++) 
			    {
			    	var address = refNumber[i];
			            
			    	var type = nodeType[i];
			   		var point = new google.maps.LatLng(
			        	parseFloat(lat[i]),
			        	parseFloat(lng[i]));
			    	var html = "<b>" + name + "</b> <br/>" + address;
			   		var icon = customIcons[type] || {};
			   		var image = 'http://mapicons.nicolasmollet.com/wp-content/uploads/mapicons/shape-default/color-128e4d/shapecolor-light/shadow-1/border-white/symbolstyle-dark/symbolshadowstyle-no/gradient-no/eggs.png';
			            
			 		createMarker(map,point,image,html);
			 		var circle = new google.maps.Circle({
						center:point,
						radius:200,
						strokeColor:"#0000FF",
						strokeOpacity:0.8,
						strokeWeight:2,
						fillColor:"#0000FF",
						fillOpacity:0.4
					});
					circle.setMap(map); 
				}
        	}

        
}
  function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

</head>
<form>
<input type = 'hidden' id ='data' name='data' value='<?php echo $nodes?>'>
<input type = 'hidden' id ='dataCount' name='dataCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
</form>
<body onload="load()">
<table border="1" width=100%>
<tr>
	<td style="width:69%; height:400px">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td style="width:30%; height:400px">
		<form action="" method='post' onsubmit='return confirm("Sure?")'>
		<label style="color:red"><?php echo form_error('NDtype-ddl'); ?></label>
		<div id="info" class="info"><h4>
		Select 'denguecase' to view dengue cases per area.<br />
		Select 'larvalpositive' to view positive larval samplings.<br />
		Select 'both' to view overlays displaying both larval positives and dengue cases.<br />
		</h4></div>
		<?php 
		$options=array(
			"denguecase"=>"denguecase",
			"larvalpositive"=>"larvalpositive",
			"both"=>"both"
		);
		echo form_dropdown('NDtype-ddl', $options, $node_type);
		?>
		<br />
		<br />
		
	    Search Date
		<br />
	    From: <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
	    To: <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
		<br />
		<div><input type="submit" value="Submit" /></div>
		</form> 
	</td>
</tr>
</table> 
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>