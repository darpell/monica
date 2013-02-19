<!-- HEADER -->
<?php $this->load->view('templates/header');?>

<!-- CONTENT -->
<?php 
$attributes = array(
						'id' => 'TPregister'
					);
echo form_open('login/approve_user',$attributes); ?>
<h3>Registration</h3>
<?php if($result != null) echo '<h5><label style="color:red">The username is not available</label></h5>'?>
 <h5>Username:</h5>
<label style="color:red"><?php echo form_error('TPusername-txt'); ?></label>
<input type="text" readonly = "true" style="background-color:#CCCCCC;" name="TPusername-txt" value="<?php echo $info['username']; ?>" size="50" />

<h5>First Name</h5>
<label style="color:red"><?php echo form_error('TPfirstname-txt'); ?></label>
<input type="text" readonly = "true" style="background-color:#CCCCCC;" name="TPfirstname-txt" value="<?php echo $info['firstname']; ?>" size="50" />

<h5>Middle Name</h5>
<label style="color:red"><?php echo form_error('TPmiddlename-txt'); ?></label>
<input type="text" readonly = "true" style="background-color:#CCCCCC;" name="TPmiddlename-txt" value="<?php echo $info['middlename']; ?>" size="50" />

<h5>Last Name</h5>
<label style="color:red"><?php echo form_error('TPlastname-txt'); ?></label>
<input type="text" readonly = "true" style="background-color:#CCCCCC;" name="TPlastname-txt" value="<?php echo $info['lastname']; ?>" size="50" />

<h5>User Type</h5>
<label style="color:red"><?php echo form_error('sex'); ?></label>
<?php 
$options = array(
                  'Barangay Health Worker'  => 'Barangay Health Worker',
                  'DRU'    => 'DRU',
				  'CHO'    => 'City Health Officer'
                );
$js = 'id="TPtype-dd"';
echo form_dropdown('TPtype-dd', $options, $info['usertype'],$js);
?>

<h5>User approval</h5>
<label style="color:red"><?php echo form_error('TPoutcome-rd'); ?></label>
<input type="radio" name="TPapproval-rd" value="Y" <?php echo set_radio('myradio', 'Y'); ?> /> Approved <br/>
<input type="radio" name="TPapproval-rd" value="N" <?php echo set_radio('myradio', 'N'); ?> /> Denied <br/>
<input type="radio" name="TPapproval-rd" value="U" <?php echo set_radio('myradio', 'U', TRUE); ?> /> Unapproved <br/>


<div><input type="submit" value="Submit" /></div>

</form>

<!-- FOOTER -->
<?php $this->load->view('templates/footer');?>