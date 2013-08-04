<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
		
TEST FOR ADDING INVESTIGATED CASE
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('suggested/testsubmitinv',$attributes); ?>

   patient_no<input type="text" name="patient_no" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br> lat <input type="text" name="lat" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  lng <input type="text" name="lng" value="<?php echo set_value('patientno'); ?>"  size="20"/>
<br>   TPremarks-txt_r <input type="text" name="TPremarks-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
  
    <input type="submit" class="submitButton" value="SUBMIT"/><?php echo form_close(); ?>   
			
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>