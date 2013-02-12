<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<table  border="1"  align="center">
<tr>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('larval_survey/searchLarvalReport',$attributes); ?>
    <td>Tracking Number:</td>
    <td ><input type="text" id="TPtrack-txt" name="TPtrack-txt" /></td>
	
  </tr>
  <tr>
    <td width="100">Date of Entry:</td>
    <td width="200">From: <input type="text" style="background-color:#CCCCCC;" name="datefrom" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> 
    <td>To: <input type="text" style="background-color:#CCCCCC;"name="dateto" id="date2" value="01/01/2020" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> 
 
  </tr>
  <tr>
  <td width="100">Sort By:</td>
  <td><select name="TPsort-dd">
  <option value="tracking_number" selected="selected">Tracking Number</option>
  <option value="created_on">Date</option>
  </select>
  </td>
  </tr>
  <tr>
  <td width="450">&nbsp;</td>
  <td width="100">&nbsp;</td>
  <td> <input type="submit" class="submitButton" value="View"/><?php echo form_close(); ?></td>
  </tr>
	</table>
</div>
<p />


<?php if($table != null) {?>
<center>
<div>

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

echo $this->table->generate($table); 
?>
<br />
</center>
</div>
<?php } ?>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>