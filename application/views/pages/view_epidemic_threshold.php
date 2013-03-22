<!-- HEADER -->
<?php $this->load->view('templates/header');?>
<head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
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
		 //datatable.addColumn('string', 'Epidemic Threshold');
		 datatable.addColumn('number', '3rd Quartile');
		 datatable.addColumn('number', 'Current year');
		 datatable.addColumn('number', 'mean+2SD');
		 datatable.addColumn('number', 'C-SUM+1.96SD');
		 datatable.addColumn('number', 'Current year');
			
		 for (var i = 0; i < data.length; i++)
			{
			 datatable.setCell(i, 0 , data2[i][0]);
			 datatable.setCell(i, 1 , data2[i][1]);
			 datatable.setCell(i, 2 , parseInt(data2[i][2]));
			 
					alert(data.length);
			}
		 
        var options = {
          title: 'Epidemic Threshold Chart'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(datatable, options);
      }
    </script>
  </head>

<!-- CONTENT -->
<div class="body">
		<div >
<center>
<?php if($table != null) {?>

<div>
<h3>Five years monthly record of cases (<?php echo (date('Y')-5).'-'.(date('Y')-1); ?>)</h3>
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
<h3>Epidemic Threshold For the Year <?php echo date('Y'); ?> and the current number of cases</h3>
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

echo $this->table->generate($arranged); 
?>
<br />

</div>
<?php } ?>
 <div id="chart_div" style="width: 900px; height: 500px;"></div>
</center>

<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/view_tasks',$attributes); ?>
<input type="hidden" name="chart_data" id="chart_data" value="<?php echo $chart_data; ?>" />

</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>