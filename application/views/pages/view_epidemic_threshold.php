<!-- HEADER -->
<?php $this->load->view('templates/header');?>
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["controls","gauge"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
          

    	  var str2 = document.getElementById('chart_data').value.toString();
  		str2 = str2.split("%%");
  		var data = new Array();
  		for (var i = 0; i < str2.length; i++)
  		{
  			data[i] = str2[i].split("&&");
  		}
  		data.pop();
		
  		var datatable = new google.visualization.DataTable();
		 datatable.addColumn('string', 'Month');
		 datatable.addColumn('number', '3rd Quartile');
		 datatable.addColumn('number', 'C-SUM');
		 datatable.addColumn('number', 'mean+2SD');
		 datatable.addColumn('number', 'C-SUM+1.96SD');
		 datatable.addColumn('number', 'Current year');
		 datatable.addRows(data[0].length);
		 for (var i = 0; i < data[0].length; i++)
			{
			 datatable.setCell(i, 0 , data[0][i]);
			 datatable.setCell(i, 1 ,parseInt( data[1][i]));
			 datatable.setCell(i, 2 , parseInt(data[2][i]));
			 datatable.setCell(i, 3 , parseInt(data[3][i]));
			 datatable.setCell(i, 4 ,parseInt( data[4][i]));
			 datatable.setCell(i, 5 , parseInt(data[5][i]));
			}

		    var columnsTable = new google.visualization.DataTable();
		    columnsTable.addColumn('number', 'colIndex');
		    columnsTable.addColumn('string', 'colLabel');
		    var initState= {selectedValues: []};
		    // put the columns into this data table (skip column 0)
		    for (var i = 1; i < datatable.getNumberOfColumns(); i++) {
		        columnsTable.addRow([i, datatable.getColumnLabel(i)]);
		        initState.selectedValues.push(datatable.getColumnLabel(i));
		    }

		    var chart = new google.visualization.ChartWrapper({
		        chartType: 'LineChart',
		        containerId: 'chart_div',
		        dataTable: datatable,
		        options: {
		            title: 'Fig. 1 Epidemic Threshold Chart',
		            titleTextStyle : { fontSize: 20},
		            height: 400
		        }
		    });

		    chart.draw();

		    var columnFilter = new google.visualization.ControlWrapper({
		        controlType: 'CategoryFilter',
		        containerId: 'colFilter_div',
		        dataTable: columnsTable,
		        options: {
		            filterColumnLabel: 'colLabel',
		            ui: {
		                label: 'Columns',
		                allowTyping: false,
		                allowMultiple: true,
		                selectedValuesLayout: 'belowStacked'
		            }
		        },
		        state: initState
		    });

		    google.visualization.events.addListener(columnFilter, 'statechange', function () {
		        var state = columnFilter.getState();
		        var row;
		        var columnIndices = [0];
		        for (var i = 0; i < state.selectedValues.length; i++) {
		            row = columnsTable.getFilteredRows([{column: 1, value: state.selectedValues[i]}])[0];
		            columnIndices.push(columnsTable.getValue(row, 0));
		        }
		        // sort the indices into their original order
		        columnIndices.sort(function (a, b) {
		            return (a - b);
		        });
		        chart.setView({columns: columnIndices});
		        chart.draw();
		    });

		    columnFilter.draw();

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
					

		    
            new google.visualization.Gauge(document.getElementById('visualization')).
            draw(epi,epioptions);
      }
    </script>
  </head>

<!-- CONTENT -->
<div class="body">
		<div >
<center><table>
<tr>
<td>
<h3> Barangay:</td><td> 
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);

echo form_open('CHO/epidemic_threshold',$attributes);
echo form_dropdown('barangay', $barangay,array($parameter => $parameter)); 
?>
<input type="hidden" name="chart_data" id="chart_data" value="<?php echo $chart_data; ?>" />
<input type="hidden" name="quartile" id="quartile" value="<?php echo $quartile; ?>" />
<input type="hidden" name="csum" id="csum" value="<?php echo $csum; ?>" />
<input type="hidden" name="m2sd" id="m2sd" value="<?php echo $m2sd; ?>" />
<input type="hidden" name="csum196sd" id="csum196sd" value="<?php echo $csum196sd; ?>" />
<input type="hidden" name="cases" id="cases" value="<?php echo $cases; ?>" />
<input type="submit" value="View" />
</h3>
</td>
</tr>
</table>

<div id="colFilter_div"></div>
<br />
<br />
<?php $this->load->view('pages/report_header_threshold');?>
 <br />
<br />
<center>
<table  style="width: 70%;">
<tr>
<td>
<h4>Status</h4>
<p>The epidemic threshold(3rd quartile) in <b><?php if($bar_text == 'All' OR $bar_text == null){echo 'all barangays of Dasmarinas';}else{echo $bar_text;}?>
</b> compared to its cases is at <b><?php echo $percent_text	?>% </b>for the month of <b><?php echo date('F') ?></b>.
<p>The difference between the epidemic threshold and number of cases is <b><?php echo $diff_text;?></b>.
</td>
</tr>
</table>
</center>
 <br />
<br />
 <div id="chart_div" style="width: 80%;"></div>

<?php if($table != null) {?>

<div>
<h3>Table 1. Five years monthly record of cases (<?php echo (date('Y')-5).'-'.(date('Y')-1); ?>)</h3>
<?php 

$tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="5" cellspacing="0" id="results" style="width: 70%;">',

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

echo $this->table->generate($table['data']); 
?>
<br />

</div>
<?php } ?>
</center>
</div>


		<div >
<center>
<?php if($table != null) {?>

<div>
<h3>Table 2. Epidemic Threshold For the Year <?php echo date('Y'); ?> and the current number of cases</h3>
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

echo $this->table->generate($arranged); 
?>
<br />

</div>
<?php } ?>
<div id="colFilter_div"></div>
 <div id="chart_div"></div>
</center>

</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>