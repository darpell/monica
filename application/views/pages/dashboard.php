<!-- HEADER -->
<?php $this->load->view('templates/header');?>


    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls','corechart','gauge']});
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

		 var epi = google.visualization.arrayToDataTable([
		            ['Label', 'Value'],
		         	['3rd Quartile', Math.round(((cases[ today2.getMonth()]/quartile[ today2.getMonth()]))*100)],
		            ['C-SUM', Math.round(((cases[ today2.getMonth()]/csum[ today2.getMonth()]))*100)],
		            ['mean+2SD', Math.round(((cases[ today2.getMonth()]/m2sd[ today2.getMonth()]))*100)],
		            ['C-SUM+1.96SD', Math.round(((cases[ today2.getMonth()]/csum196sd[ today2.getMonth()]))*100)],
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
        var data = google.visualization.arrayToDataTable([
       	['Barangay', yyyy, yyyy-1],
        ['Langkaan II',  parseInt(mn1),      parseInt(m1)],
        ['Sampaloc I',  parseInt(mn2),      parseInt(m2)],
        ['San Agustin I',  parseInt(mn3),     parseInt(m3)],
        ['San Agustin III',  parseInt(mn4),      parseInt(m4)]
        ]);
              // Instantiate and draw our chart, passing in some options.
              var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
              chart.draw(data, options);
              new google.visualization.Gauge(document.getElementById('visualization')).
              draw(epi,epioptions);
      }

      google.setOnLoadCallback(drawVisualization);
    </script>
  <div class="body">
   <center>
   <h3>Epidemic Threshold shown in Percentage</h3>
   <div id="visualization" style="width: 600px; height: 150px;"></div>
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
   <div id='chart_div'></div>
   
   
</center>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/view_tasks',$attributes); ?>

		<div class="blog">

<input type="hidden" name="table_data" id="table_data" value="<?php echo $table_data; ?>" />
<input type="hidden" name="barangay_count" id="barangay_count" value="<?php echo $barangay_count; ?>" />
<input type="hidden" name="age_count" id="age_count" value="<?php echo $age_count; ?>" />
<input type="hidden" name="quartile" id="quartile" value="<?php echo $quartile; ?>" />
<input type="hidden" name="csum" id="csum" value="<?php echo $csum; ?>" />
<input type="hidden" name="m2sd" id="m2sd" value="<?php echo $m2sd; ?>" />
<input type="hidden" name="csum196sd" id="csum196sd" value="<?php echo $csum196sd; ?>" />
<input type="hidden" name="cases" id="cases" value="<?php echo $cases; ?>" />
</div>


<?php $this->load->view('templates/footer'); ?>
</html>