<?php
//$attributes = array(
//						'id' => 'TPcr-form'
//					);
//echo form_open('mapping/mapByType'); 
?>
<html>
<head>
<title>TEST</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

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

	function load(){

		var map = new google.maps.Map(document.getElementById("map"), {
	        center: new google.maps.LatLng(1.690276, 103.866119),
	        zoom: 9,
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
			  		
			  		for (var i = 0; i < data.length; i++)
			  		{
			  			nodeType[i] = data[i][0];		
			  			refNumber[i] = data[i][1];
			  			lat[i] = data[i][2];
			  			lng[i] = data[i][3];
			  		}
			          
				      var infoWindow = new google.maps.InfoWindow;
				
				//
					
					//alert(document.getElementById('type').value);
					    
				            for (var i = 0; i < data.length; i++) 
				            //*
				            {
				            var address = refNumber[i];
				            
				            var type = nodeType[i];
				            var point = new google.maps.LatLng(
				                parseFloat(lat[i]),
				                parseFloat(lng[i]));
				            var html = "<b>" + name + "</b> <br/>" + address;
				            var icon = customIcons[type] || {};
				            var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+refNumber[i]+'|ff776b';
				            var marker = new google.maps.Marker({
				              map: map,
				              position: point,
				              icon: image,
				              shadow: icon.shadow
				            });
							
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
							bindInfoWindow(marker, map, infoWindow, html);
							
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
					var bcount = new Array();
					var bcount=splitter(document.getElementById('dataCount').value.toString());
					alert(document.getElementById('dataCount').value.toString());
					var ctr = 0;
					
					var str = document.getElementById('data').value.toString();
					str = str.split("%%");
					
					var data2 = new Array();
					for (var i = 0; i < str.length; i++)
					{
						data2[i] = str[i].split("&&");
					}
					while(ctr <= data2.length-1)
					{
					var twicearea=0,
				       x=0, y=0,
				       nPts = data2.length,
				       p1, p2, f;
				   for (var i=0, j=nPts-1 ;i<nPts;j=i++) {
				      p1=data2[i]; p2=data2[j];
				      twicearea+=p1.x*p2.y;
				      twicearea-=p1.y*p2.x;
				      f=p1.x*p2.y-p2.x*p1.y;
				      x+=(p1.x+p2.x)*f;
				      y+=(p1.y+p2.y)*f;
				   }
				   f=twicearea*3;

				   if(bcount[_i][1]!=null)
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[_i][1]+":"+bcount[_i][2]+'|ff776b';
					else
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=0|ff776b';

					var point = new google.maps.LatLng( x/f,y/f);
					var icon = customIcons[type] || {};
		            var centroidMarker = new google.maps.Marker({
		              map: map,
		              position: point,
		              icon: image,
		              shadow: icon.shadow
		            });
		           
					bermudaTriangle.setMap(map);
					ctr++;
				}
					
				}
	}
function sa() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(1.690276, 103.866119),
        zoom: 9,
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
		  		
		  		for (var i = 0; i < data.length; i++)
		  		{
		  			nodeType[i] = data[i][0];		
		  			refNumber[i] = data[i][1];
		  			lat[i] = data[i][2];
		  			lng[i] = data[i][3];
		  		}
		          
			      var infoWindow = new google.maps.InfoWindow;
			
			//
				
				//alert(document.getElementById('type').value);
				    
			            for (var i = 0; i < data.length; i++) 
			            //*
			            {
			            var address = refNumber[i];
			            
			            var type = nodeType[i];
			            var point = new google.maps.LatLng(
			                parseFloat(lat[i]),
			                parseFloat(lng[i]));
			            var html = "<b>" + name + "</b> <br/>" + address;
			            var icon = customIcons[type] || {};
			            var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+refNumber[i]+'|ff776b';
			            var marker = new google.maps.Marker({
			              map: map,
			              position: point,
			              icon: image,
			              shadow: icon.shadow
			            });
						
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
						bindInfoWindow(marker, map, infoWindow, html);
						
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
				var bcount = new Array();
				var bcount=splitter(document.getElementById('dataCount').value.toString());
				//alert(document.getElementById('dataCount').value.toString());
				
				var str = document.getElementById('data').value.toString();
				str = str.split("%%");
				var x1=999;
				var x2=-999;
				var y1=999;
				var y2=-999;
				var data2 = new Array();
				for (var i = 0; i < str.length; i++)
				{
					data2[i] = str[i].split("&&");
				}
				// data [i][0] = polyid
				// data [i][1] = lat 
				// data [i][2] = lng
				 				
				//alert(nodes[0]);
				//var latLng =[];
				//var locs = [];
				
				//for (var _p=0; _p <= (data2[data2.length-2][0]); _p++) 
				//{	
					//locs = nodes[_p];
					//for (_i = 0, _len = locs.length; _i < _len; _i++)  
					var ctr2 = 0;
					for (var _i=0; _i <= data2[data2.length-2][0]; _i++)
					{	//point = locs[_i];
						var  latLng = [];
						var bermudaTriangle = [];
						
						var ctr = 0;
						if(ctr2>0)
							ctr = ctr2;
						//alert("ctr: "+ctr);
						//alert(data2.length-1);
						while(ctr <= data2.length-1)
						{
							if (_i == data2[ctr][0])
							{
								if(parseFloat(data2[ctr][1]) < x1)
								{x1=parseFloat(data2[ctr][1]);}
								if(parseFloat(data2[ctr][2]) < y1)
								{y1=parseFloat(data2[ctr][2]);}
								if(parseFloat(data2[ctr][1]) > x2)
								{x2=parseFloat(data2[ctr][1]);}
								if(parseFloat(data2[ctr][2]) > y2)
								{y2=parseFloat(data2[ctr][2]);}
								
								latLng.push(new google.maps.LatLng(parseFloat(data2[ctr][1]), parseFloat(data2[ctr][2])));
								//alert(_i == data2[ctr][0]);
								//alert(ctr);
							}
							else
							{
								bermudaTriangle = new google.maps.Polygon(
										{
											paths: latLng,
											fillColor: "#FF0000",
											fillOpacity:0.3
										});
								//if(x1<0)
								//	var x = x1 + ((x2 - ((-1)*x1)) * 0.5);
								//else
									var centroidX = x1 + ((x2 - x1) * 0.5);
								//if(x1<0)
								//	var x = x1 + ((x2 - ((-1)*x1)) * 0.5);
								//else
									var centroidY = y1 + ((y2 - y1) * 0.5);
								//alert("midX: "+centroidX+" midY: "+centroidY);
								
								if(bcount[_i][1]!=null)
									var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+bcount[_i][1]+":"+bcount[_i][2]+'|ff776b';
								else
									var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=0|ff776b';

								var point = new google.maps.LatLng(centroidX,centroidY);
								var icon = customIcons[type] || {};
					            var centroidMarker = new google.maps.Marker({
					              map: map,
					              position: point,
					              icon: image,
					              shadow: icon.shadow
					            });
					           
								bermudaTriangle.setMap(map);

								//alert("insert");
								ctr2 = ctr;
								//alert(ctr); 
								ctr = data2.length;
								x1=999;
								x2=-999;
								y1=999;
								y2=-999;
							}
							ctr++;
						}
					}
				//}
			//end of IF
        	}
	
}
  function bindInfoWindow(marker, map, infoWindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
  	  var info ='<?php print $nodes;?><a href="http://www.google.com"> check google! </a>';
      infoWindow.setContent(info);
      infoWindow.open(map, marker);
    });
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
		</h4></div>
		<?php 
		$options=array(
			"denguecase"=>"denguecase",
			"larvalpositive"=>"larvalpositive"
		);
		echo form_dropdown('NDtype-ddl', $options, "denguecase");
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
</body>
</html>