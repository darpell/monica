<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script><script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load('visualization', '1.1', {packages: ['controls','corechart']});
</script>
<script type="text/javascript">
function drawVisualization() {
	
}
</script>
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
   	//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    //alert(xmlhttp.responseText);
    }
  };
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

function splitter(str){//Data splitter
	
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
	var createdOn = new Array();
	

function createMarker(map,point,image,info,bounce,isOld){//General marker creation
	var centroidMarker;
	var oms = new OverlappingMarkerSpiderfier(map);
	if(image === null)
	{
		if(isOld===false)
		{
			centroidMarker = new google.maps.Marker({
			  position: point,
			  map: map
			});
			oms.addMarker(centroidMarker);
			if(bounce !== null)
			{
			    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
			}
		}
		else
		{
			centroidMarker = new google.maps.Marker({
				  position: point,
				  map: map,
			      icon: new google.maps.MarkerImage('https://maps.gstatic.com/mapfiles/ms2/micons/ltblue-dot.png'),
			      shadow: new google.maps.MarkerImage('http://maps.gstatic.com/intl/en_us/mapfiles/markers/marker_sprite.png', 
			    	      new google.maps.Size(37,34), 
			    	      new google.maps.Point(20, 0), 
			    	      new google.maps.Point(10, 34))
				});
				oms.addMarker(centroidMarker);
				if(bounce !== null)
				{
				    centroidMarker.setAnimation(google.maps.Animation.BOUNCE);
				}
		}
	}
	else
	{
		centroidMarker = new google.maps.Marker({
		      map: map,
		      position: point,
		      icon: image,
		      shadow: new google.maps.MarkerImage('http://maps.gstatic.com/intl/en_us/mapfiles/markers/marker_sprite.png', 
		    	      new google.maps.Size(37,34), 
		    	      new google.maps.Point(20, 0), 
		    	      new google.maps.Point(10, 34))
		    });
		
	}
	if (type!==null)
	{
		
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

function mapBarangayOverlay(map,barangayCount,datax,barangayInfo,isOld) {//Denguecase barangay polygon display

	//*DECLARATION OF VALUES AND CONTAINERS
	var x1=999;
	var x2=-999;
	var y1=999;
	var y2=-999;
	var currPoly = 1;
	var latLng = [];
	var nodeInfoCounter=0;
	var bcount=splitter(barangayCount);
	var data2=splitter(datax);
	var binfo=splitter(barangayInfo);
	//var bage=splitter(barangayAge);
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
		{
			//*CREATION OF POLYGON
			var bermudaTriangle = new google.maps.Polygon(
					{
						paths: latLng,
						fillColor: "#FF0000",
						fillOpacity:0.3,
						clickable:false
					});
			//-------------------*/
			
			//*BARANGAY MARKER INFORMATION EXTRACTION
			var html="<b><i>No Data to Display</b></i>";
			var casecount=0;
			//var countUnderage=0;
			for(var i=0;i<=bcount.length-1;i++)
			{
				if(bcount[i][0]===currName)
				{
					html="<b>" +binfo[i][0]+"</b> ("+bcount[i][1]+" cases)<br/><br/><b>DENGUE CASES INFORMATION</b>"+
					" <br/>" + "<b>Gender Distribution</b>" +
					" <br/>" + "Female cases: " +binfo[i][1]+
					" <br/>" + "Male cases: " +binfo[i][2]+"<br/>";
					
					html=html+
					" <br/>" + "<b>Outcome</b>" +
					" <br/>" + "Alive: " +binfo[i][6]+
					" <br/>" + "Deceased: " +binfo[i][7]+
					" <br/>" + "Undetermined: " +binfo[i][8];
					casecount=bcount[i][1];
				}
			}
			//-------------------*/
			
			//*CREATION OF CENTROID POINT
			var centroidX = x1 + ((x2 - x1) * 0.5);
			var centroidY = y1 + ((y2 - y1) * 0.5);
			var image;
			var point;
			
			if(isOld)
			{
				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|8FD8D8';
				point = new google.maps.LatLng(centroidX,centroidY);
				
			}
			else
			{
				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
				point = new google.maps.LatLng(centroidX,centroidY+0.0010);
			}
			createMarker(map,point,image,html,null,true);
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
				fillOpacity:0.3,
				clickable:false
			});
	//-------------------*/
	
	//*BARANGAY MARKER INFORMATION EXTRACTION
			var html="<b><i>No Data to Display</b></i>";
			var casecount=0;
			var countUnderage=0;
			for(i=0;i<=bcount.length-1;i++)
			{
				if(bcount[i][0]===currName)
				{
					html="<b>" +binfo[i][0]+"</b> ("+bcount[i][1]+" cases)<br/><br/><b>DENGUE CASES INFORMATION</b>"+
					" <br/>" + "<b>Gender Distribution</b>" +
					" <br/>" + "Female cases: " +binfo[i][1]+
					" <br/>" + "Male cases: " +binfo[i][2]+"<br/><br/><b>Age Distribution:</b> Age(Amount)<br/>";
					
					html=html+
					" <br/>" + "<b>Outcome</b>" +
					" <br/>" + "Alive: " +binfo[i][6]+
					" <br/>" + "Deceased: " +binfo[i][7]+
					" <br/>" + "Undetermined: " +binfo[i][8];
					casecount=bcount[i][1];
				}
			}
			//-------------------*/
	
	//*CREATION OF CENTROID POINT
	var centroidX = x1 + ((x2 - x1) * 0.5);
			var centroidY = y1 + ((y2 - y1) * 0.5);
			var image;
			var point;
			if(isOld)
			{
				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|8FD8D8';
				point = new google.maps.LatLng(centroidX,centroidY);
			}
			else
			{
				image = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+casecount+'|ff776b';
				point = new google.maps.LatLng(centroidX,centroidY+0.0010);
			}
			createMarker(map,point,image,html,null,true);
			nodeInfoCounter++;
	//-------------------*/
   
	bermudaTriangle.setMap(map);
	
}

function mapLarvalOverlay(map,distance,datax,isOld) //Larvalpositive nodes display
{
	
	var dist = splitter(distance);
	var data = splitter(datax);
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
			createdOn[i]=data[i][7];
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
    	var html = "<b>Larval Survey Report #: </b>" + refNumber[i] +" <i>("+createdOn[i]+")</i>"
    	+ " <br/>" + "<b>Tracking #: </b>" + dist[i][0]
    	+ " <br/>" + "<b>Larval positives (LP) within: </b>"
    	+ " <br/>" + "<b>200m:</b>" + amount50a+" ("+ amount50p+"% of displayed LP)"
    	+ " <br/>" + "<b>50m:</b>" + amount200a+" ("+ amount200p+"% of displayed LP)"
    	+ "<br/><br/>" + "<b>Household: </b>" + household[i]+" ("+ householdcount+" of "+ household.length +" total occurrences, "+householdpercent.toFixed(2)+"%)"
    	+ " <br/>" + "<b>Container: </b>" + container[i]+" ("+ containercount+" of "+ container.length +" total occurances, "+containerpercent.toFixed(2)+"%)";
   		//var icon = customIcons[type] || {};
   		var bounce;
   		if((amount50p>=25)||(amount200p>=50))
  			bounce = 1;
  		else
  			bounce = null;
  		var image = null;
  		var circle = null;
		if(isOld)
		{
	 		createMarker(map,point,image,html,bounce,true);
	 		circle = new google.maps.Circle({
				center:point,
				radius:200,
				strokeColor:"#66CCCC",
				strokeOpacity:0.4,
				strokeWeight:1,
				fillColor:"#66CCCC",
				fillOpacity:0.4,
				clickable:false
			});
		}
		else
		{
	 		createMarker(map,point,image,html,bounce,false);
	 		circle = new google.maps.Circle({
				center:point,
				radius:200,
				strokeColor:"#0000FF",
				strokeOpacity:0.4,
				strokeWeight:1,
				fillColor:"#0000FF",
				fillOpacity:0.2,
				clickable:false
			});
		}
			
		circle.setMap(map); 
	}
}
	
function load() {

	var map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(14.301716, 120.942506),
		zoom: 14,
		mapTypeId: 'hybrid'
	});
    	
	if(document.getElementById('type').value.toString()=="larvalpositive")
    {
        mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
    }
	else if(document.getElementById('type').value.toString()=="denguecase")
	{
		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
    }
	else
	{
    	//*Data handler, SPLITTER
		var str = document.getElementById('data').value.toString();
		str = str.split("%&");
		//-------------------*/
		
		mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
	}
}
  function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	  $("#old").change(function() {
		  if($("#old").val()==1)
		  {
			  var map = new google.maps.Map(document.getElementById("map"), {
					center: new google.maps.LatLng(14.301716, 120.942506),
					zoom: 14,
					mapTypeId: 'hybrid'
				});
			    	
				if(document.getElementById('type').value.toString()=="larvalpositive")
			    {
					mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
			        mapLarvalOverlay(map,document.getElementById('Pdist').value,document.getElementById("Pdata").value,true);
			    }
				else if(document.getElementById('type').value.toString()=="denguecase")
				{
					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('Pdata').value.toString(),document.getElementById('PdataBInfo').value.toString(),true);
			    }
				else
				{
			    	//*Data handler, SPLITTER
					var str = document.getElementById('data').value.toString();
					str = str.split("%&");
					var Pstr = document.getElementById('Pdata').value.toString();
					Pstr = Pstr.split("%&");
					//-------------------*/
					
					mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
					mapLarvalOverlay(map,document.getElementById('Pdist').value.toString(),Pstr[0],true);
					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),Pstr[1],document.getElementById('PdataBInfo').value.toString(),true);
				}
		  }
		  else
		  {
			  load();
		  }
	  });
	});
