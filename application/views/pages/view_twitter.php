<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
		<center>Tweet Status</center>
<table  border="1"  align="center">
<tr>
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('case_report/testchart',$attributes); ?>
  <tr>
    <td></td>
    <td>From: <input type="text" style="background-color:#CCCCCC;" name="datefrom" id="date1" value="01/01/2011" readonly="true" OnClick="javascript:NewCal('date1','mmddyyyy')"/></td>
    <td></td>>
  </tr>
  <tr>
  <td width="450">&nbsp;</td>
  <td width="100">&nbsp;</td>
  <td> <input type="submit" class="submitButton" value="Tweet"/><?php echo form_close(); ?></td>
  </tr>
	</table>
<p />
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>