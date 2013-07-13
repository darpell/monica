<!-- HEADER -->
<?php $this->load->view('templates/header');?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
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
  		/*
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Barangay');
          for (var i = 0; i < year.length; i++) 
              {
          	 data.addColumn('number', year[i]);
          	}
        	*/
         
            
          var data = google.visualization.arrayToDataTable(data2,false);
          	

		var options = {
        title : 'Dengue cases arranged by barangay and year',
        vAxis: {title: "Cases"},
        hAxis: {title: "Barangay"},
        seriesType: "bars"
      };


        var chart = new google.visualization.ComboChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
<!-- CONTENT -->
<div class="body">
<center><h1>Dengue Profile</h1></center>
		<div class="blog">
<table    align="center" cellpadding="20">
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
<?php if($values_age != null) {?>
<div id="chart_div2"></div>
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





<input type="hidden" name="values_age" id="values_age" value="<?php echo $values_age; ?>" />
<input type="hidden" name="values_total" id="value_totals" value="<?php echo $values_total; ?>" />
<input type="hidden" name="barangay_list" id="barangay_list" value="<?php echo $barangay_list; ?>" />
<input type="hidden" name="year_list" id="year_list" value="<?php echo $year_list; ?>" />
<?php } ?>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>