</script>
</head>
<form>
<input type = 'hidden' id ='data' name='data' value='<?php echo $nodes?>'>
<input type = 'hidden' id ='dataBInfo' name='dataBInfo' value='<?php echo $binfo?>'>
<input type = 'hidden' id ='dataBAge' name='dataBAge' value='<?php echo $table1?>'>
<input type = 'hidden' id ='dataBCount' name='dataBCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='dist' name='dist' value='<?php echo $dist?>'>

<input type = 'hidden' id ='Pdata' name='Pdata' value='<?php echo $Pnodes?>'>
<input type = 'hidden' id ='PdataBInfo' name='PdataBInfo' value='<?php echo $Pbinfo?>'>
<input type = 'hidden' id ='PdataBAge' name='PdataBAge' value='<?php echo $table2?>'>
<input type = 'hidden' id ='PdataBCount' name='PdataBCount' value='<?php echo $Pbcount?>'>
<input type = 'hidden' id ='Ptype' name='Ptype' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='Pdist' name='Pdist' value='<?php echo $Pdist?>'>
</form>
<body onload="load()">
<?php 
	$optionsMonths=array(
		"01"=>"January",
		"02"=>"February",
		"03"=>"March",
		"04"=>"April",
		"05"=>"May",
		"06"=>"June",
		"07"=>"July",
		"08"=>"August",
		"09"=>"September",
		"10"=>"October",
		"11"=>"November",
		"12"=>"December"
	);
	$optionsYear=array(
		"1990"=>"1990",
		"1991"=>"1991",
		"1992"=>"1992",
		"1993"=>"1993",
		"1994"=>"1994",
		"1995"=>"1995",
		"1996"=>"1996",
		"1997"=>"1997",
		"1998"=>"1998",
		"1999"=>"1999",
		"2000"=>"2000",
		"2001"=>"2001",
		"2002"=>"2002",
		"2003"=>"2003",
		"2004"=>"2004",
		"2005"=>"2005",
		"2006"=>"2006",
		"2007"=>"2007",
		"2008"=>"2008",
		"2009"=>"2009",
		"2010"=>"2010",
		"2011"=>"2011",
		"2012"=>"2012",
		"2013"=>"2013",
		"2014"=>"2014",
		"2015"=>"2015",
		"2016"=>"2016",
		"2017"=>"2017",
		"2018"=>"2018",
		"2019"=>"2019",
		"2020"=>"2020"
	);?>
