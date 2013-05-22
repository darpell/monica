<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>
<script src="<?= base_url('scripts/larvaloverlay.js') ?>"></script>
<script src="<?= base_url('scripts/barangayoverlay.js') ?>"></script>
<script src="<?= base_url('scripts/generalmappingtools.js') ?>"></script>
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
infoWindow.setOptions({maxWidth:400});

function splitter(str)//Data splitter
{
	str = str.split("%%");
	var data = new Array();
	for (var i = 0; i < str.length; i++)
	{
		data[i] = str[i].split("&&");
	}
	return data;
}

function countInstances(arr) {
    var a = [], b = [], prev;

    arr.sort();
    for ( var i = 0; i < arr.length; i++ ) {
        if ( arr[i] !== prev ) {
            a.push(arr[i]);
            b.push(1);
        } else {
            b[b.length-1]++;
        }
        prev = arr[i];
    }

    return [a, b];
}

function load() {
	var map = new google.maps.Map(document.getElementById("map"), {
		center: new google.maps.LatLng(14.301716, 120.942506),
		zoom: 14,
		mapTypeId: 'hybrid'
	});
	mapPointsOfInterest(map);
    	
	if(document.getElementById('type').value.toString()=="larvalpositive")
    {
        mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
    }
	else if(document.getElementById('type').value.toString()=="denguecase")
	{
		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
    }
	else
	{
    	//*Data handler, SPLITTER
		var str = document.getElementById('data').value.toString();
		str = str.split("%&");
		//-------------------*/
		
		mapLarvalOverlay(map,document.getElementById('dist').value.toString(),str[0],false);
		mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge2').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
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
				mapPointsOfInterest(map);
			    	
				if(document.getElementById('type').value.toString()=="larvalpositive")
			    {
					mapLarvalOverlay(map,document.getElementById('dist').value,document.getElementById("data").value,false);
			        mapLarvalOverlay(map,document.getElementById('Pdist').value,document.getElementById("Pdata").value,true);
			    }
				else if(document.getElementById('type').value.toString()=="denguecase")
				{
					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),document.getElementById('data').value.toString(),document.getElementById('dataBInfo').value.toString(),false);
					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('PdataBAge2').value.toString(),document.getElementById('Pdata').value.toString(),document.getElementById('PdataBInfo').value.toString(),true);
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
					mapBarangayOverlay(map,document.getElementById('dataBCount').value.toString(),document.getElementById('dataBAge').value.toString(),str[1],document.getElementById('dataBInfo').value.toString(),false);
					mapBarangayOverlay(map,document.getElementById('PdataBCount').value.toString(),document.getElementById('PdataBAge2').value.toString(),Pstr[1],document.getElementById('PdataBInfo').value.toString(),true);
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
<input type = 'hidden' id ='dataBAge2' name='dataBAge2' value='<?php echo $bage?>'>
<input type = 'hidden' id ='dataBCount' name='dataBCount' value='<?php echo $bcount?>'>
<input type = 'hidden' id ='type' name='type' value='<?php echo $node_type?>'>
<input type = 'hidden' id ='dist' name='dist' value='<?php echo $dist?>'>

<input type = 'hidden' id ='interest' name='interest' value='<?php echo $interest?>'>

<input type = 'hidden' id ='Pdata' name='Pdata' value='<?php echo $Pnodes?>'>
<input type = 'hidden' id ='PdataBInfo' name='PdataBInfo' value='<?php echo $Pbinfo?>'>
<input type = 'hidden' id ='PdataBAge' name='PdataBAge' value='<?php echo $table2?>'>
<input type = 'hidden' id ='PdataBAge2' name='PdataBAge2' value='<?php echo $Pbage?>'>
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
		</select> <b> nodes containing old data.</b><br />
		
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
	<td style="width:40%; height:60%" rowspan='2'>
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
<tr>
	<td>
		<table>
		<tr>
		<td>
			<h5>Legend</h5>
		</td>
		</tr>
		<tr>
		<td><img border="0" src="http://maps.google.com/mapfiles/marker.png"></td>
		<td>Larval sampling, current search data. Bounces when 25% of all nodes returned by the search is within 50 meters or if 50% are within 200 meters.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://maps.google.com/mapfiles/ms/micons/ltblue-dot.png"></td>
			<td>"Old" Larval sampling. Same as previous, but uses old search data. <i>(Optionally activated)</i></td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=S|FF0000|000000"></td>
			<td>Point of interest. Possible source of Mosquitoes.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=R|FF0000|000000"></td>
			<td>Point of interest. Possible risk area susceptible to Mosquito bites.</td>
		</tr>	
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=4|ff776b"></td>
			<td>Barangay marker, number is the amount of dengue cases for the period. Commonly located at the center of the barangay boundary. For irregularly shaped barangays, the location may vary.</td>
		</tr>
		<tr>
			<td><img border="0" src="http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=4|8FD8D8"></td>
			<td>"Old" Barangay Marker. Same as previous, but uses old search data. Located beside Barangay Marker <i>(Optionally activated)</i></td>
		</tr>
		</table>
	</td>
</tr>
</table>
<!-- <a href="https://twitter.com/share" class="twitter-share-button" data-lang="en" data-text="<?php echo $bcount?>">Tweet</a> -->
<script>/*
	!function(d,s,id)
	{
		var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id))
		{
			js=d.createElement(s);
			js.id=id;
			js.src="https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	}
	(document,"script","twitter-wjs");//*/
</script>
		
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>
