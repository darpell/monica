<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
		
TEST FOR ADDING IMMEDIATE CASE
<?php 
$attributes = array(
						'id' => 'TPcr-form'
					);
echo form_open('suggested/testsubmitimcase',$attributes); ?>

   person_id<input type="text" name="person_id" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br> has_muscle_pain <input type="text" name="has_muscle_pain" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  has_joint_pain <input type="text" name="has_joint_pain" value="<?php echo set_value('patientno'); ?>"  size="20"/>
<br>   has_headache <input type="text" name="has_headache" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  has_bleeding <input type="text" name="has_bleeding" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  has_rashes <input type="text" name="has_rashes" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  days_fever <input type="text" name="duration" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  suspected_source <input type="text" name="source" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  remarks <input type="text" name="remarks" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  imcase_lat<input type="text" name="lat" value="<?php echo set_value('patientno'); ?>"  size="20"/>
 <br>  imcase_lng <input type="text" name="lng" value="<?php echo set_value('patientno'); ?>"  size="20"/>
  <br>
  household_id <input type="text" name="household_id" value="<?php echo set_value('patientno'); ?>"  size="20"/>
  
    <input type="submit" class="submitButton" value="SUBMIT"/><?php echo form_close(); ?>   

</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>