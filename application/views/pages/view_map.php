<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>

<script>
function loadXMLDoc(q)
{
	

var xmlhttp;
if (q=="")
  {
	  
  //document.getElementById("txtHint").innerHTML="";
  //return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 
xmlhttp.onreadystatechange=function()
  {
	
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
   // document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    alert(xmlhttp.responseText);
    }
  }
  var url = 'http://localhost/workspace/monica/index.php/case_report/get_denguecases/' + q;
  xmlhttp.open("post",url,false);
xmlhttp.send(null);

}
var infoWindow = new google.maps.InfoWindow();
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
	var id=new Array();
	var household = new Array();
	var container = new Array();

function createMarker(map,point,image,info)
{
	var centroidMarker;
	var oms = new OverlappingMarkerSpiderfier(map);
	if(image === null)
	{
		centroidMarker = new google.maps.Marker({
		  position: point,
		  map: map
		});
		oms.addMarker(centroidMarker);
	}
	else
	{
		var icon = customIcons[type] || {};
	    centroidMarker = new google.maps.Marker({
	      map: map,
	      position: point,
	      icon: image
	    });
	    oms.addMarker(centroidMarker);
	}

	 /*
	centroidMarker.info = new google.maps.InfoWindow({
		content: info
	});
	//*/
	  
	google.maps.event.addListener(centroidMarker, 'click', function() {
		infoWindow.setContent(info);
		infoWindow.open(map, this);

	});
	
		google.maps.event.addListener(centroidMarker, 'click', function() {
			loadXMLDoc(info);
	});
	/*google.maps.event.addListener(centroidMarker, 'onClick', function() {
		
	});*/
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
				var dist = splitter(document.getElementById('dist').value.toString());
		  		var nodes = document.getElementById("data").value;
		  		var data = splitter(nodes);
		  		//alert(dist);
		  		for (var i = 0; i < data.length; i++)
		  		{
		  			nodeType[i] = data[i][0];		
		  			refNumber[i] = data[i][1];
		  			lat[i] = data[i][2];
		  			lng[i] = data[i][3];
		  			id[i]=data[i][4];
		  			household[i]=data[i][5];
		  			container[i]=data[i][6];
		  		}//alert(household);alert(container);
		  		
			    for (var i = 0; i < data.length; i++) 
			    {
				    var amount50a="fail";
				    var amount50p="fail";
				    var amount200a="fail";
				    var amount200p="fail";
				    for(var _i=0; _i < data.length; _i++)
				    {
					    //alert("Comparing "+id[i]+" to "+dist[_i][0]);
					    if(id[i]===dist[_i][0])
					    {
					    	 amount50a=dist[_i][1];
							 amount50p=dist[_i][2];
							 amount200a=dist[_i][3];
							 amount200p=dist[_i][4];
					    }
				    }			            
			    	var type = nodeType[i];
			    	var householdcount=0;
			    	var containercount=0;
			    	var householdpercent;
			    	var containerpercent;
		        	for(var __i=0; __i < household.length;__i++)
		        	{
			        	if(household[i]===household[__i])
			        	{
			        		householdcount++;
			        	}
		        	}
		        	for(var __i=0; __i < container.length;__i++)
		        	{
			        	if(container[i]===container[__i])
			        	{
			        		containercount++;
			        	}
		        	}
		        	householdpercent=householdcount/household.length*100;
		        	containerpercent=containercount/container.length*100;
			   		var point = new google.maps.LatLng(
			        	parseFloat(lat[i]),
			        	parseFloat(lng[i]));
			    	var html = "<b>Larval Survey Report #: </b>" + refNumber[i] 
			    	+ " <br/>" + "<b>Tracking #: </b>" + dist[i][0]
			    	+ " <br/>" + "<b>Amount of Nodes within 200m: </b>" + amount50a+" ("+ amount50p+"%)"
			    	+ " <br/>" + "<b>Amount of Nodes within 50m: </b>" + amount200a+" ("+ amount200p+"%)"
			    	+ "<br/><br/>" + "<b>Household: </b>" + household[i]+" ("+ householdcount+"/"+ household.length +" occurances, "+householdpercent.toFixed(2)+"%)"
			    	+ " <br/>" + "<b>Container: </b>" + container[i]+" ("+ containercount+"/"+ container.length +" occurances, "+containerpercent.toFixed(2)+"%)";
			   		//var icon = customIcons[type] || {};
			   		if((amount50p>=25)||(amount200p>=50))
			  		var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=!|FF0000|000000';
			  		else
			  		var image = null;
			            
			 		createMarker(map,point,image,html);
			 		var circle = new google.maps.Circle({
						center:point,
						//radius:0.002328109220390699168278872384883,
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
				var nodeInfoCounter=0;
				var bcount=splitter(document.getElementById('dataCount').value.toString());
				//-------------------*/
				
				//*STRING SPLITTER
				var str = document.getElementById('data').value.toString();
				str = str.split("%%");
				var data2 = new Array();
				for (var i = 0; i < str.length; i++)
				{
					data2[i] = str[i].split("&&");
				}
				//alert(data2);
				//alert(bcount);
				//-------------------*/
				
				for (var _i=0; _i <= data2.length-1;)
				{//alert("Iterating through index "+_i);
					if(currPoly==data2[_i][0])
					{//alert("Current polygon index number "+currPoly+" == "+data2[_i][0]);
						currName=data2[_i][3];
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
						
						//*BARANGAY MARKER INFORMATION EXTRACTION
						var locationname="";
						var casecount=0;
						for(i=0;i<=bcount.length-1;i++)
						{
							if(bcount[i][0]===currName)
							{
								locationname=bcount[i][0];//alert(locationname);
								casecount=bcount[i][1];
							}
						}
						//-------------------*/
						
						//*CREATION OF CENTROID POINT
						var centroidX = x1 + ((x2 - x1) * 0.5);
						var centroidY = y1 + ((y2 - y1) * 0.5);
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
						var point = new google.maps.LatLng(centroidX,centroidY);
						createMarker(map,point,image,locationname);
						nodeInfoCounter++;
						//-------------------*/
			           
						bermudaTriangle.setMap(map);
						latLng = [];

						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						currPoly++;
						while(currPoly!=data2[_i][0])
						{
							currPoly++;
						}	
					}
				}
				//*CREATION OF POLYGON
				var bermudaTriangle = new google.maps.Polygon(
						{
							paths: latLng,
							fillColor: "#FF0000",
							fillOpacity:0.3
						});
				//-------------------*/
				
				//*BARANGAY MARKER INFORMATION EXTRACTION
				var locationname="";
				var casecount=0;
				for(i=0;i<=bcount.length-1;i++)
				{
					if(bcount[i][0]===currName)
					{
						locationname=bcount[i][0];//alert(locationname);
						casecount=bcount[i][1];
					}
				}
				//-------------------*/
				
				//*CREATION OF CENTROID POINT
				var centroidX = x1 + ((x2 - x1) * 0.5);
				var centroidY = y1 + ((y2 - y1) * 0.5);
				var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
				var point = new google.maps.LatLng(centroidX,centroidY);
				createMarker(map,point,image,locationname);
				nodeInfoCounter++;
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
				var dist = splitter(document.getElementById('dist').value.toString());
				var bcount=splitter(document.getElementById('dataCount').value.toString());
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
				var nodeInfoCounter=0;
				//-------------------*/
				
				for (var _i=0; _i <= dataDengue.length-1;)
				{//alert("Iterating through index "+_i);
					if(currPoly==dataDengue[_i][0])
					{//alert("Current polygon index number "+currPoly+" == "+dataDengue[_i][0]);
						currName=dataDengue[_i][3];
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
						_i++;
					}
					else
					{//alert("Current polygon index number "+currPoly+" != "+dataDengue[_i][0]+" latLng contains "+latLng);

						//*CREATION OF POLYGON
						var bermudaTriangle = new google.maps.Polygon(
								{
									paths: latLng,
									fillColor: "#FF0000",
									fillOpacity:0.3
								});
						//-------------------*/
						
						//*BARANGAY MARKER INFORMATION EXTRACTION
						var locationname="";
						var casecount=0;
						for(i=0;i<=bcount.length-1;i++)
						{
							if(bcount[i][0]===currName)
							{
								locationname=bcount[i][0];
								casecount=bcount[i][1];
							}
						}
						//-------------------*/
						
						//*CREATION OF CENTROID POINT
						var centroidX = x1 + ((x2 - x1) * 0.5);
						var centroidY = y1 + ((y2 - y1) * 0.5);
						var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
						var point = new google.maps.LatLng(centroidX,centroidY);
						createMarker(map,point,image,locationname);
						nodeInfoCounter++;
						//-------------------*/
			           
						bermudaTriangle.setMap(map);
						latLng = [];

						x1=999;
						x2=-999;
						y1=999;
						y2=-999;
						currPoly++;
						while(currPoly!=dataDengue[_i][0])
						{
							currPoly++;
						}	
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
				
				//*BARANGAY MARKER INFORMATION EXTRACTION
				var locationname="";
				var casecount=0;
				for(i=0;i<=bcount.length-1;i++)
				{
					if(bcount[i][0]===currName)
					{
						locationname=bcount[i][0];
						casecount=bcount[i][1];
					}
				}
				//-------------------*/
				
				//*CREATION OF CENTROID POINT
				var centroidX = x1 + ((x2 - x1) * 0.5);
				var centroidY = y1 + ((y2 - y1) * 0.5);
				var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
				var point = new google.maps.LatLng(centroidX,centroidY);
				createMarker(map,point,image,locationname);
				nodeInfoCounter++;
				//-------------------*/
	           
				bermudaTriangle.setMap(map);
				
		  		for (var i = 0; i < dataLarval.length; i++)
		  		{
		  			nodeType[i] = dataLarval[i][0];		
		  			refNumber[i] = dataLarval[i][1];
		  			lat[i] = dataLarval[i][2];
		  			lng[i] = dataLarval[i][3];
		  			id[i]=dataLarval[i][4];
		  		}
		  		
			    for (var i = 0; i < dataLarval.length; i++) 
			    {
				    var amount50a="fail";
				    var amount50p="fail";
				    var amount200a="fail";
				    var amount200p="fail";
				    for(var _i=0; _i < dataLarval.length; _i++)
				    {
					    //alert("Comparing "+id[i]+" to "+dist[_i][0]);
					    if(id[i]===dist[_i][0])
					    {
					    	 amount50a=dist[_i][1];
							 amount50p=dist[_i][2];
							 amount200a=dist[_i][3];
							 amount200p=dist[_i][4];
					    }
				    }			            
			    	var type = nodeType[i];
			   		var point = new google.maps.LatLng(
			        	parseFloat(lat[i]),
			        	parseFloat(lng[i]));
			    	var html = "<b>Larval Survey Report #: </b>" + refNumber[i] 
			    	+ " <br/>" + "<b>Tracking #: </b>" + dist[i][0]
			    	+ " <br/>" + "<b>Amount of Nodes within 200m: </b>" + amount50a+" ("+ amount50p+"%)"
			    	+ " <br/>" + "<b>Amount of Nodes within 50m: </b>" + amount200a+" ("+ amount200p+"%)";
			   		//var icon = customIcons[type] || {};
			   		if((amount50p>=25)||(amount200p>=50))
			  		var image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=!|FF0000|000000';
			  		else
			  		var image = null;
			            
			 		createMarker(map,point,image,html);
			 		var circle = new google.maps.Circle({
						center:point,
						//radius:0.002328109220390699168278872384883,
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
<input type = 'hidden' id ='dist' name='dist' value='<?php echo $dist?>'>
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
		<div><input type="submit" value="Sort" /></div>
		</form> 
	</td>
</tr>
</table>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
