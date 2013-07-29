<!-- HEADER -->
<?php $this->load->view('templates/header');?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
    
      function drawChart() {



          var year = document.getElementById('year_list').value.toString();
  		year = year.split("&&");
  		year.pop();



  		var total = document.getElementById('value_totals').value.toString();
  		total = total.split("%%");
  		total.pop();
  		var data2 = new Array();
  		for (var i = 0; i < total.length; i++)
  		{
  			data2[i] = total[i].split("&&");
  			data2[i].pop();
  			for (var s = 1; s < data2[i].length; s++)
  			{
				data2[i][s] = parseInt(data2[i][s]);
  	  		}
  		}
           
        var data = google.visualization.arrayToDataTable(data2,false);
          	
		var options = {
        title : 'Dengue cases arranged by barangay and year',
        vAxis: {title: "Cases"},
        hAxis: {title: "Barangay"},
        seriesType: "bars"
      };
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);



  		var total = document.getElementById('values_gender').value.toString();
  		
  		total = total.split("%%");
  		
  		total.pop();
  		var data2 = new Array();
  		for (var i = 0; i < total.length; i++)
  		{
  			data2[i] = total[i].split("&&");
  			data2[i].pop();
  			if(i>0)
  			{
  			for (var s = 1; s < data2[i].length; s++)
  			{
				data2[i][s] = parseInt(data2[i][s]);
  	  		}
  			}
  		}
  	
        
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Barangay');
     
        for (var s = 1; s < data2[0].length; s++)
			{
			data.addColumn('number', data2[0][s]);
	  		
	  		}
        data.addRows(data2.length-1);
        
        for (var i = 1; i < data2.length; i++)
  		{	
  			for (var s = 0; s < data2[i].length; s++)
  			{
  	  			if(s == 0)
				data.setCell(i-1, s, data2[i][s]);
  	  			else
  	  			{
  	  			data.setCell(i-1, s, parseInt(data2[i][s]));
  	  			}
  	  		
  	  		}
  		}
        
      	
		var options = {
        title : 'Dengue Cases Sorted By Gender and Year',
        vAxis: {title: "Cases"},
        hAxis: {title: "Barangay"},
        seriesType: "bars"
      };
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
        chart.draw(data, options);




        var total = document.getElementById('values_age').value.toString();
  		total = total.split("%%");
  		total.pop();

  		for (var i = 0; i < total.length; i++)
  		{
  			var data2 = new Array();
  			var data3 = new Array();
  			data2 = total[i].split("##");
  			data2[1] = data2[1].split("@@");
  			data2[1].pop();

  			for (var s = 0; s < data2[1].length; s++)
  			{
	  			data2[1][s] = data2[1][s].split("&&");
	  			data2[1][s].pop();
	  			for (var d = 1; d < data2[1][s].length; d++)
	  			{
					data2[1][s][d] = parseInt(data2[1][s][d]);
	  	  		}
	  			
	  	  		
  			}
  		

       var data = google.visualization.arrayToDataTable(data2[1],false);
		var options = {
        title : 'Dengue Cases Of ' + data2[0] + ' Arranged By Age Group and Year',
        vAxis: {title: "Cases"},
        hAxis: {title: "Age group"},
        seriesType: "bars"
      };
        var chart = new google.visualization.ComboChart(document.getElementById(data2[0]));
        chart.draw(data, options);

  	}
	

    	

        
      }
    </script>
    
    
    
 
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather,visualization&sensor=true"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script>var infoWindow = new google.maps.InfoWindow();
infoWindow.setOptions({maxWidth:400});

function setInfo(fMarker,fInfo,fMap) {
	google.maps.event.addListener(fMarker, 'click', function() {
		infoWindow.setOptions({content:fInfo});
		infoWindow.open(fMap, this);
	});
}

function load() {
	//alert("Present: "+document.getElementById("presRemvd").value+" remvd "+document.getElementById("present_length").value+" remain");
	var dasma = new google.maps.LatLng(14.2990183, 120.9589699);
	var map;
	var mapProp = {
		center: dasma,
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.TERRAIN
	};
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
	
	/** Sample Larval Data used as case data **/
	if (document.getElementById("ic_length").value != 0)
	{//alert("0");
		for (var pt_ctr = 0; pt_ctr < document.getElementById("ic_length").value; pt_ctr++) 
		{	
			caseMarker=new google.maps.Marker({
				  position: new google.maps.LatLng(
							document.getElementById("ic_lat" + pt_ctr).value,
							document.getElementById("ic_lng" + pt_ctr).value
							),
				  map: map
				});
			var s="Female";
			var o="Unconfirmed";
			if((""+document.getElementById("ic_sex" + pt_ctr).value)=="M")
			{
				s="Male";
			}
			if((""+document.getElementById("ic_sex" + pt_ctr).value)=="A")
			{
				o="Alive";
			}
			else if ((""+document.getElementById("ic_sex" + pt_ctr).value)=="D")
			{
				o="Deceased";
			}
			info="<b>"+document.getElementById("ic_lname" + pt_ctr).value+", "+document.getElementById("ic_fname" + pt_ctr).value+"</b>"+"<br/>"
			+document.getElementById("ic_barangay" + pt_ctr).value+", "+document.getElementById("ic_street" + pt_ctr).value+"<br/>"
			+"Onset: "+document.getElementById("ic_dateOnset" + pt_ctr).value+"<br/>"
			+"Age: "+document.getElementById("ic_age" + pt_ctr).value+"<br/>"
			+"Gender: "+s+"<br/>"
			+"Outcome: "+o+"<br/>"+"<br/>"
			+"Feedback: "+document.getElementById("ic_outcome" + pt_ctr).value+"<br/>";
			setInfo(caseMarker,info,map);
		}
	}
	/** end of sample data**/
}
  function doNothing() {}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	  
	});
