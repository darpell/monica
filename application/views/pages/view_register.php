<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<div class="body">
		<div class="blog">
<?php 
$attributes = array(
						'id' => 'TPregister'
					);
echo form_open('login/add_user',$attributes); ?>
<h3>Registration</h3>
<?php if($result != null) echo '<h5><label style="color:red">The username is not available</label></h5>'?>
 <h5>Username:</h5>
<label style="color:red"><?php echo form_error('TPusername-txt'); ?></label>
<input type="text" name="TPusername-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Password</h5>
<label style="color:red"><?php echo form_error('TPpassword-txt'); ?></label>
<input type="password" name="TPpassword-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Repeat Password</h5>
<label style="color:red"><?php echo form_error('TPpassword2-txt'); ?></label>
<input type="password" name="TPpassword2-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>First Name</h5>
<label style="color:red"><?php echo form_error('TPfirstname-txt'); ?></label>
<input type="text" name="TPfirstname-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Middle Name</h5>
<label style="color:red"><?php echo form_error('TPmiddlename-txt'); ?></label>
<input type="text" name="TPmiddlename-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Last Name</h5>
<label style="color:red"><?php echo form_error('TPlastname-txt'); ?></label>
<input type="text" name="TPlastname-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>User Type</h5>
<label style="color:red"><?php echo form_error('sex'); ?></label>
<?php 
$options = array(
                  'Barangay Health Worker'  => 'Barangay Health Worker',
                  'DRU'    => 'DRU',
				  'CHO'    => 'City Health Officer'
                );
$js = 'id="TPtype-dd"';
echo form_dropdown('TPtype-dd', $options, 'Barangay Health Worker',$js);
?>

<div><input type="submit" value="Submit" /></div>

</form>
</div>
</div>
<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>