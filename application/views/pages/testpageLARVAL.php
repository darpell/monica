<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
		
TEST FOR ADDING LARVAL POSITIVE
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('suggested/testsubmitlarval',$attributes); ?>

   TPcontainer-txt_r<input type="text" name="TPcontainer-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>TPhousehold-txt_r<input type="text" name="TPhousehold-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  TPbarangay-txt_r <input type="text" name="TPbarangay-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
<br>   TPdate-txt_r <input type="text" name="TPdate-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  TPmunicipality-txt_r <input type="text" name="TPmunicipality-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  TPstreet-txt_r <input type="text" name="TPstreet-txt_r" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  lat<input type="text" name="lat" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  lng <input type="text" name="lng" value="<?php echo set_value('patientno'); ?>"  size="20"/>
  <br>
    <input type="submit" class="submitButton" value="SUBMIT"/><?php echo form_close(); ?>   

</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>