</script>




<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=weather,visualization&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script>

<link rel="stylesheet" href="<?php echo base_url('scripts/jQRangeSLider-5.1.1/css/iThing.css')?>"/>
<link rel="stylesheet" href="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/lib/jquery-ui/css/smoothness/jquery-ui-1.8.10.custom.css')?>"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/lib/jquery-ui/js/jquery-ui-1.8.16.custom.min.js')?>"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/lib/jquery.mousewheel.min.js')?>"></script>
<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/jQDateRangeSlider-min.js')?>"></script>

<script src="<?php echo base_url('scripts/jQRangeSLider-5.1.1/demo/dateSliderDemo.js')?>"></script>

<script>
	$(function() {
		drawChart();
		load();
		var tabs = $( "#tabs" ).tabs();
		tabs.find( ".ui-tabs-nav" ).sortable({
				axis: "x",
				stop: function() {
				tabs.tabs( "refresh" );
			}
		});
	});
</script>

<?php if($values_age != null) {?>
<?php if ($mapvalues['data_exists'] === true){$ctr=0;?>
<input type="hidden" id="ic_length" value="<?php echo count($mapvalues['dataCases']); ?>" />
	<?php foreach ($mapvalues['dataCases'] as $value) {?>
		<input type="hidden" id="ic_lat<?= $ctr ?>" 		value="<?php echo $value['ic_lat']; ?>"	/>
		<input type="hidden" id="ic_lng<?= $ctr ?>" 		value="<?php echo $value['ic_lng']; ?>"	/>
		<input type="hidden" id="ic_feedback<?= $ctr ?>" 		value="<?php echo $value['ic_feedback']; ?>"	/>
		<input type="hidden" id="ic_fname<?= $ctr ?>" 		value="<?php echo $value['ic_fname']; ?>"	/>
		<input type="hidden" id="ic_lname<?= $ctr ?>" 		value="<?php echo $value['ic_lname']; ?>"	/>
		<input type="hidden" id="ic_dateOnset<?= $ctr ?>" 		value="<?php echo $value['ic_dateOnset']; ?>"	/>
		<input type="hidden" id="ic_age<?= $ctr ?>" 		value="<?php echo $value['ic_age']; ?>"	/>
		<input type="hidden" id="ic_sex<?= $ctr ?>" 		value="<?php echo $value['ic_sex']; ?>"	/>
		<input type="hidden" id="ic_barangay<?= $ctr ?>" 		value="<?php echo $value['ic_barangay']; ?>"	/>
		<input type="hidden" id="ic_street<?= $ctr ?>" 		value="<?php echo $value['ic_street']; ?>"	/>
		<input type="hidden" id="ic_outcome<?= $ctr ?>" 		value="<?php echo $value['ic_outcome']; ?>"	/>
	<?php $ctr++;}?> 
	<?php } else { ?> <input type="hidden" id="ic_length" value="0" /> <?php } }?>


<body onload="load()">    
<!-- CONTENT -->
<div class="body">

		<div class="blog">
		<center><h1>Dengue Profile</h1></center>
<?php if($values_age != null) { ?>
<center>
 <fieldset style="width: 50%;">
  <legend>Trend</legend>
A total of <b><?php echo $total_text;?> </b> dengue cases was reported in Dasmarinas CHO-I from <?php echo $date_from_text;?> to <?php echo $date_to_text; ?>.<br>
  Most cases happened during the year <b><?php echo $yeartotal_text2[0]?></b>. A total of <b><?php echo $yeartotal_text[$yeartotal_text2[0]]?></b> where recorded.<br>
 </fieldset>
  <fieldset style="width: 50%;">
  <legend>Profile of Cases</legend>
Majority of cases were <?php if($m_text > $f_text) echo '<b>male (' . $m_text ; else echo '<b>female (' . $f_text ; ?>). <br>
<?php  $x = $agegroup_text2[0]; $s = ($agegroup_text[$x]/$total_text)*100; echo round($s , 2);?> </b>% ( <b> <?php echo $agegroup_text[$x]; ?>)  </b>of cases belonged to the 
<?php
if($agegroup_text2[0] == 0)
{echo ' 0 to 10 ' ;}
if($agegroup_text2[0] == 1)
{echo ' 11 to 20 ' ;}
if($agegroup_text2[0] == 2)
{echo ' 21 to 30 '; }
if($agegroup_text2[0] == 3)
{echo '31 to 40 ' ;}
if($agegroup_text2[0] == 4)
{echo ' greater than 40 '; }
?>. <br>
Most cases number of <b>(<?php echo $bartotal_text[$bartotal_text2[0]]; ?>) </b>recorded is at <b> <?php echo $bartotal_text2[0];?> </b><br>

  </fieldset>