<table border="1" width=100%>
<tr>
	<td style="width:60%; height:600px" rowspan="2">
	    <div id="map" style="width: 100%%; height: 600px"></div>
	</td>
	<td style="width:40%; height:200px">
		<form action="" method='post' onsubmit='return confirm("Sure?")'>
		<label style="color:red"><?php echo form_error('NDtype-ddl'); ?></label>
		<div id="info" class="info">
		<i>(Today is <?php echo date('F d, Y');?>)</i>
		
		<h4>
		Select 'Barangay overlay' to view dengue cases per barangay.<br />
		Select 'Larval overlay' to view positive larval samplings.<br />
		Select 'both' to view overlays displaying both larval positives and dengue cases.<br />
		<?php 
		$options=array(
			"both"=>"Both",
			"denguecase"=>"Barangay overlay",
			"larvalpositive"=>"Larval overlay"
		);
		echo form_dropdown('NDtype-ddl', $options, $node_type);
		?></h4></div>
		
		
		
	    Main Search Date: <?php echo "<i>(Currently ".$cdate1." to ".$cdate2.")</i>"?>
		<br /><!-- 
	    From: <input type="text" style="background-color:#CCCCCC;" name="date1" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
	    To: <input type="text" style="background-color:#CCCCCC;"name="date2" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a> 
		<br />
		<br /> -->
		<?php 
		
		echo "Start Date:";
		echo form_dropdown('YearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo " End Date:&#160;&#160;";
		echo form_dropdown('YearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('MonthEnd-ddl', $optionsMonths,date('m'));
		?>
		<br/><br/>
		<select name='old' id='old'>
		  <option value="0" selected>Hide</option>
		  <option value="1">Display</option>
		</select> <b>barangay nodes containing old data.</b><br />
		
		<?php
		echo "Old Data Comparison: <i>(Currently ".$pdate1." to ".$pdate2.")</i><br/>"; 	
		?>
		Use 
		<select name='deflt' id='deflt'>
		  <option value="0">custom</option>
		  <option value="1" selected>default</option>
		</select> date for old data comparison. <i>Default is same length and period of the previous year(s)</i><br/>
		<?php
		echo "Start Date:";
		echo form_dropdown('PYearStart-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthStart-ddl', $optionsMonths,date('m'));
		echo "<br/>";
		echo " End Date:&#160;&#160;";
		echo form_dropdown('PYearEnd-ddl', $optionsYear,date('Y'));
		echo form_dropdown('PMonthEnd-ddl', $optionsMonths,date('m'));
		?>
		<div><input type="submit" value="Sort" /></div>
		</form> 
	</td>
</tr>
<tr>
	<td style="width:40%; height:60%">
	<div style="height: 100%; overflow: auto;">
		<?php 
		$tmpl = array (
						'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" >',
					    'heading_row_start'   => '<tr>',
					    'heading_row_end'     => '</tr>',
					    'heading_cell_start'  => '<th id="result" scope="col">',
					    'heading_cell_end'    => '</th>',
					    'row_start'           => '<tr>',
					    'row_end'             => '</tr>',
					    'cell_start'          => '<td align="center">',
					    'cell_end'            => '</td>',
					    'row_alt_start'       => '<tr style="background-color: #e3e3e3">',
					    'row_alt_end'         => '</tr>',
					    'cell_alt_start'      => '<td align="center">',
					    'cell_alt_end'        => '</td>',
					    'table_close'         => '</table>'
					   );
		$this->table->set_template($tmpl);
		echo "<br/><center><b>Age Distribution:</b><br/><h4></>Table 1. Displaying Age Distribution for period <br/><i>".$cdate1." to ".$cdate2."</i></h6>";
		echo $this->table->generate($table1);?>
		<?php echo "<br/><b>Age Distribution:</b><br/><h4></>Table 2. Displaying Age Distribution for period <br/><i>".$pdate1." to ".$pdate2."</i></h6><center>";
		echo $this->table->generate($table2);
		?>
	</div>
	</td>
</tr>
</table>
		
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
