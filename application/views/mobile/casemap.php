<!DOCTYPE html>
<html>
<head>
	<title> Case Map </title>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
	<script type="text/javascript" charset="utf-8" src="cordova-2.2.0.js"></script>
	
	<link rel="stylesheet" href="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.css" />
    <script src="js\jquery-1.8.2.js"></script>
    <script src="js\jquery.mobile-1.2.0\jquery.mobile-1.2.0.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js" type="text/javascript"></script>
	<script src="js\jquery-ui-map-3.0\ui\min\jquery.ui.map.full.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js\jquery-ui-map-3.0\ui\jquery.ui.map.js"></script>


<script type="text/javascript">
    
	var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
	var infoWindow = new google.maps.InfoWindow({});
	var customIcons = {
		      denguecase: {
		        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
		        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
		      }
		    };

	function splitter(str)
	{
		
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
		  
		google.maps.event.addListener(centroidMarker, 'mouseover', function() {
			infoWindow.setContent(info);
			infoWindow.open(map, this);
		});
	}
		
function initialize()
{
	var map = new google.maps.Map(document.getElementById("googleMap"), {
        center: new google.maps.LatLng(14.291416, 120.930206),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
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
}

function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<style type="text/css">
html {height:100%}
body {height:100%;margin:0;padding:0}
#googleMap {height:100%}
</style>
</head>
<input type = 'hidden' id ='data' name='data' value='<?php echo $nodes?>'>
<input type = 'hidden' id ='dataCount' name='dataCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<body>
<div data-role="page" style="position:absolute;top:0;left:0; right:0; bottom:0;width:100%; height:100%">
	<div data-role="header" ><!-- data-position="fixed"> -->
    	<h2> Case Map </h2> 
    	<a href="<?php echo site_url('mobile/case_dialog');?>" data-rel="panel" data-icon="gear" class="ui-btn-right" data-transition="slide"> Filter Results </a>
    	<a href="<?php echo site_url('mobile/casemap');?>" data-rel="panel" data-icon="gear" class="ui-btn-left" data-ajax="false"> Show All </a>
    </div> <!-- /header-->
	<div data-role="content" style="width:100%; height:100%">

		<div id="googleMap"></div>
	
	</div><!-- /content -->
</div><!-- /page -->
</body>
</html>