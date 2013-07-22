<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
<center><h1>Case Investigations</h1></center>
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
</body>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>