</center>
<?php }?>
<br>
<table    align="center" cellpadding="5">
<tr>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/view_dengue_profile',$attributes); ?>
  <tr>
    <td>Barangay:</td>
    <?php foreach ($barangay_form as $row) {
    ?>
    <td>
    <?php 
    echo form_checkbox('barangay[]', $row, TRUE);
    echo $row;
    ?>
    </td>
    <?php }?>
     <tr>
    <td >Date:</td>
    <td>
    <label style="color:red"><?php echo form_error('TPdatefrom-txt'); ?></label>
    From: <input type="text" name="TPdatefrom-txt" readonly = "true" id = "date1" value="" onClick = "javascript:NewCal('date1','mmddyyyy')" /></td>
    
    <td>
    <label style="color:red"><?php echo form_error('TPdateto-txt'); ?></label>
    To: <input type="text" name="TPdateto-txt" readonly = "true" id = "date2" value=""  onClick = "javascript:NewCal('date2','mmddyyyy')" />
    </td> 
     
    
   <td> <input type="submit" class="submitButton" value="View"/><?php echo form_close(); ?></td>
   <td> <label style="color:red"><?php echo $error; ?></label></td>
  </tr>
  
  

	</table>
<p />




</div>
</div>
<?php if($values_age != null) { ?>
<!-- Sidebar -->
	<div id="sidebar">
		<div id="sidebar-higher"></div>
		<div id="sidebar-lower">
			<div id="tabs">
				<ul>
					<li><a href="#tab_summary"> Cases Per Year </a></li>
					<li><a href="#tab_larva"> Cases By Gender </a></li>
					<?php 
					foreach ($barangay as $y)
					{
						$string = str_replace(' ', '', $y);
						
						echo '<li><a href="#tab_' . $string .'">'.$y.'</a></li>';
					}
					
					?>
					<li><a href="#tab_table"> demographics of Cases</a></li>
					<li><a href="#tab_casetable">Cases Information</a></li>
				</ul>

				<div id="tab_summary" >
						<div id="chart_div" style="height: 500px"></div>
				</div>

				<div id="tab_larva" >
						<div id="chart_div2" style="height: 500px"></div>
				</div>
				
				
				<?php 
				foreach ($barangay as $y)
				{
					
					$string = str_replace(' ', '', $y);
					echo '<div id="tab_'. $string .'">';
					echo '<div id="' . $y .'" style="height: 500px;"></div>';
					echo '</div>';
				}
				
				?>
				
				
				
				
				
				<div id ="tab_table">
						<center>
						<h3>Distribution of Cases by year, gender and age group</h2>
						<table  border="1" cellpadding="5" cellspacing="0">
							<tr>
								<td>&nbsp;</td>
								<?php 
									foreach ($year as $y)
									{
										echo '<td align="center" colspan="2">'.$y.'</td>';
									}
									foreach ($barangay as $y)
									{	echo '<tr>';
										echo '<td align="center">'.$y.'</td>';
										foreach ($year as $s)
										{
											echo '<td align="center">'.'M'.'</td>';
											echo '<td align="center">'.'F'.'</td>';
										}
										echo '</tr>';
											for ($i = 0; $i <=4; $i++)
											{
												echo '<tr>';
												if($i <4 ){echo '<td align="center">'. ($i * 10)."-".(($i *10)+10).'</td>';}
												else{echo '<td align="center">'. '>40' .'</td>';}
												foreach ($year as $s)
												{
													echo '<td align="center">'.$values[$s][$y]['M'][$i] .'</td>';
													echo '<td align="center">'.$values[$s][$y]['F'][$i] .'</td>';
												}
												
												echo '</tr>';
											}
									}
								?>
							</tr>
						</table>
						</center>
				</div>
				
				<div id ="tab_casetable">
						<center>
						<h3>Case Information</h2>
						<?php 
								
								$tmpl = array (
								                    'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" style="width: 70%;" >',
								
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
								
								echo $this->table->generate($tablecases); 
								?>
								
								
						</center>
				</div>
				
			</div>
		</div>
	</div>
	<!-- end Sidebar -->

				
					<center>
					<h3>Map of Dengue Cases</h3>
					<div id="googleMap" style="width: 900px; height: 600px"></div>
					</center>
		



<input type="hidden" name="values_age" id="values_age" value="<?php echo $values_age; ?>" />
<input type="hidden" name="values_gender" id="values_gender" value="<?php echo $values_gender; ?>" />
<input type="hidden" name="values_total" id="value_totals" value="<?php echo $values_total; ?>" />
<input type="hidden" name="barangay_list" id="barangay_list" value="<?php echo $barangay_list; ?>" />
<input type="hidden" name="year_list" id="year_list" value="<?php echo $year_list; ?>" />
<?php } ?>

</body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>