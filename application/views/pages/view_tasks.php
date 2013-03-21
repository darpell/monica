<!-- HEADER -->
<?php $this->load->view('templates/header');?>


    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Prepare the data
        var str = document.getElementById('table_data').value.toString();

					str = str.split("%%");
					var data2 = new Array();
					for (var i = 0; i < str.length; i++)
					{
						data2[i] = str[i].split("&&");
					}
					data2.pop();

   
        var categoryPicker = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control2',
          'options': {
            'filterColumnLabel': 'Status',
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
        var categoryPicker3 = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'control1',
            'options': {
              'filterColumnLabel': 'Name',
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
      
        // Create a dashboard
        new google.visualization.Dashboard(document.getElementById('dashboard')).
            // Establish bindings, declaring the both the slider and the category
            // picker will drive both charts.
            bind([categoryPicker,categoryPicker2,categoryPicker3], [ table]).
            // Draw the entire dashboard.
            draw(data2);
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  <div class="body">
   <center>
   <h3>Tasks Assigned For The Week</h3>
    <div id="dashboard">
      <table>
        <tr style='vertical-align: top'>
          <td style='width: 300px; font-size: 0.9em;'>
            <div id="control1"></div>
            <div id="control2"></div>
            <div id="control3"></div>
          </td>
          <td style='width: 600px'>
            <div style="float: left;" id="chart1"></div>
            <div style="float: left;" id="chart2"></div>
            <div style="float: left;" id="chart3"></div>
          </td>
        </tr>
      </table>
    </div>
</center>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('CHO/view_tasks',$attributes); ?>

		<div class="blog">
<h5>Name</h5>
<?php 

$shirts_on_sale = array('small', 'large');

echo form_dropdown('name', $options);

?>
<h5>Date of Task Assignment</h5>
<label style="color:red"><?php echo form_error('birthdate'); ?></label>
<input type="text" name="TPtaskdate-txt" readonly = "true" id = "date1"size="50" value = "<?php echo date('m/d/y');?>"onClick= "javascript:NewCal('date1','mmddyyyy')"/>
<h5>Task Header</h5>
<label style="color:red"><?php echo form_error('TPtaskhead-txt'); ?></label>
<input type="text" name="TPtaskhead-txt" size="100" />
<h5>Task</h5>
<label style="color:red"><?php echo form_error('TPtask-txt'); ?></label>
<input type="text" name="TPtask-txt" size="100" />
<input type="hidden" name="table_data" id="table_data" value="<?php echo $table_data; ?>" />
<div><input type="submit" value="Submit" /></div>
</div>


<?php $this->load->view('templates/footer'); ?>
</html>