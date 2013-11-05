<!-- HEADER -->
<?php $this->load->view('templates/header');?>

	
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>    
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&sensor=true"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script src="<?= base_url('scripts/OverlappingMarkerSpiderfier.js') ?>"></script><script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls','corechart','gauge','table']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
    		var today = new Date();
    		var dd = today.getDate();
    		var mm = today.getMonth()+1;
    		var yyyy = today.getFullYear() ;
    		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;

		//cases
    	var str2 = document.getElementById('barangay_count').value.toString();
		str2 = str2.split("%%");
		var data = new Array();
		for (var i = 0; i < str2.length; i++)
		{
			data[i] = str2[i].split("&&");
		}
		data.pop();

		//quartile
		var quartile = document.getElementById('quartile').value.toString();
		quartile = quartile.split("&&");
		quartile.pop();
		//csum
		var csum = document.getElementById('csum').value.toString();
		csum = csum.split("&&");
		csum.pop();
		//m2sd
		var m2sd = document.getElementById('m2sd').value.toString();
		m2sd = m2sd.split("&&");
		m2sd.pop();
		//csum192sd
		var csum196sd = document.getElementById('csum196sd').value.toString();
		csum196sd = csum196sd.split("&&");
		csum196sd.pop();
		//cases
		var cases = document.getElementById('cases').value.toString();
		cases = cases.split("&&");
		cases.pop();
		var today2 = new Date();

		//larval points
		var str3 = document.getElementById('larval').value.toString();
		str3 = str3.split("%%");
		var larval = new Array();
		for (var i = 0; i < str3.length; i++)
		{
			larval[i] = str3[i].split("&&");
		}
		larval.pop();
		var larval1 = 0;
		var larval2 = 0;
		var larval3 = 0;
		var larval4 = 0;

		for (var i = 0; i < larval.length; i++)
		{	
			if (larval[i][1] == 'LANGKAAN II') 
			{larval1 = larval[i][0];}
			if (larval[i][1] == 'SAMPALOC I') 
			{larval2 = larval[i][0];}
			if (larval[i][1] == 'SAN AGUSTIN I') 
			{larval3 = larval[i][0];}
			if (larval[i][1] == 'SAN AGUSTIN III') 
			{larval4 = larval[i][0];}
		}

		
		
		var tquartile = Math.round(((cases[ today2.getMonth()]/quartile[ today2.getMonth()]))*100);
		var tcsum =  Math.round(((cases[ today2.getMonth()]/csum[ today2.getMonth()]))*100);
		var tmean2sd = Math.round(((cases[ today2.getMonth()]/m2sd[ today2.getMonth()]))*100);
		var tcsum196sd = Math.round(((cases[ today2.getMonth()]/csum196sd[ today2.getMonth()]))*100);
		

		 var epi = google.visualization.arrayToDataTable([
		            ['Label', 'Value'],
		         	['3rd Quartile', tquartile],
		            ['C-SUM', tcsum] ,
		            ['mean+2SD', tmean2sd ],
		            ['C-SUM+1.96SD', tcsum196sd],
		                                                 ]);
		 var epioptions = {
		          redFrom: 90, redTo: 150,
		          yellowFrom:75, yellowTo: 90,
		          minorTicks: 0,
		          max:150
		        };
				
		
			var m1 = 0;
			var m2 = 0;
			var m3 = 0;
			var m4 = 0;
    		
			var mn1 = 0;
			var mn2 = 0;
			var mn3 = 0;
			var mn4 = 0;
	
			for (var i = 0; i < data.length; i++)
			{	
				if(parseInt(data[i][2]) == parseInt(yyyy))
				{
				if (data[i][1] =='LANGKAAN II' ) 
				{mn1 = data[i][0];}
				if (data[i][1] == 'SAMPALOC I') 
				{mn2 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN I') 
				{mn3 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN III') 
				{mn4 = data[i][0];}
				}
				else if(parseInt(data[i][2]) == parseInt(yyyy-1))
				{
				if (data[i][1] == 'LANGKAAN II') 
				{m1 = data[i][0];}
				if (data[i][1] == 'SAMPALOC I') 
				{m2 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN I') 
				{m3 = data[i][0];}
				if (data[i][1] == 'SAN AGUSTIN III') 
				{m4 = data[i][0];}
				}
			}


			//number of postive
			
			var xvalues = [68, 71 ,62 ,75, 58, 60, 67, 68, 71, 69, 68, 67, 63, 62, 60, 63, 65, 67, 63, 61];
			//number of cases
			var yvalues = [4.1, 4.6, 3.8, 4.4, 3.2, 3.1, 3.8, 4.1, 4.3, 3.7, 3.5, 3.2, 3.7, 3.3, 3.4, 4.0, 4.1, 3.8, 3.4, 3.6];
			var n = 4; //number of barangays
			var xyprod = 0; // sum of the products of x and y
			var xsum = 0;
			var ysum = 0;
			var xsumsq = 0;
			var ysumsq = 0;

			for (var i = 0; i < n; i++)
			{
				xyprod = xyprod + (xvalues[i]*yvalues[i]);
				xsum = xsum + xvalues[i];
				ysum = ysum + yvalues[i];
				xsumsq = xsumsq + (xvalues[i]*xvalues[i]);
				ysumsq = ysumsq + (yvalues[i]*yvalues[i]);
			}

			//correlation formula

			var a = (n*xyprod) - (xsum*ysum); //numerator
			var b = Math.sqrt(((n*xsumsq)-(xsum*xsum)) * ((n*ysumsq)-(ysum*ysum))); //denominator
			var r = a/b; //correlation result;
			
			
          // Prepare the data
        var str = document.getElementById('age_count').value.toString();

					str = str.split("%%");
					var data2 = new Array();
					for (var i = 0; i < str.length; i++)
					{
						data2[i] = str[i].split("&&");
					}
					data2.pop();
		 var datatable = new google.visualization.DataTable();
		 datatable.addColumn('string', 'Barangay');
		 datatable.addColumn('string', 'Age Group');
		 datatable.addColumn('number', 'No. of Cases');
		 datatable.addRows(data2.length);
		 for (var i = 0; i < data2.length; i++)
			{
			 datatable.setCell(i, 0 , data2[i][0]);
			 datatable.setCell(i, 1 , data2[i][1]);
			 datatable.setCell(i, 2 , parseInt(data2[i][2]));
			}

   
        var categoryPicker = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control2',
          'options': {
            'filterColumnLabel': 'Age Group',
            'ui': {
            'labelStacking': 'vertical',
              'allowTyping': false,
              'allowMultiple': false
            }
          }
        });
        var categoryPicker2 = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'control3',
            'options': {
              'filterColumnLabel': 'Barangay',
              'ui': {
              'labelStacking': 'vertical',
                'allowTyping': false,
                'allowMultiple': false
              }
            }
          });
      
        // Define a table
        var table = new google.visualization.ChartWrapper({
          'chartType': 'Table',
          'containerId': 'chart2',
          'options': {
           
          }
        });
        var pie = new google.visualization.ChartWrapper({
            'chartType': 'PieChart',
            'containerId': 'chart1',
            'options': {
              'width': 300,
              'height': 300,
              'legend': {position: 'top', textStyle: {color: 'blue', fontSize: 16}},
              
              'title': 'No. of cases',
              'chartArea': {'left': 15, 'top': 15, 'right': 0, 'bottom': 0},
              'pieSliceText': 'label'
            },
            // from the 'data' DataTable.
            'view': {'columns': [0, 2]}
          });

        var ctr = document.getElementById('immediate_cases').value.toString();

		ctr = ctr.split("%%");
		var icase = new Array();
		for (var i = 0; i < ctr.length; i++)
		{
			icase[i] = ctr[i].split("&&");
		}
		icase.pop();
		var datatable2 = new google.visualization.DataTable();
		datatable2.addColumn('string', 'Name');
		datatable2.addColumn('string', 'Age');
		datatable2.addColumn('string', 'Gender');
		datatable2.addColumn('string', 'Barangay');
		datatable2.addColumn('string', 'Street');
		datatable2.addColumn('string', 'Date Onset');
		datatable2.addRows(icase.length);
		for (var i = 0; i < icase.length; i++)
		{
		 datatable2.setCell(i, 0 , icase[i][0]);
		 datatable2.setCell(i, 1 , icase[i][1]);
		 datatable2.setCell(i, 2 , icase[i][2]);
		 datatable2.setCell(i, 3 , icase[i][3]);
		 datatable2.setCell(i, 4 , icase[i][4]);
		 datatable2.setCell(i, 5 , icase[i][5]);

		}
		        

      
 
        // Create a dashboard
        new google.visualization.Dashboard(document.getElementById('dashboard')).
            // Establish bindings, declaring the both the slider and the category
            // picker will drive both charts.
            bind([categoryPicker,categoryPicker2], [pie,table]).
            // Draw the entire dashboard.
            draw(datatable);

         var options = {
                title : 'This month dengue cases by barangay compared to the previous year',
                vAxis: {title: "Number Of Cases"},
                hAxis: {title: "Barangay"},
                seriesType: "bars",
                series: {5: {type: "line"}}
              };
         var options2 = {
                 title : 'Correlation Between Larval Survey and Dengue Cases with a Correlation Result* ' + r,
                 vAxis: {title: "Number"},
                 hAxis: {title: "Barangay"},
                 seriesType: "line",
                 series: {5: {type: "line"}}
               };
        
        var data = google.visualization.arrayToDataTable([
       	['Barangay', String(yyyy-1), String(yyyy)],
        ['Langkaan II',  parseInt(m1),      parseInt(mn1)],
        ['Sampaloc I',  parseInt(m2),      parseInt(mn2)],
        ['San Agustin I',  parseInt(m3),     parseInt(mn3)],
        ['San Agustin III',  parseInt(m4),      parseInt(mn4)]],false);
        


        /*
        var data2 = google.visualization.arrayToDataTable([
         ['Barangay', 'No. of Cases', 'No. Positive Larval Points'],
         ['Langkaan II',  parseInt(mn1),  parseInt(larval1)    ],
         ['Sampaloc I',  parseInt(mn2),    parseInt(larval2)  ],
         ['San Agustin I',  parseInt(mn3),  parseInt(larval3)   ],
         ['San Agustin III',  parseInt(mn4),  parseInt(larval4)    ]
         ]);
        */

        var sumofcases = parseInt(mn1)+parseInt(mn2)+parseInt(mn3)+parseInt(mn4);
        document.getElementById('tquartile').value = tquartile;
        document.getElementById('tcases').value = sumofcases;
        document.getElementById('tcsum').value = tcsum;
        document.getElementById('tm2sd2').value = tmean2sd;
        document.getElementById('tcsum196sd').value = tcsum196sd;
        
              // Instantiate and draw our chart, passing in some options.
             var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(data, options);
              
             // var chart2 = new google.visualization.ComboChart(document.getElementById('chart_div2'));
             // chart2.draw(data2, options2);
            
              //new google.visualization.Gauge(document.getElementById('visualization')).
            //  draw(epi,epioptions);
             
              var table = new google.visualization.Table(document.getElementById('table_div1'));
              table.draw(datatable2, {showRowNumber: true,width: '1000px',page:'enable'});

            
                    
      }
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
<style>
html { height:100% }
body { height:100%;margin:0;padding:0 }

