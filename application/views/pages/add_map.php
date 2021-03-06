<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/scripts/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>/scripts/polygon.min.js"></script>
		<script type="text/javascript">
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
			var icon = customIcons[type] || {};
			if(image===null)
			{
				centroidMarker = new google.maps.Marker({
				  position: point,
				  map: map,
				  shadow: icon.shadow
				});
			}
			else
			{
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
				//info=info+' <a href="http://www.google.com"> DELETE BOUNDARY</a>';
				infoWindow.setContent(info);
				infoWindow.open(map, this);
			});
		}
		function load() {
			  //create map
			 var myOptions = {
				center: new google.maps.LatLng(14.291416, 120.930206),
				zoom: 13,
			  	mapTypeId: google.maps.MapTypeId.ROADMAP
			  };
			 map = new google.maps.Map(document.getElementById('map'), myOptions);

			 ////////////////////////////////////////
			 //
			 //
			 //
			 ////////////////////////////////////////			 
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
					var problem=false;
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
							problem=true;
						}
						else if(!problem)
						{
							currPoly++;
						}
						else
						{//alert("Current polygon index number "+currPoly+" != "+data2[_i][0]+" latLng contains "+latLng);

							//*CREATION OF POLYGON
							var bermudaTriangle = new google.maps.Polygon(
									{
										paths: latLng,
										fillColor: "#FF0000",
										fillOpacity:0.3,
										clickable: false
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
			 ////////////////////////////////////////
			 //
			 //
			 //
			 ////////////////////////////////////////
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
			 			alert("Polygon has been created.");
			 			document.getElementById("hide").value = creator.showData();
			 			document.forms["myform"].submit();
			 		}
			 });
		};	

		</script>
</head>
<form>
<input type = 'hidden' id ='data' name='data' value='<?php echo $nodes?>'>
<input type = 'hidden' id ='dataCount' name='dataCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
</form>
<body onload="load()">
<div class="body">
		
	<table border="1" width=100%>
<tr>
	<td style="width:60%" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td style="width:40%; height:400px">
	<h2>Barangay Boundary Creation</h1><br/>
	<table border='1'>
		<tr><td width='75px'><b>Step 1: </b></td><td>Create a polygon in the map provided to the left.</td></tr>
		<tr><td>Step 1.1: </td><td>After placing the nodes, click the first node to close the polygon.</td></tr>
		<tr><td>Step 1.2: </td><td>Click reset to clear the polygon should you make a mistake.</td></tr>
		<tr><td><b>Step 2: </b></td><td>Choose the barangay name from the dropdown, it contains all the barangays in the database that do not yet have a polygon associated with it.</td></tr>
		<tr><td><b>Step 3: </b></td><td>Click submit to add the polygon to the database.</td></tr>
		</table><br/><br/>
		<input id="reset" value="Reset" type="button" class="navi"/>
		
		<!-- <form action="" method='post' onsubmit='return confirm("Sure?")'> -->
		
		<?php 
		//print_r($options);
		$fdata = array(
              'name'   => 'myform'
            );
		echo form_open('addmap/addPolygon',$fdata); ?>
		<?php 
		echo form_dropdown('NDtypeddl', $options);
		//print_r($options);
		?>
		
		<input type="hidden" id='hide' name="hide">
		<input id="save" value="Submit" type="button" class="navi"/>
		<!--<input id="save" value="Submit" type="submit" class="navi"/>-->
		</form> 
	</td>
</tr>
<tr>
	<td style="width:40%">
		<div id='dataPanel' class="dataPanel"></div>
	</td>
</tr>
</table>
</div>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>