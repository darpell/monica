<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<table  border="1"  align="center">
<tr>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/testchart',$attributes); ?>
  <tr>
    <td width="100">Date of Entry:</td>
    <td width="200">From: <input type="text" style="background-color:#CCCCCC;" name="datefrom" id="date1" value="01/01/2011" readonly="true" /><a href="javascript:NewCal('date1','mmddyyyy')"><img src="<?php echo  $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> 
    <td>To: <input type="text" style="background-color:#CCCCCC;"name="dateto" id="date2" value="12/31/2013" readonly="true" /><a href="javascript:NewCal('date2','mmddyyyy')"><img src="<?php echo $this->config->item('base_url'); ?>/application/views/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></td> 
 
  </tr>
  <tr>
  <td width="450">&nbsp;</td>
  <td width="100">&nbsp;</td>
  <td> <input type="submit" class="submitButton" value="View"/><?php echo form_close(); ?></td>
  </tr>
	</table>
<p />
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>