#googleMap { width:55%; height:90%; margin: 10px; float:left;}
</style>


<script>
	$(function() {
		drawVisualization();
		var tabs = $( "#tabs" ).tabs();

		tabs.find( ".ui-tabs-nav" ).sortable({
				axis: "x",
				stop: function() {
				tabs.tabs( "refresh" );
			}
		});
		
	});
	
</script>
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
	var cases = new Array();
	
	/** Sample Larval Data used as case data **/
	if (document.getElementById("ic_length").value != 0)
	{//alert("0");
		for (var pt_ctr = 0; pt_ctr < document.getElementById("ic_length").value; pt_ctr++) 
		{	
			cases.push(new google.maps.LatLng(
					document.getElementById("ic_lat" + pt_ctr).value,
					document.getElementById("ic_lng" + pt_ctr).value
					));/*
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
			setInfo(caseMarker,info,map);//*/
			heatmap = new google.maps.visualization.HeatmapLayer({
				  data: cases
				});
				heatmap.setMap(map);
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


  <div class="body">
<br>
  <center>
 <h2> Dengue Cases and Larval Positives for the Month of <?php echo date('F') . ' ' . date('Y'); ?></h2>
    <br>
      <br>
  	<!-- Sidebar -->
	<div id="sidebar">
		<div id="sidebar-higher"></div>
		<div id="sidebar-lower">
			<div id="tabs">
				<ul>
					<li><a href="#tabs-5"> Dengue Map </a></li>
					<li><a href="#tabs-6">Alerts(<?php echo count($notif);?>)</a></li>
					<li><a href="#tab_summary"> Dengue Summary </a></li>
					<li><a href="#tab_larva"> Cases Compared Last Year</a></li>
					
				</ul>
			<!-- Summary Tab -->
			<div  id="tabs-5">
	
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
	<?php } else { ?> <input type="hidden" id="ic_length" value="0" /> <?php } ?>
	<center><div id="googleMap" style="width: 900px; height: 600px float:center"></div></center>
</div>
<div id="tabs-6">
<?php 
$this->table->set_heading(
		array(	' ',
				'Alert',
				'Date'
		));
echo $this->table->generate($notif);?>

</div>
				<div id="tab_summary">
					 <h3>Dengue Cases Summary</h3>
					    <div id="dashboard">
					      <table>
					        <tr style='vertical-align: top'>
					          <td style='width: 300px; font-size: 0.9em;'>
					            <div id="control1"></div>
					            <div id="control2"></div>
					            <div id="control3"></div>
					          </td>
					          <td>
					            <div style="float: left;" id="chart1"></div>
					            <div style="float: left;" id="chart2"></div>
					            <div style="float: left;" id="chart3"></div>
					          </td>
					        </tr>
					      </table>
					    </div>
					    <div id='table_div1'></div>
				</div>
				<div id="tab_larva">
					 <div id='chart_div'></div>
					 
					 
				</div>
				
				
			</div>
		</div>
	</div>
	<!-- end Sidebar -->
	
   
  
  
   
   
   

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/tweet',$attributes); ?>

<div class="blog">

<input type="hidden" name="table_data" id="table_data" value="<?php echo $table_data; ?>" />
<input type="hidden" name="barangay_count" id="barangay_count" value="<?php echo $barangay_count; ?>" />
<input type="hidden" name="age_count" id="age_count" value="<?php echo $age_count; ?>" />
<input type="hidden" name="quartile" id="quartile" value="<?php echo $quartile; ?>" />
<input type="hidden" name="csum" id="csum" value="<?php echo $csum; ?>" />
<input type="hidden" name="m2sd" id="m2sd" value="<?php echo $m2sd; ?>" />
<input type="hidden" name="csum196sd" id="csum196sd" value="<?php echo $csum196sd; ?>" />
<input type="hidden" name="cases" id="cases" value="<?php echo $cases; ?>" />
<input type="hidden" name="larval" id="larval" value="<?php echo $larval; ?>" />
<input type="hidden" name="immediate_cases" id="immediate_cases" value="<?php echo $immediate_cases; ?>" />

<input type="hidden" name="tquartile" id="tquartile" value="" />
<input type="hidden" name="tcsum" id="tcsum" value="" />
<input type="hidden" name="tm2sd2" id="tm2sd2" value="" />
<input type="hidden" name="tcsum196sd" id="tcsum196sd" value="" />
<input type="hidden" name="tcases" id="tcases" value="" />



<body onload="load()">


</body>
</div>


</div>


<?php $this->load->view('templates/footer'); ?>
</html>