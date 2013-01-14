<?php 
$attributes = array(
						'id' => 'TPlogin'
					);
echo form_open('login/check',$attributes); ?>
<h3>Login</h3>
<?php if($result != null) echo '<h5><label style="color:red">Username and Password does not match.</label></h5>'?>
 <h5>Username:</h5>
<label style="color:red"><?php echo form_error('TPusername-txt'); ?></label>
<input type="text" name="TPusername-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<h5>Password</h5>
<label style="color:red"><?php echo form_error('TPpassword-txt'); ?></label>
<input type="text" name="TPpassword-txt" value="<?php echo set_value('patientno'); ?>" size="50" />

<div><input type="submit" value="Submit" /></div>

</form>